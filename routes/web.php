<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Security\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'destroy'])
        ->name('logout');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'store'])
        ->name('login.store');

});

require __DIR__.'/security.php';
require __DIR__.'/master.php';
require __DIR__.'/transaction.php';
require __DIR__.'/reporting.php';
require __DIR__.'/dashboard.php';
require __DIR__.'/setting.php';
