<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Set the request locale
     */
    protected function setLocale(Request $request)
    {
        if ($request->hasHeader('Accept-Language')) {
            App::setLocale($request->header('Accept-Language'));
        }
    }

    /**
     * Get current user's profile including completion status
     */
    public function getProfile(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $user = $request->user();
        
        // Calculate profile completion
        $completionPercentage = $this->calculateProfileCompletion($user);
        
        return response()->json([
            'user' => $user,
            'profile_completion' => [
                'percentage' => $completionPercentage,
                'email_verified' => !empty($user->email_verified_at),
                'phone_verified' => !empty($user->phone_verified_at),
                'profile_completed' => $user->profile_completed,
            ],
            'message' => __('api.profile.get_success')
        ]);
    }
    
    /**
     * Get profile completion status
     */
    public function getProfileCompletion(Request $request)
    {
        $this->setLocale($request);
        
        $user = $request->user();
        
        // Forçar phone_verified_at como preenchido
        if (!$user->phone_verified_at) {
            $user->phone_verified_at = now();
            $user->save();
        }
        
        $completionPercentage = $this->calculateProfileCompletion($user);
        
        return response()->json([
            'percentage' => $completionPercentage,
            'email_verified' => !empty($user->email_verified_at),
            'phone_verified' => !empty($user->phone_verified_at),
            'profile_completed' => $completionPercentage >= 100
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $user = $request->user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => 'sometimes|string|max:20',
            'country_code' => 'sometimes|string|max:5',
            'company' => 'sometimes|string|max:255',
            'job_title' => 'sometimes|string|max:255',
            'bio' => 'sometimes|string|max:1000',
            'profile_photo' => 'sometimes|image|mimes:jpeg,png,jpg|max:10000',
            'password' => 'sometimes|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('api.validation_error'),
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Atualiza os campos do usuário
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $request->email !== $user->email) {
            $user->email = $request->email;
            $user->email_verified_at = null; // Requer nova verificação
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
            $user->phone_verified_at = null; // Requer nova verificação
        }
        
        if ($request->has('country_code')) {
            $user->country_code = $request->country_code;
        }

        if ($request->has('company')) {
            $user->company = $request->company;
        }
        
        if ($request->has('job_title')) {
            $user->job_title = $request->job_title;
        }

        if ($request->has('bio')) {
            $user->bio = $request->bio;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        // Lida com o upload da foto de perfil
        if ($request->hasFile('profile_photo')) {
            // Remove a foto antiga se existir
            if ($user->profile_photo && Storage::exists('public/profile/' . $user->profile_photo)) {
                Storage::delete('public/profile/' . $user->profile_photo);
            }

            $file = $request->file('profile_photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile', $filename);
            
            $user->profile_photo = $filename;
        }
        
        // Log dos dados antes de salvar
        \Log::info('Atualizando perfil do usuário', [
            'user_id' => $user->id,
            'name' => $user->name,
            'company' => $user->company,
            'job_title' => $user->job_title,
            'bio' => $user->bio
        ]);
        
        // Calculate profile completion
        $completionPercentage = $this->calculateProfileCompletion($user);
        $user->profile_completion_percentage = $completionPercentage;
        
        // Mark profile as completed if all required fields are filled and verified
        if ($completionPercentage == 100) {
            $user->profile_completed = true;
        }
        
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => trans('api.profile_updated'),
            'data' => $user
        ]);
    }
    
    /**
     * Request phone verification code
     */
    public function requestPhoneVerification(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $user = $request->user();
        
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('api.validation_error'),
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Atualiza o telefone se for diferente
        if ($request->phone !== $user->phone) {
            $user->phone = $request->phone;
            $user->phone_verified_at = null;
            $user->save();
        }
        
        // Gera um código de verificação de 6 dígitos
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Armazena o código no banco de dados (temporariamente na sessão para este exemplo)
        $user->phone_verification_code = $verificationCode;
        $user->phone_verification_expires_at = now()->addMinutes(15);
        $user->save();
        
        // TODO: Implementar o envio real do SMS na versão de produção
        // Por enquanto, apenas retorna o código para testes
        return response()->json([
            'success' => true,
            'message' => trans('api.verification_code_sent'),
            'test_code' => $verificationCode // Apenas para testes, remover em produção
        ]);
    }
    
    /**
     * Verify phone with verification code
     */
    public function verifyPhone(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $user = $request->user();
        
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:6',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('api.validation_error'),
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Verifica se o código está correto e não expirou
        if ($user->phone_verification_code !== $request->code) {
            return response()->json([
                'success' => false,
                'message' => trans('api.invalid_verification_code')
            ], 422);
        }

        if ($user->phone_verification_expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => trans('api.verification_code_expired')
            ], 422);
        }
        
        // Marca o telefone como verificado
        $user->phone_verified_at = now();
        $user->phone_verification_code = null;
        $user->phone_verification_expires_at = null;
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => trans('api.phone_verified'),
            'data' => [
                'phone' => $user->phone,
                'phone_verified_at' => $user->phone_verified_at
            ]
        ]);
    }
    
    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion(User $user)
    {
        $completionItems = [
            // Basic info
            !empty($user->name) && strlen($user->name) >= 3,
            !empty($user->email),
            !empty($user->phone),
            
            // Verifications  
            !empty($user->email_verified_at),
            !empty($user->phone_verified_at),
            
            // Additional info
            !empty($user->company),
            !empty($user->job_title),
            !empty($user->bio)
        ];
        
        $completedItems = array_filter($completionItems, function($item) {
            return $item === true;
        });
        
        $completionPercentage = round((count($completedItems) / count($completionItems)) * 100);
        
        return $completionPercentage;
    }
}
