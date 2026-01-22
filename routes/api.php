<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rotas de autenticação
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::get('/email/verified', function () {
    return response()->json(['message' => __('api.auth.email_verified')]);
})->name('verification.verified');

// Rota pública para criação de leads
Route::post('/leads', [LeadController::class, 'store']);

// Rotas protegidas para gerenciamento de leads
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/leads', [LeadController::class, 'index']);
    Route::get('/leads/{id}', [LeadController::class, 'show']);
    Route::put('/leads/{id}', [LeadController::class, 'update']);
    Route::delete('/leads/{id}', [LeadController::class, 'destroy']);
    Route::get('/leads-stats', [LeadController::class, 'stats']);
});

// Rotas da API para o portfólio
Route::get('/portfolio', [PortfolioController::class, 'index']);
Route::get('/portfolio/categories', [PortfolioController::class, 'categories']);
Route::get('/portfolio/{id}', [PortfolioController::class, 'show']);

// Rotas da API para serviços
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/featured', [ServiceController::class, 'featured']);
Route::get('/services/{id}', [ServiceController::class, 'show']);

// Rotas para notificações push
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/notifications/token', [NotificationController::class, 'registerToken']);
    Route::post('/notifications/remove-token', [NotificationController::class, 'removeToken']);
    Route::post('/notifications/test', [NotificationController::class, 'sendTestNotification']);
});

// Rotas da API que requerem autenticação
Route::middleware('auth:sanctum')->group(function () {
    // Rotas protegidas de portfólio
    Route::post('/portfolio', [PortfolioController::class, 'store']);
    Route::put('/portfolio/{id}', [PortfolioController::class, 'update']);
    Route::delete('/portfolio/{id}', [PortfolioController::class, 'destroy']);
    
    // Rotas protegidas de serviços
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    // Rotas de perfil de usuário
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::post('/profile', [ProfileController::class, 'updateProfile']);
    Route::get('/profile/completion', [ProfileController::class, 'getProfileCompletion']);
    Route::post('/profile/phone/verify/request', [ProfileController::class, 'requestPhoneVerification']);
    Route::post('/profile/phone/verify', [ProfileController::class, 'verifyPhone']);

    // Rotas de notificações
    Route::post('/notifications/device-token', [NotificationController::class, 'registerDeviceToken']);
    Route::delete('/notifications/device-token', [NotificationController::class, 'removeDeviceToken']);
}); 