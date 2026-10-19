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
use App\Http\Controllers\Master\FolderPathController;
use App\Http\Controllers\Master\ParentFolderController;
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
            ->middlewareFor('index', 'permission:master.company.index,View')
            ->middlewareFor('show', 'permission:master.company.index,View')
            ->middlewareFor('create', 'permission:master.company.index,Create')
            ->middlewareFor('store', 'permission:master.company.index,Create')
            ->middlewareFor('edit', 'permission:master.company.index,Update')
            ->middlewareFor('update', 'permission:master.company.index,Update')
            ->middlewareFor('destroy', 'permission:master.company.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Country
        |--------------------------------------------------------------------------
        */

        Route::resource('country', CountryController::class)
            ->middlewareFor('index', 'permission:master.country.index,View')
            ->middlewareFor('show', 'permission:master.country.index,View')
            ->middlewareFor('create', 'permission:master.country.index,Create')
            ->middlewareFor('store', 'permission:master.country.index,Create')
            ->middlewareFor('edit', 'permission:master.country.index,Update')
            ->middlewareFor('update', 'permission:master.country.index,Update')
            ->middlewareFor('destroy', 'permission:master.country.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Province
        |--------------------------------------------------------------------------
        */

        Route::resource('province', ProvinceController::class)
            ->middlewareFor('index', 'permission:master.province.index,View')
            ->middlewareFor('show', 'permission:master.province.index,View')
            ->middlewareFor('create', 'permission:master.province.index,Create')
            ->middlewareFor('store', 'permission:master.province.index,Create')
            ->middlewareFor('edit', 'permission:master.province.index,Update')
            ->middlewareFor('update', 'permission:master.province.index,Update')
            ->middlewareFor('destroy', 'permission:master.province.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | City
        |--------------------------------------------------------------------------
        */

        Route::resource('city', CityController::class)
            ->middlewareFor('index', 'permission:master.city.index,View')
            ->middlewareFor('show', 'permission:master.city.index,View')
            ->middlewareFor('create', 'permission:master.city.index,Create')
            ->middlewareFor('store', 'permission:master.city.index,Create')
            ->middlewareFor('edit', 'permission:master.city.index,Update')
            ->middlewareFor('update', 'permission:master.city.index,Update')
            ->middlewareFor('destroy', 'permission:master.city.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | District
        |--------------------------------------------------------------------------
        */

        Route::resource('district', DistrictController::class)
            ->middlewareFor('index', 'permission:master.district.index,View')
            ->middlewareFor('show', 'permission:master.district.index,View')
            ->middlewareFor('create', 'permission:master.district.index,Create')
            ->middlewareFor('store', 'permission:master.district.index,Create')
            ->middlewareFor('edit', 'permission:master.district.index,Update')
            ->middlewareFor('update', 'permission:master.district.index,Update')
            ->middlewareFor('destroy', 'permission:master.district.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Village
        |--------------------------------------------------------------------------
        */

        Route::resource('village', VillageController::class)
            ->middlewareFor('index', 'permission:master.village.index,View')
            ->middlewareFor('show', 'permission:master.village.index,View')
            ->middlewareFor('create', 'permission:master.village.index,Create')
            ->middlewareFor('store', 'permission:master.village.index,Create')
            ->middlewareFor('edit', 'permission:master.village.index,Update')
            ->middlewareFor('update', 'permission:master.village.index,Update')
            ->middlewareFor('destroy', 'permission:master.village.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Directorate
        |--------------------------------------------------------------------------
        */

        Route::resource('directorate', DirectorateController::class)
            ->middlewareFor('index', 'permission:master.directorate.index,View')
            ->middlewareFor('show', 'permission:master.directorate.index,View')
            ->middlewareFor('create', 'permission:master.directorate.index,Create')
            ->middlewareFor('store', 'permission:master.directorate.index,Create')
            ->middlewareFor('edit', 'permission:master.directorate.index,Update')
            ->middlewareFor('update', 'permission:master.directorate.index,Update')
            ->middlewareFor('destroy', 'permission:master.directorate.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Division - AJAX
        |--------------------------------------------------------------------------
        */

        Route::get('division/directorates', [DivisionController::class, 'getDirectorates'])
            ->middleware('permission:master.division.index,View')
            ->name('division.directorates');

        /*
        |--------------------------------------------------------------------------
        | Division
        |--------------------------------------------------------------------------
        */

        Route::resource('division', DivisionController::class)
            ->middlewareFor('index', 'permission:master.division.index,View')
            ->middlewareFor('show', 'permission:master.division.index,View')
            ->middlewareFor('create', 'permission:master.division.index,Create')
            ->middlewareFor('store', 'permission:master.division.index,Create')
            ->middlewareFor('edit', 'permission:master.division.index,Update')
            ->middlewareFor('update', 'permission:master.division.index,Update')
            ->middlewareFor('destroy', 'permission:master.division.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Department
        |--------------------------------------------------------------------------
        */

        Route::get('department/directorates', [DepartmentController::class, 'getDirectorates'])
            ->middleware('permission:master.department.index,View')
            ->name('department.directorates');

        Route::get('department/divisions', [DepartmentController::class, 'getDivisions'])
            ->middleware('permission:master.department.index,View')
            ->name('department.divisions');

        Route::resource('department', DepartmentController::class)
            ->middlewareFor('index', 'permission:master.department.index,View')
            ->middlewareFor('show', 'permission:master.department.index,View')
            ->middlewareFor('create', 'permission:master.department.index,Create')
            ->middlewareFor('store', 'permission:master.department.index,Create')
            ->middlewareFor('edit', 'permission:master.department.index,Update')
            ->middlewareFor('update', 'permission:master.department.index,Update')
            ->middlewareFor('destroy', 'permission:master.department.index,Delete');


        /*
        |--------------------------------------------------------------------------
        | Job Level
        |--------------------------------------------------------------------------
        */

        Route::resource('job-level', JobLevelController::class)
            ->parameters(['job-level' => 'jobLevel'])
            ->middlewareFor('index', 'permission:master.job-level.index,View')
            ->middlewareFor('show', 'permission:master.job-level.index,View')
            ->middlewareFor('create', 'permission:master.job-level.index,Create')
            ->middlewareFor('store', 'permission:master.job-level.index,Create')
            ->middlewareFor('edit', 'permission:master.job-level.index,Update')
            ->middlewareFor('update', 'permission:master.job-level.index,Update')
            ->middlewareFor('destroy', 'permission:master.job-level.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Job Title
        |--------------------------------------------------------------------------
        */

        Route::resource('job-title', JobTitleController::class)
            ->parameters(['job-title' => 'jobTitle'])
            ->middlewareFor('index', 'permission:master.job-title.index,View')
            ->middlewareFor('show', 'permission:master.job-title.index,View')
            ->middlewareFor('create', 'permission:master.job-title.index,Create')
            ->middlewareFor('store', 'permission:master.job-title.index,Create')
            ->middlewareFor('edit', 'permission:master.job-title.index,Update')
            ->middlewareFor('update', 'permission:master.job-title.index,Update')
            ->middlewareFor('destroy', 'permission:master.job-title.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Email Group
        |--------------------------------------------------------------------------
        */

        Route::resource('email-group', EmailGroupController::class)
            ->parameters(['email-group' => 'emailGroup'])
            ->middlewareFor('index', 'permission:master.email-group.index,View')
            ->middlewareFor('show', 'permission:master.email-group.index,View')
            ->middlewareFor('create', 'permission:master.email-group.index,Create')
            ->middlewareFor('store', 'permission:master.email-group.index,Create')
            ->middlewareFor('edit', 'permission:master.email-group.index,Update')
            ->middlewareFor('update', 'permission:master.email-group.index,Update')
            ->middlewareFor('destroy', 'permission:master.email-group.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Code of Conduct
        |--------------------------------------------------------------------------
        */

        Route::get('coc/{coc}/download', [CocController::class, 'download'])
            ->middleware('permission:master.coc.index,View')
            ->name('coc.download');

        Route::resource('coc', CocController::class)
            ->middlewareFor('index', 'permission:master.coc.index,View')
            ->middlewareFor('show', 'permission:master.coc.index,View')
            ->middlewareFor('create', 'permission:master.coc.index,Create')
            ->middlewareFor('store', 'permission:master.coc.index,Create')
            ->middlewareFor('edit', 'permission:master.coc.index,Update')
            ->middlewareFor('update', 'permission:master.coc.index,Update')
            ->middlewareFor('destroy', 'permission:master.coc.index,Delete');
        /*
        |--------------------------------------------------------------------------
        | Religion
        |--------------------------------------------------------------------------
        */

        Route::resource('religion', ReligionController::class)
            ->middlewareFor('index', 'permission:master.religion.index,View')
            ->middlewareFor('show', 'permission:master.religion.index,View')
            ->middlewareFor('create', 'permission:master.religion.index,Create')
            ->middlewareFor('store', 'permission:master.religion.index,Create')
            ->middlewareFor('edit', 'permission:master.religion.index,Update')
            ->middlewareFor('update', 'permission:master.religion.index,Update')
            ->middlewareFor('destroy', 'permission:master.religion.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Asset Management
        |--------------------------------------------------------------------------
        */

        Route::resource('asset-group', AssetGroupController::class)
            ->except(['show'])
            ->middlewareFor('index', 'permission:master.asset-group.index,View')
            ->middlewareFor('create', 'permission:master.asset-group.index,Create')
            ->middlewareFor('store', 'permission:master.asset-group.index,Create')
            ->middlewareFor('edit', 'permission:master.asset-group.index,Update')
            ->middlewareFor('update', 'permission:master.asset-group.index,Update')
            ->middlewareFor('destroy', 'permission:master.asset-group.index,Delete');

        Route::resource('asset-type', AssetTypeController::class)
            ->except(['show'])
            ->middlewareFor('index', 'permission:master.asset-type.index,View')
            ->middlewareFor('create', 'permission:master.asset-type.index,Create')
            ->middlewareFor('store', 'permission:master.asset-type.index,Create')
            ->middlewareFor('edit', 'permission:master.asset-type.index,Update')
            ->middlewareFor('update', 'permission:master.asset-type.index,Update')
            ->middlewareFor('destroy', 'permission:master.asset-type.index,Delete');

        Route::resource('currency', CurrencyController::class)
            ->except(['show'])
            ->middlewareFor('index', 'permission:master.currency.index,View')
            ->middlewareFor('create', 'permission:master.currency.index,Create')
            ->middlewareFor('store', 'permission:master.currency.index,Create')
            ->middlewareFor('edit', 'permission:master.currency.index,Update')
            ->middlewareFor('update', 'permission:master.currency.index,Update')
            ->middlewareFor('destroy', 'permission:master.currency.index,Delete');

        Route::resource('asset', AssetController::class)
            ->except(['show'])
            ->middlewareFor('index', 'permission:master.asset.index,View')
            ->middlewareFor('create', 'permission:master.asset.index,Create')
            ->middlewareFor('store', 'permission:master.asset.index,Create')
            ->middlewareFor('edit', 'permission:master.asset.index,Update')
            ->middlewareFor('update', 'permission:master.asset.index,Update')
            ->middlewareFor('destroy', 'permission:master.asset.index,Delete');

        /*
        |--------------------------------------------------------------------------
        | Master Folder Share
        |--------------------------------------------------------------------------
        */

        Route::resource('parent-folder', ParentFolderController::class)
            ->parameters(['parent-folder' => 'parent_folder'])
            ->middlewareFor('index', 'permission:master.parent-folder.index,View')
            ->middlewareFor('show', 'permission:master.parent-folder.index,View')
            ->middlewareFor('create', 'permission:master.parent-folder.index,Create')
            ->middlewareFor('store', 'permission:master.parent-folder.index,Create')
            ->middlewareFor('edit', 'permission:master.parent-folder.index,Update')
            ->middlewareFor('update', 'permission:master.parent-folder.index,Update')
            ->middlewareFor('destroy', 'permission:master.parent-folder.index,Delete');

        Route::get('/folder-path', [FolderPathController::class, 'index'])
            ->middleware('permission:master.folder-path.index,View')
            ->name('folder-path.index');

        Route::get('/folder-path/create', [FolderPathController::class, 'create'])
            ->middleware('permission:master.folder-path.index,Create')
            ->name('folder-path.create');

        Route::post('/folder-path', [FolderPathController::class, 'store'])
            ->middleware('permission:master.folder-path.index,Create')
            ->name('folder-path.store');

        Route::get('/folder-path/{folder_path}/edit', [FolderPathController::class, 'edit'])
            ->middleware('permission:master.folder-path.index,Update')
            ->name('folder-path.edit');

        Route::put('/folder-path/{folder_path}', [FolderPathController::class, 'update'])
            ->middleware('permission:master.folder-path.index,Update')
            ->name('folder-path.update');

        Route::delete('/folder-path/{folder_path}', [FolderPathController::class, 'destroy'])
            ->middleware('permission:master.folder-path.index,Delete')
            ->name('folder-path.destroy');


    });
