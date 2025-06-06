<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController; // <-- Add this line

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Client Management
    Route::resource('clients', ClientController::class);

    // Service Types
    Route::resource('service-types', ServiceTypeController::class)->except(['show']);

    // Contract Management
    Route::resource('contracts', ContractController::class);

    // Installation Management
    Route::resource('installations', InstallationController::class);

    // Reports Section
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/clients/download', [ReportController::class, 'downloadClientsReport'])->name('reports.clients.download');
    Route::get('/reports/contracts/download', [ReportController::class, 'downloadContractsReport'])->name('reports.contracts.download');
    Route::get('/reports/installations/download', [ReportController::class, 'downloadInstallationsReport'])->name('reports.installations.download');
    Route::get('/reports/contracts-by-service-type/download', [ReportController::class, 'downloadContractsByServiceTypeReport'])->name('reports.contracts_by_service_type.download');

    // User Management Routes <-- Add this block
    Route::resource('users', UserController::class);

    // Settings (if you plan to implement)
    Route::get('/settings', function() { return 'Settings Page'; })->name('settings.index');
});
