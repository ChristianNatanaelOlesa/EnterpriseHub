<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\MenuController;

Route::middleware('auth')
    ->prefix('security')
    ->name('security.')
    ->group(function () {

        // Route khusus HARUS di atas resource
        Route::post(
            'users/{user}/reset-password',
            [UserController::class, 'resetPassword']
        )->name('users.reset-password');

        Route::post(
            'users/{user}/toggle-status',
            [UserController::class, 'toggleStatus']
        )->name('users.toggle-status');

        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('menus', MenuController::class);

    });
