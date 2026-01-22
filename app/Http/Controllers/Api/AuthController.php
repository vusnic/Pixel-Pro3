<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['nullable', 'string', 'in:admin,salesperson,developer'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role ?? 'salesperson',
        ]);

        event(new Registered($user));

        // For API requests, return a token
        if ($request->wantsJson() || $request->is('api/*')) {
            $token = $user->createToken('auth_token')->plainTextToken;
            $refreshToken = Str::random(60);
            
            // Store refresh token
            $user->forceFill([
                'refresh_token' => hash('sha256', $refreshToken),
                'refresh_token_expiry' => Carbon::now()->addDays(30),
            ])->save();
            
            return response()->json([
                'user' => $user,
                'tokens' => [
                    'access_token' => $token,
                    'refresh_token' => $refreshToken,
                    'token_type' => 'Bearer',
                    'expires_in' => config('sanctum.expiration') * 60, // in seconds
                ],
                'message' => __('api.auth.register_success')
            ], 201);
        }

        // For web, use session-based authentication
        Auth::login($user);

        return response()->json([
            'user' => $user,
            'message' => __('api.auth.register_success')
        ], 201);
    }

    /**
     * Authenticate user
     */
    public function login(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $request->validate([
            'email' => ['required', 'string', 'email:rfc,dns'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // For API requests, return a token
            if ($request->wantsJson() || $request->is('api/*')) {
                $user = Auth::user();
                
                // Revoke previous tokens if needed
                if ($request->has('revoke_previous') && $request->revoke_previous) {
                    $user->tokens()->delete();
                }
                
                $token = $user->createToken('auth_token')->plainTextToken;
                $refreshToken = Str::random(60);
                
                // Store refresh token
                $user->forceFill([
                    'refresh_token' => hash('sha256', $refreshToken),
                    'refresh_token_expiry' => Carbon::now()->addDays(30),
                ])->save();
                
                return response()->json([
                    'user' => $user,
                    'tokens' => [
                        'access_token' => $token,
                        'refresh_token' => $refreshToken,
                        'token_type' => 'Bearer',
                        'expires_in' => config('sanctum.expiration') * 60, // in seconds
                    ],
                    'message' => __('api.auth.login_success')
                ]);
            }
            
            // For web, use session-based authentication
            $request->session()->regenerate();

            return response()->json([
                'user' => Auth::user(),
                'message' => __('api.auth.login_success')
            ]);
        }

        return response()->json([
            'message' => __('api.auth.invalid_credentials')
        ], 401);
    }

    /**
     * Refresh access token using refresh token
     */
    public function refreshToken(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $request->validate([
            'refresh_token' => 'required|string',
        ]);

        $refreshToken = $request->refresh_token;
        $hashedToken = hash('sha256', $refreshToken);
        
        $user = User::where('refresh_token', $hashedToken)
            ->where('refresh_token_expiry', '>', now())
            ->first();
            
        if (!$user) {
            return response()->json([
                'message' => __('api.auth.invalid_token')
            ], 401);
        }
        
        // Revoke all of the user's existing tokens
        $user->tokens()->delete();
        
        // Create a new token
        $token = $user->createToken('auth_token')->plainTextToken;
        $newRefreshToken = Str::random(60);
        
        // Update refresh token
        $user->forceFill([
            'refresh_token' => hash('sha256', $newRefreshToken),
            'refresh_token_expiry' => Carbon::now()->addDays(30),
        ])->save();
        
        return response()->json([
            'tokens' => [
                'access_token' => $token,
                'refresh_token' => $newRefreshToken,
                'token_type' => 'Bearer',
                'expires_in' => config('sanctum.expiration') * 60, // in seconds
            ],
            'message' => __('api.auth.token_refresh_success')
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        // For API requests, revoke the token
        if ($request->wantsJson() || $request->is('api/*')) {
            if ($request->user()) {
                // Clear refresh token
                $request->user()->forceFill([
                    'refresh_token' => null,
                    'refresh_token_expiry' => null,
                ])->save();
                
                // Revoke access token
                $request->user()->currentAccessToken()->delete();
            }
            
            return response()->json([
                'message' => __('api.auth.logout_success')
            ]);
        }
        
        // For web, use session-based logout
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => __('api.auth.logout_success')
        ]);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        return response()->json([
            'user' => $request->user()
        ]);
    }
    
    /**
     * Send email verification link
     */
    public function sendVerificationEmail(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => __('api.auth.email_already_verified')
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => __('api.auth.verification_sent')
        ]);
    }
    
    /**
     * Verify email
     */
    public function verifyEmail(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $user = User::find($request->route('id'));
        
        if (!$user) {
            return response()->json([
                'message' => __('api.auth.user_not_found')
            ], 404);
        }
        
        $hash = sha1($user->getEmailForVerification());
        
        if ($hash !== $request->route('hash')) {
            return response()->json([
                'message' => __('api.auth.invalid_verification')
            ], 403);
        }
        
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => __('api.auth.email_already_verified')
            ]);
        }
        
        $user->email_verified_at = now();
        $user->save();
        
        event(new Verified($user));
        
        return response()->json([
            'message' => __('api.auth.email_verified')
        ]);
    }
    
    /**
     * Set application locale based on request
     */
    protected function setLocale(Request $request)
    {
        // Set locale from request header or parameter
        $locale = $request->header('Accept-Language') ?? $request->input('locale') ?? config('app.locale');
        
        // Make sure locale is in supported locales
        $locale = in_array($locale, ['en', 'pt-BR', 'es']) ? $locale : config('app.locale');
        
        App::setLocale($locale);
    }

    /**
     * Send a password reset link to the given user
     */
    public function forgotPassword(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $request->validate([
            'email' => ['required', 'email:rfc,dns'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => __('api.auth.reset_link_sent')
            ]);
        }

        return response()->json([
            'message' => __($status)
        ], 400);
    }

    /**
     * Reset the user's password
     */
    public function resetPassword(Request $request)
    {
        // Set locale from request if available
        $this->setLocale($request);
        
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => __('api.auth.password_reset_success')
            ]);
        }

        return response()->json([
            'message' => __($status)
        ], 400);
    }
} 