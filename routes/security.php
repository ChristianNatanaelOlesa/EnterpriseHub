<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\MenuController;

Route::middleware('auth')
    ->prefix('security')
    ->name('security.')
    ->group(function () {

        // =========================
        // USERS
        // =========================

        Route::post(
            'users/{user}/reset-password',
            [UserController::class, 'resetPassword']
        )->name('users.reset-password')
          ->middleware(
              'permission:security.users.index,CanEdit'
          );

        Route::post(
            'users/{user}/toggle-status',
            [UserController::class, 'toggleStatus']
        )->name('users.toggle-status')
          ->middleware(
              'permission:security.users.index,CanEdit'
          );

        Route::resource('users', UserController::class)
            ->middlewareFor(
                'index',
                'permission:security.users.index,CanOpen'
            )
            ->middlewareFor(
                'create',
                'permission:security.users.index,CanAdd'
            )
            ->middlewareFor(
                'store',
                'permission:security.users.index,CanAdd'
            )
            ->middlewareFor(
                'show',
                'permission:security.users.index,CanOpen'
            )
            ->middlewareFor(
                'edit',
                'permission:security.users.index,CanEdit'
            )
            ->middlewareFor(
                'update',
                'permission:security.users.index,CanEdit'
            )
            ->middlewareFor(
                'destroy',
                'permission:security.users.index,CanDelete'
            );


        // =========================
        // ROLES
        // =========================

        Route::resource('roles', RoleController::class)
            ->middlewareFor(
                'index',
                'permission:security.roles.index,CanOpen'
            )
            ->middlewareFor(
                'create',
                'permission:security.roles.index,CanAdd'
            )
            ->middlewareFor(
                'store',
                'permission:security.roles.index,CanAdd'
            )
            ->middlewareFor(
                'show',
                'permission:security.roles.index,CanOpen'
            )
            ->middlewareFor(
                'edit',
                'permission:security.roles.index,CanEdit'
            )
            ->middlewareFor(
                'update',
                'permission:security.roles.index,CanEdit'
            )
            ->middlewareFor(
                'destroy',
                'permission:security.roles.index,CanDelete'
            );


        // =========================
        // MENUS
        // =========================

        Route::resource('menus', MenuController::class)
    ->middlewareFor(
        'index',
        'permission:security.menus.index,CanOpen'
    )
    ->middlewareFor(
        'create',
        'permission:security.menus.index,CanAdd'
    )
    ->middlewareFor(
        'store',
        'permission:security.menus.index,CanAdd'
    )
    ->middlewareFor(
        'show',
        'permission:security.menus.index,CanOpen'
    )
    ->middlewareFor(
        'edit',
        'permission:security.menus.index,CanEdit'
    )
    ->middlewareFor(
        'update',
        'permission:security.menus.index,CanEdit'
    )
    ->middlewareFor(
        'destroy',
        'permission:security.menus.index,CanDelete'
    );

    });
