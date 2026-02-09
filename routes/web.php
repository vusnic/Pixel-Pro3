<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Admin\LeadController;
use App\Http\Controllers\Web\PortfolioController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Web\Admin\ContractController;
use App\Http\Controllers\Web\Admin\ContractTemplateController;
use App\Http\Controllers\Web\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Web\Admin\CategoryController;
use App\Http\Controllers\Web\Admin\TagController;
use App\Http\Controllers\Web\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes - React SPA
Route::get('/', function () {
    return view('react');
})->name('home');

// API routes for React SPA
// These routes serve JSON data to the React frontend
// Public data routes are already handled by /api endpoints

// Authentication routes - for guests (not authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout route - for authenticated users only
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes - for authenticated users only
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::put('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::get('/analytics-data', [DashboardController::class, 'getAnalyticsData'])->name('dashboard.analytics');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Leads Management
    Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('leads/export-pdf', [LeadController::class, 'exportToPdf'])->name('leads.export-pdf');
    Route::get('leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::put('leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.update.status');
    Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    
    // Rotas de gerenciamento de portfólio
    Route::resource('portfolio', App\Http\Controllers\Web\Admin\PortfolioController::class);
    Route::get('portfolio-categories', [App\Http\Controllers\Web\Admin\PortfolioController::class, 'categories'])->name('portfolio.categories');
    
    // Rotas de gerenciamento de serviços
    Route::resource('services', AdminServiceController::class);
    
    // Rotas de gerenciamento de blog
    Route::resource('blog', AdminBlogController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    
    // Rotas de gerenciamento de modelos de contratos
    Route::resource('contract-templates', ContractTemplateController::class);
    Route::get('contract-templates/{contractTemplate}/download', [ContractTemplateController::class, 'download'])->name('contract-templates.download');
    Route::get('contract-templates-verify', [ContractTemplateController::class, 'verifyAndRepairTemplates'])->name('contract-templates.verify');
    
    // Rotas de gerenciamento de contratos
    Route::get('contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('contracts/create-from-template', [ContractController::class, 'createFromTemplate'])->name('contracts.create-from-template');
    Route::get('contracts/create-from-template', [ContractController::class, 'createFromTemplate']);
    Route::post('contracts/generate', [ContractController::class, 'generate'])->name('contracts.generate');
    Route::get('contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
    Route::get('contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');
    Route::delete('contracts/{contract}', [ContractController::class, 'destroy'])->name('contracts.destroy');
});

// Fallback para React Router (SPA) - deve ser a última rota
Route::get('/{any}', function () {
    return view('react');
})->where('any', '.*');
