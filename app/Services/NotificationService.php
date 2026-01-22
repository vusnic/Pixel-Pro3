<?php

namespace App\Services;

use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class NotificationService
{
    /**
     * Envia uma notificação push para um usuário específico
     *
     * @param int $userId ID do usuário para enviar a notificação
     * @param string $title Título da notificação
     * @param string $body Corpo da notificação
     * @param array $data Dados adicionais para enviar com a notificação
     * @return array Resultados do envio
     */
    public function sendToUser(int $userId, string $title, string $body, array $data = []): array
    {
        try {
            // Busca os tokens do usuário
            $tokens = DeviceToken::where('user_id', $userId)
                ->where('is_active', true)
                ->pluck('token')
                ->toArray();

            if (empty($tokens)) {
                return [
                    'success' => false,
                    'message' => 'No active device tokens found for this user'
                ];
            }

            // Prepara os dados da notificação
            $notificationData = array_merge([
                'type' => 'notification',
                'time' => now()->toIso8601String(),
                'user_id' => $userId
            ], $data);

            // Configura a mensagem
            $message = CloudMessage::new()
                ->withNotification([
                    'title' => $title,
                    'body' => $body,
                ])
                ->withData($notificationData);

            return $this->sendToTokens($tokens, $message);
        } catch (\Exception $e) {
            Log::error('Error sending notification to user: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Error sending notification',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Envia uma notificação para múltiplos usuários
     *
     * @param array $userIds IDs dos usuários
     * @param string $title Título da notificação
     * @param string $body Corpo da notificação
     * @param array $data Dados adicionais
     * @return array Resultados do envio
     */
    public function sendToUsers(array $userIds, string $title, string $body, array $data = []): array
    {
        $results = [];
        
        foreach ($userIds as $userId) {
            $results[$userId] = $this->sendToUser($userId, $title, $body, $data);
        }
        
        return $results;
    }

    /**
     * Envia notificação para todos os usuários com um perfil específico
     *
     * @param string $role Perfil dos usuários (admin, salesperson, developer)
     * @param string $title Título da notificação
     * @param string $body Corpo da notificação
     * @param array $data Dados adicionais
     * @return array Resultados do envio
     */
    public function sendToRole(string $role, string $title, string $body, array $data = []): array
    {
        try {
            $userIds = User::where('role', $role)->pluck('id')->toArray();
            
            if (empty($userIds)) {
                return [
                    'success' => false,
                    'message' => "No users found with role '$role'"
                ];
            }
            
            return $this->sendToUsers($userIds, $title, $body, $data);
        } catch (\Exception $e) {
            Log::error('Error sending notification to role: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Error sending notification to role',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Método interno para enviar uma notificação para um conjunto de tokens
     *
     * @param array $tokens Tokens FCM
     * @param CloudMessage $message Mensagem a ser enviada
     * @return array Resultados do envio
     */
    private function sendToTokens(array $tokens, CloudMessage $message): array
    {
        // Inicializa o Firebase Messaging
        $messaging = Firebase::messaging();
        
        // Envia a mensagem para cada token
        $responses = [];
        $successCount = 0;
        $failureCount = 0;
        
        foreach ($tokens as $token) {
            try {
                $result = $messaging->sendToDevice($token, $message);
                
                if ($result->hasSuccessfulResults()) {
                    $successCount++;
                }
                
                if ($result->hasFailures()) {
                    $failureCount++;
                    
                    // Se o token é inválido, inative-o
                    foreach ($result->failures() as $failure) {
                        if (in_array($failure->error()->getMessage(), [
                            'The registration token is not a valid FCM registration token',
                            'The registration token is not registered for the specified project',
                            'The registration token has expired'
                        ])) {
                            DeviceToken::where('token', $token)->update(['is_active' => false]);
                            break;
                        }
                    }
                }
                
                $responses[] = [
                    'token' => $token,
                    'success' => $result->hasSuccessfulResults(),
                    'result' => $result
                ];
            } catch (\Exception $e) {
                $failureCount++;
                $responses[] = [
                    'token' => $token,
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        }
        
        return [
            'success' => true,
            'message' => "Notification sent to $successCount devices with $failureCount failures",
            'results' => [
                'success_count' => $successCount,
                'failure_count' => $failureCount,
                'details' => $responses
            ]
        ];
    }
} 