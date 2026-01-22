<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;

class NotificationController extends Controller
{
    /**
     * O serviço de notificações
     *
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * Construtor do controlador
     *
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Registra um novo token de dispositivo para notificações push
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function registerToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'device_type' => 'required|string|in:android,ios,web',
            'device_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'message' => trans('api.notifications.validation_error'),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Obtém o usuário autenticado
            $user = $request->user();
            
            if (!$user) {
                return Response::json([
                    'success' => false,
                    'message' => trans('api.notifications.unauthorized')
                ], 401);
            }

            // Verifica se o token já existe para este usuário
            $existingToken = DeviceToken::where('user_id', $user->id)
                ->where('token', $request->token)
                ->first();

            if ($existingToken) {
                // Atualiza o token existente
                $existingToken->update([
                    'device_type' => $request->device_type,
                    'device_name' => $request->device_name,
                    'is_active' => true,
                    'last_used_at' => Carbon::now(),
                ]);

                return Response::json([
                    'success' => true,
                    'message' => trans('api.notifications.device_token_updated'),
                    'data' => $existingToken
                ]);
            }

            // Cria um novo token
            $deviceToken = DeviceToken::create([
                'user_id' => $user->id,
                'token' => $request->token,
                'device_type' => $request->device_type,
                'device_name' => $request->device_name,
                'is_active' => true,
                'last_used_at' => Carbon::now(),
            ]);

            return Response::json([
                'success' => true,
                'message' => trans('api.notifications.device_token_registered'),
                'data' => $deviceToken
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error registering device token: ' . $e->getMessage());
            
            return Response::json([
                'success' => false,
                'message' => trans('api.notifications.error_sending_notification'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove um token de dispositivo
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function removeToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'message' => trans('api.notifications.validation_error'),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Obtém o usuário autenticado
            $user = $request->user();
            
            if (!$user) {
                return Response::json([
                    'success' => false,
                    'message' => trans('api.notifications.unauthorized')
                ], 401);
            }

            // Inativa o token em vez de excluí-lo
            $token = DeviceToken::where('user_id', $user->id)
                ->where('token', $request->token)
                ->first();

            if (!$token) {
                return Response::json([
                    'success' => false,
                    'message' => trans('api.notifications.token_not_found')
                ], 404);
            }

            $token->update([
                'is_active' => false
            ]);

            return Response::json([
                'success' => true,
                'message' => trans('api.notifications.device_token_removed')
            ]);

        } catch (\Exception $e) {
            Log::error('Error removing device token: ' . $e->getMessage());
            
            return Response::json([
                'success' => false,
                'message' => trans('api.notifications.error_sending_notification'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Envia uma notificação de teste para um usuário específico
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendTestNotification(Request $request): JsonResponse
    {
        try {
            // Apenas administradores podem enviar notificações de teste
            if (!$request->user() || !$request->user()->isAdmin()) {
                return Response::json([
                    'success' => false,
                    'message' => trans('api.notifications.unauthorized')
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string',
                'body' => 'required|string',
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'success' => false,
                    'message' => trans('api.notifications.validation_error'),
                    'errors' => $validator->errors()
                ], 422);
            }

            // Usa o serviço para enviar a notificação
            $result = $this->notificationService->sendToUser(
                $request->user_id,
                $request->title,
                $request->body,
                ['type' => 'test']
            );

            return Response::json($result);

        } catch (\Exception $e) {
            Log::error('Error sending test notification: ' . $e->getMessage());
            
            return Response::json([
                'success' => false,
                'message' => trans('api.notifications.error_sending_notification'),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
