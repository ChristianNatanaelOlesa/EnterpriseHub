<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Security\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'destroy'])
        ->name('logout');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'store'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'register'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'storeRegistration'])
        ->name('register.store');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');

});

require __DIR__.'/security.php';
require __DIR__.'/master.php';
require __DIR__.'/transaction.php';
require __DIR__.'/reporting.php';
require __DIR__.'/dashboard.php';
require __DIR__.'/setting.php';
