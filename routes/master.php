<?php

use App\Http\Controllers\Master\CompanyController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\DirectorateController;
use App\Http\Controllers\Master\DivisionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('master')
    ->name('master.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */

        Route::resource('company', CompanyController::class)
            ->middlewareFor(
                'index',
                'permission:master.company.index,CanOpen'
            )
            ->middlewareFor(
                'show',
                'permission:master.company.index,CanOpen'
            )
            ->middlewareFor(
                'create',
                'permission:master.company.index,CanAdd'
            )
            ->middlewareFor(
                'store',
                'permission:master.company.index,CanAdd'
            )
            ->middlewareFor(
                'edit',
                'permission:master.company.index,CanEdit'
            )
            ->middlewareFor(
                'update',
                'permission:master.company.index,CanEdit'
            )
            ->middlewareFor(
                'destroy',
                'permission:master.company.index,CanDelete'
            );

        /*
        |--------------------------------------------------------------------------
        | Directorate
        |--------------------------------------------------------------------------
        */

        Route::resource('directorate', DirectorateController::class)
            ->middlewareFor(
                'index',
                'permission:master.directorate.index,CanOpen'
            )
            ->middlewareFor(
                'show',
                'permission:master.directorate.index,CanOpen'
            )
            ->middlewareFor(
                'create',
                'permission:master.directorate.index,CanAdd'
            )
            ->middlewareFor(
                'store',
                'permission:master.directorate.index,CanAdd'
            )
            ->middlewareFor(
                'edit',
                'permission:master.directorate.index,CanEdit'
            )
            ->middlewareFor(
                'update',
                'permission:master.directorate.index,CanEdit'
            )
            ->middlewareFor(
                'destroy',
                'permission:master.directorate.index,CanDelete'
            );

        /*
        |--------------------------------------------------------------------------
        | Division - AJAX
        |--------------------------------------------------------------------------
        */

        Route::get(
            'division/directorates',
            [DivisionController::class, 'getDirectorates']
        )
            ->middleware('permission:master.division.index,CanOpen')
            ->name('division.directorates');

        /*
        |--------------------------------------------------------------------------
        | Division
        |--------------------------------------------------------------------------
        */

        Route::resource('division', DivisionController::class)
            ->middlewareFor('index', 'permission:master.division.index,CanOpen')
            ->middlewareFor('show', 'permission:master.division.index,CanOpen')
            ->middlewareFor('create', 'permission:master.division.index,CanAdd')
            ->middlewareFor('store', 'permission:master.division.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.division.index,CanEdit')
            ->middlewareFor('update', 'permission:master.division.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.division.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | Department
        |--------------------------------------------------------------------------
        */

        Route::get(
            'department/directorates',
            [DepartmentController::class, 'getDirectorates']
        )
            ->middleware('permission:master.department.index,CanOpen')
            ->name('department.directorates');

        Route::get(
            'department/divisions',
            [DepartmentController::class, 'getDivisions']
        )
            ->middleware('permission:master.department.index,CanOpen')
            ->name('department.divisions');

        Route::resource('department', DepartmentController::class)
            ->middlewareFor(
                'index',
                'permission:master.department.index,CanOpen'
            )
            ->middlewareFor(
                'show',
                'permission:master.department.index,CanOpen'
            )
            ->middlewareFor(
                'create',
                'permission:master.department.index,CanAdd'
            )
            ->middlewareFor(
                'store',
                'permission:master.department.index,CanAdd'
            )
            ->middlewareFor(
                'edit',
                'permission:master.department.index,CanEdit'
            )
            ->middlewareFor(
                'update',
                'permission:master.department.index,CanEdit'
            )
            ->middlewareFor(
                'destroy',
                'permission:master.department.index,CanDelete'
            );

    });
