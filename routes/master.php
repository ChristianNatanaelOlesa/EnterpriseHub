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
use App\Http\Controllers\Master\JobLevelController;
use App\Http\Controllers\Master\JobTitleController;
use App\Http\Controllers\Master\EmailGroupController;
use App\Http\Controllers\Master\CocController;
use App\Http\Controllers\Master\AssetController;
use App\Http\Controllers\Master\AssetGroupController;
use App\Http\Controllers\Master\AssetTypeController;
use App\Http\Controllers\Master\CurrencyController;
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
            ->middlewareFor('index', 'permission:master.company.index,CanOpen')
            ->middlewareFor('show', 'permission:master.company.index,CanOpen')
            ->middlewareFor('create', 'permission:master.company.index,CanAdd')
            ->middlewareFor('store', 'permission:master.company.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.company.index,CanEdit')
            ->middlewareFor('update', 'permission:master.company.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.company.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | Country
        |--------------------------------------------------------------------------
        */

        Route::resource('country', CountryController::class)
            ->middlewareFor('index', 'permission:master.country.index,CanOpen')
            ->middlewareFor('show', 'permission:master.country.index,CanOpen')
            ->middlewareFor('create', 'permission:master.country.index,CanAdd')
            ->middlewareFor('store', 'permission:master.country.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.country.index,CanEdit')
            ->middlewareFor('update', 'permission:master.country.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.country.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | Province
        |--------------------------------------------------------------------------
        */

        Route::resource('province', ProvinceController::class)
            ->middlewareFor('index', 'permission:master.province.index,CanOpen')
            ->middlewareFor('show', 'permission:master.province.index,CanOpen')
            ->middlewareFor('create', 'permission:master.province.index,CanAdd')
            ->middlewareFor('store', 'permission:master.province.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.province.index,CanEdit')
            ->middlewareFor('update', 'permission:master.province.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.province.index,CanDelete');

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
            ->middlewareFor('index', 'permission:master.directorate.index,CanOpen')
            ->middlewareFor('show', 'permission:master.directorate.index,CanOpen')
            ->middlewareFor('create', 'permission:master.directorate.index,CanAdd')
            ->middlewareFor('store', 'permission:master.directorate.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.directorate.index,CanEdit')
            ->middlewareFor('update', 'permission:master.directorate.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.directorate.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | Division - AJAX
        |--------------------------------------------------------------------------
        */

        Route::get('division/directorates', [DivisionController::class, 'getDirectorates'])
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

        Route::get('department/directorates', [DepartmentController::class, 'getDirectorates'])
            ->middleware('permission:master.department.index,CanOpen')
            ->name('department.directorates');

        Route::get('department/divisions', [DepartmentController::class, 'getDivisions'])
            ->middleware('permission:master.department.index,CanOpen')
            ->name('department.divisions');

        Route::resource('department', DepartmentController::class)
            ->middlewareFor('index', 'permission:master.department.index,CanOpen')
            ->middlewareFor('show', 'permission:master.department.index,CanOpen')
            ->middlewareFor('create', 'permission:master.department.index,CanAdd')
            ->middlewareFor('store', 'permission:master.department.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.department.index,CanEdit')
            ->middlewareFor('update', 'permission:master.department.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.department.index,CanDelete');


        /*
        |--------------------------------------------------------------------------
        | Job Level
        |--------------------------------------------------------------------------
        */

        Route::resource('job-level', JobLevelController::class)
            ->parameters(['job-level' => 'jobLevel'])
            ->middlewareFor('index', 'permission:master.job-level.index,CanOpen')
            ->middlewareFor('show', 'permission:master.job-level.index,CanOpen')
            ->middlewareFor('create', 'permission:master.job-level.index,CanAdd')
            ->middlewareFor('store', 'permission:master.job-level.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.job-level.index,CanEdit')
            ->middlewareFor('update', 'permission:master.job-level.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.job-level.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | Job Title
        |--------------------------------------------------------------------------
        */

        Route::resource('job-title', JobTitleController::class)
            ->parameters(['job-title' => 'jobTitle'])
            ->middlewareFor('index', 'permission:master.job-title.index,CanOpen')
            ->middlewareFor('show', 'permission:master.job-title.index,CanOpen')
            ->middlewareFor('create', 'permission:master.job-title.index,CanAdd')
            ->middlewareFor('store', 'permission:master.job-title.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.job-title.index,CanEdit')
            ->middlewareFor('update', 'permission:master.job-title.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.job-title.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | Email Group
        |--------------------------------------------------------------------------
        */

        Route::resource('email-group', EmailGroupController::class)
            ->parameters(['email-group' => 'emailGroup'])
            ->middlewareFor('index', 'permission:master.email-group.index,CanOpen')
            ->middlewareFor('show', 'permission:master.email-group.index,CanOpen')
            ->middlewareFor('create', 'permission:master.email-group.index,CanAdd')
            ->middlewareFor('store', 'permission:master.email-group.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.email-group.index,CanEdit')
            ->middlewareFor('update', 'permission:master.email-group.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.email-group.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | Code of Conduct
        |--------------------------------------------------------------------------
        */

        Route::get('coc/{coc}/download', [CocController::class, 'download'])
            ->middleware('permission:master.coc.index,CanOpen')
            ->name('coc.download');

        Route::resource('coc', CocController::class)
            ->middlewareFor('index', 'permission:master.coc.index,CanOpen')
            ->middlewareFor('show', 'permission:master.coc.index,CanOpen')
            ->middlewareFor('create', 'permission:master.coc.index,CanAdd')
            ->middlewareFor('store', 'permission:master.coc.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.coc.index,CanEdit')
            ->middlewareFor('update', 'permission:master.coc.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.coc.index,CanDelete');
        /*
        |--------------------------------------------------------------------------
        | Religion
        |--------------------------------------------------------------------------
        */

        Route::resource('religion', ReligionController::class)
            ->middlewareFor('index', 'permission:master.religion.index,CanOpen')
            ->middlewareFor('show', 'permission:master.religion.index,CanOpen')
            ->middlewareFor('create', 'permission:master.religion.index,CanAdd')
            ->middlewareFor('store', 'permission:master.religion.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.religion.index,CanEdit')
            ->middlewareFor('update', 'permission:master.religion.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.religion.index,CanDelete');

        /*
        |--------------------------------------------------------------------------
        | Asset Management
        |--------------------------------------------------------------------------
        */

        Route::resource('asset-group', AssetGroupController::class)
            ->except(['show'])
            ->middlewareFor('index', 'permission:master.asset-group.index,CanOpen')
            ->middlewareFor('create', 'permission:master.asset-group.index,CanAdd')
            ->middlewareFor('store', 'permission:master.asset-group.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.asset-group.index,CanEdit')
            ->middlewareFor('update', 'permission:master.asset-group.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.asset-group.index,CanDelete');

        Route::resource('asset-type', AssetTypeController::class)
            ->except(['show'])
            ->middlewareFor('index', 'permission:master.asset-type.index,CanOpen')
            ->middlewareFor('create', 'permission:master.asset-type.index,CanAdd')
            ->middlewareFor('store', 'permission:master.asset-type.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.asset-type.index,CanEdit')
            ->middlewareFor('update', 'permission:master.asset-type.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.asset-type.index,CanDelete');

        Route::resource('currency', CurrencyController::class)
            ->except(['show'])
            ->middlewareFor('index', 'permission:master.currency.index,CanOpen')
            ->middlewareFor('create', 'permission:master.currency.index,CanAdd')
            ->middlewareFor('store', 'permission:master.currency.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.currency.index,CanEdit')
            ->middlewareFor('update', 'permission:master.currency.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.currency.index,CanDelete');

        Route::resource('asset', AssetController::class)
            ->except(['show'])
            ->middlewareFor('index', 'permission:master.asset.index,CanOpen')
            ->middlewareFor('create', 'permission:master.asset.index,CanAdd')
            ->middlewareFor('store', 'permission:master.asset.index,CanAdd')
            ->middlewareFor('edit', 'permission:master.asset.index,CanEdit')
            ->middlewareFor('update', 'permission:master.asset.index,CanEdit')
            ->middlewareFor('destroy', 'permission:master.asset.index,CanDelete');

    });
