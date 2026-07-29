<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Security\AuthController;

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'store'])
        ->name('login.store');

});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'destroy'])
        ->name('logout');

});

Route::get('/', function () {
    return redirect('/login');
});

require __DIR__.'/security.php';
require __DIR__.'/master.php';
require __DIR__.'/transaction.php';
require __DIR__.'/reporting.php';
require __DIR__.'/dashboard.php';
require __DIR__.'/setting.php';
