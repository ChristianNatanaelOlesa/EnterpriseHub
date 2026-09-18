<?php

use App\Http\Controllers\Master\CompanyController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\DirectorateController;
use App\Http\Controllers\Master\DivisionController;
use App\Http\Controllers\Master\ReligionController;
use App\Http\Controllers\Master\CountryController;
use App\Http\Controllers\Master\ProvinceController;
use App\Http\Controllers\Master\CityController;
use App\Http\Controllers\Master\DistrictController;
use App\Http\Controllers\Master\VillageController;
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
        | Country
        |--------------------------------------------------------------------------
        */

        Route::resource('country', CountryController::class)
            ->middlewareFor(
                'index',
                'permission:master.country.index,CanOpen'
            )
            ->middlewareFor(
                'show',
                'permission:master.country.index,CanOpen'
            )
            ->middlewareFor(
                'create',
                'permission:master.country.index,CanAdd'
            )
            ->middlewareFor(
                'store',
                'permission:master.country.index,CanAdd'
            )
            ->middlewareFor(
                'edit',
                'permission:master.country.index,CanEdit'
            )
            ->middlewareFor(
                'update',
                'permission:master.country.index,CanEdit'
            )
            ->middlewareFor(
                'destroy',
                'permission:master.country.index,CanDelete'
            );

        /*
        |--------------------------------------------------------------------------
        | Province
        |--------------------------------------------------------------------------
        */

        Route::resource('province', ProvinceController::class)
            ->middlewareFor(
                'index',
                'permission:master.province.index,CanOpen'
            )
            ->middlewareFor(
                'show',
                'permission:master.province.index,CanOpen'
            )
            ->middlewareFor(
                'create',
                'permission:master.province.index,CanAdd'
            )
            ->middlewareFor(
                'store',
                'permission:master.province.index,CanAdd'
            )
            ->middlewareFor(
                'edit',
                'permission:master.province.index,CanEdit'
            )
            ->middlewareFor(
                'update',
                'permission:master.province.index,CanEdit'
            )
            ->middlewareFor(
                'destroy',
                'permission:master.province.index,CanDelete'
            );

        /*
        |--------------------------------------------------------------------------
        | City
        |--------------------------------------------------------------------------
        */

        Route::resource('city', CityController::class)
            ->middlewareFor('index', 'permission:master.city.index,CanOpen')
            ->middlewareFor('show', 'permission:master.city.index,CanOpen')
            ->middlewareFor('create', 'permission:master.city.index,CanAdd')
            ->middlewareFor('store', 'permission:master.city.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.city.index,CanEdit')
            ->middlewareFor('update', 'permission:master.city.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.city.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | District
        |--------------------------------------------------------------------------
        */

        Route::resource('district', DistrictController::class)
            ->middlewareFor('index', 'permission:master.district.index,CanOpen')
            ->middlewareFor('show', 'permission:master.district.index,CanOpen')
            ->middlewareFor('create', 'permission:master.district.index,CanAdd')
            ->middlewareFor('store', 'permission:master.district.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.district.index,CanEdit')
            ->middlewareFor('update', 'permission:master.district.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.district.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | Village
        |--------------------------------------------------------------------------
        */

        Route::resource('village', VillageController::class)
            ->middlewareFor('index', 'permission:master.village.index,CanOpen')
            ->middlewareFor('show', 'permission:master.village.index,CanOpen')
            ->middlewareFor('create', 'permission:master.village.index,CanAdd')
            ->middlewareFor('store', 'permission:master.village.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.village.index,CanEdit')
            ->middlewareFor('update', 'permission:master.village.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.village.index,CanDelete');

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

        /*
        |--------------------------------------------------------------------------
        | Religion
        |--------------------------------------------------------------------------
        */

        Route::resource('religion', ReligionController::class)
            ->middlewareFor(
                'index',
                'permission:master.religion.index,CanOpen'
            )
            ->middlewareFor(
                'show',
                'permission:master.religion.index,CanOpen'
            )
            ->middlewareFor(
                'create',
                'permission:master.religion.index,CanAdd'
            )
            ->middlewareFor(
                'store',
                'permission:master.religion.index,CanAdd'
            )
            ->middlewareFor(
                'edit',
                'permission:master.religion.index,CanEdit'
            )
            ->middlewareFor(
                'update',
                'permission:master.religion.index,CanEdit'
            )
            ->middlewareFor(
                'destroy',
                'permission:master.religion.index,CanDelete'
            );

    });
