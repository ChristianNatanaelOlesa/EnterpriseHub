<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\MenuController;
use App\Http\Controllers\Security\PermissionController;

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
              'permission:security.users.index,Update'
          );

        Route::post(
            'users/{user}/toggle-status',
            [UserController::class, 'toggleStatus']
        )->name('users.toggle-status')
          ->middleware(
              'permission:security.users.index,Update'
          );

        Route::get(
            'users/{user}/roles',
            [UserController::class, 'showRoles']
        )->name('users.roles')
          ->middleware(
              'permission:security.users.index,View'
          );

        Route::resource('users', UserController::class)->except(['show'])
            ->middlewareFor(
                'index',
                'permission:security.users.index,View'
            )
            ->middlewareFor(
                'create',
                'permission:security.users.index,Create'
            )
            ->middlewareFor(
                'store',
                'permission:security.users.index,Create'
            )
            ->middlewareFor(
                'edit',
                'permission:security.users.index,Update'
            )
            ->middlewareFor(
                'update',
                'permission:security.users.index,Update'
            )
            ->middlewareFor(
                'destroy',
                'permission:security.users.index,Delete'
            );


        // =========================
        // ROLES
        // =========================

        Route::resource('roles', RoleController::class)->except(['show'])
            ->middlewareFor(
                'index',
                'permission:security.roles.index,View'
            )
            ->middlewareFor(
                'create',
                'permission:security.roles.index,Create'
            )
            ->middlewareFor(
                'store',
                'permission:security.roles.index,Create'
            )
            ->middlewareFor(
                'edit',
                'permission:security.roles.index,Update'
            )
            ->middlewareFor(
                'update',
                'permission:security.roles.index,Update'
            )
            ->middlewareFor(
                'destroy',
                'permission:security.roles.index,Delete'
            );


        // =========================
        // MENUS
        // =========================

        Route::resource('menus', MenuController::class)->except(['show'])
    ->middlewareFor(
        'index',
        'permission:security.menus.index,View'
    )
    ->middlewareFor(
        'create',
        'permission:security.menus.index,Create'
    )
    ->middlewareFor(
        'store',
        'permission:security.menus.index,Create'
    )
    ->middlewareFor(
        'edit',
        'permission:security.menus.index,Update'
    )
    ->middlewareFor(
        'update',
        'permission:security.menus.index,Update'
    )
    ->middlewareFor(
        'destroy',
        'permission:security.menus.index,Delete'
    );

        // =========================
        // PERMISSIONS
        // =========================

        Route::resource('permissions', PermissionController::class)->except(['show'])
            ->middlewareFor('index', 'permission:security.permissions.index,View')
            ->middlewareFor('create', 'permission:security.permissions.index,Create')
            ->middlewareFor('store', 'permission:security.permissions.index,Create')
            ->middlewareFor('edit', 'permission:security.permissions.index,Update')
            ->middlewareFor('update', 'permission:security.permissions.index,Update')
            ->middlewareFor('destroy', 'permission:security.permissions.index,Delete');

    });
