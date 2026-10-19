<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EForm\EmployeeFormController;
use App\Http\Controllers\EForm\EmpAppController;
use App\Http\Controllers\EForm\EmpEmailController;
use App\Http\Controllers\EForm\EmpEquipController;
use App\Http\Controllers\EForm\EmpNetworkController;
use App\Http\Controllers\EForm\EmpInfraController;
use App\Http\Controllers\EForm\EmpITAreaController;
use App\Http\Controllers\EForm\EmpNetDriveController;
use App\Http\Controllers\EForm\EmpSoftwareController;
use App\Http\Controllers\EForm\EmpSharingFolderController;

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Employee Form Request
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-form', [EmployeeFormController::class, 'index'])
        ->middleware('permission:employee-form.index,View')
        ->name('employee-form.index');

    Route::get('/employee-form/create', [EmployeeFormController::class, 'create'])
        ->middleware('permission:employee-form.index,Create')
        ->name('employee-form.create');

    Route::post('/employee-form', [EmployeeFormController::class, 'store'])
        ->middleware('permission:employee-form.index,Create')
        ->name('employee-form.store');

    Route::get('/employee-form/{empFormId}/edit', [EmployeeFormController::class, 'edit'])
        ->middleware('permission:employee-form.index,Update')
        ->name('employee-form.edit');

    Route::put('/employee-form/{empFormId}', [EmployeeFormController::class, 'update'])
        ->middleware('permission:employee-form.index,Update')
        ->name('employee-form.update');

    Route::delete('/employee-form/{empFormId}', [EmployeeFormController::class, 'destroy'])
        ->middleware('permission:employee-form.index,Delete')
        ->name('employee-form.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Form - Address Cascading
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-form/provinces/{countryId}', [EmployeeFormController::class, 'provinces'])
        ->middleware('permission:employee-form.index,View')
        ->name('employee-form.provinces');

    Route::get('/employee-form/cities/{provinceId}', [EmployeeFormController::class, 'cities'])
        ->middleware('permission:employee-form.index,View')
        ->name('employee-form.cities');

    Route::get('/employee-form/districts/{cityId}', [EmployeeFormController::class, 'districts'])
        ->middleware('permission:employee-form.index,View')
        ->name('employee-form.districts');

    Route::get('/employee-form/villages/{districtId}', [EmployeeFormController::class, 'villages'])
        ->middleware('permission:employee-form.index,View')
        ->name('employee-form.villages');

    Route::get('/employee-form/divisions/{directorateId}', [EmployeeFormController::class, 'divisions'])
        ->middleware('permission:employee-form.index,View')
        ->name('employee-form.divisions');

    Route::get('/employee-form/departments/{divisionId}', [EmployeeFormController::class, 'departments'])
        ->middleware('permission:employee-form.index,View')
        ->name('employee-form.departments');

    Route::get('/employee-form/report-to', [EmployeeFormController::class, 'reportTo'])
        ->middleware('permission:employee-form.index,View')
        ->name('employee-form.report-to');

    /*
    |--------------------------------------------------------------------------
    | Employee Application
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-app', [EmpAppController::class, 'index'])
        ->middleware('permission:employee-app.index,View')
        ->name('employee-app.index');

    Route::get('/employee-app/create', [EmpAppController::class, 'create'])
        ->middleware('permission:employee-app.index,Create')
        ->name('employee-app.create');

    Route::post('/employee-app', [EmpAppController::class, 'store'])
        ->middleware('permission:employee-app.index,Create')
        ->name('employee-app.store');

    Route::get('/employee-app/{employeeApp}/edit', [EmpAppController::class, 'edit'])
        ->middleware('permission:employee-app.index,Update')
        ->name('employee-app.edit');

    Route::put('/employee-app/{employeeApp}', [EmpAppController::class, 'update'])
        ->middleware('permission:employee-app.index,Update')
        ->name('employee-app.update');

    Route::delete('/employee-app/{employeeApp}', [EmpAppController::class, 'destroy'])
        ->middleware('permission:employee-app.index,Delete')
        ->name('employee-app.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Email
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-email', [EmpEmailController::class, 'index'])
        ->middleware('permission:employee-email.index,View')
        ->name('employee-email.index');

    Route::get('/employee-email/create', [EmpEmailController::class, 'create'])
        ->middleware('permission:employee-email.index,Create')
        ->name('employee-email.create');

    Route::post('/employee-email', [EmpEmailController::class, 'store'])
        ->middleware('permission:employee-email.index,Create')
        ->name('employee-email.store');

    Route::get('/employee-email/{employeeEmail}/edit', [EmpEmailController::class, 'edit'])
        ->middleware('permission:employee-email.index,Update')
        ->name('employee-email.edit');

    Route::put('/employee-email/{employeeEmail}', [EmpEmailController::class, 'update'])
        ->middleware('permission:employee-email.index,Update')
        ->name('employee-email.update');

    Route::post('/employee-email/{employeeEmail}/submit-approval', [EmpEmailController::class, 'submitApproval'])
        ->middleware('permission:employee-email.index,Update')
        ->name('employee-email.submit-approval');

    Route::delete('/employee-email/{employeeEmail}', [EmpEmailController::class, 'destroy'])
        ->middleware('permission:employee-email.index,Delete')
        ->name('employee-email.destroy');

    Route::put('/employee-email/{employeeEmail}/fulfillment', [EmpEmailController::class, 'updateFulfillment'])
        ->middleware('permission:employee-email.index,IT Fulfillment')
        ->name('employee-email.fulfillment');

    /*
    |--------------------------------------------------------------------------
    | Employee Equipment
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-equipment', [EmpEquipController::class, 'index'])
        ->middleware('permission:employee-equipment.index,View')
        ->name('employee-equipment.index');

    Route::get('/employee-equipment/create', [EmpEquipController::class, 'create'])
        ->middleware('permission:employee-equipment.index,Create')
        ->name('employee-equipment.create');

    Route::post('/employee-equipment', [EmpEquipController::class, 'store'])
        ->middleware('permission:employee-equipment.index,Create')
        ->name('employee-equipment.store');

    Route::get('/employee-equipment/{employeeEquipment}/edit', [EmpEquipController::class, 'edit'])
        ->middleware('permission:employee-equipment.index,Update')
        ->name('employee-equipment.edit');

    Route::put('/employee-equipment/{employeeEquipment}', [EmpEquipController::class, 'update'])
        ->middleware('permission:employee-equipment.index,Update')
        ->name('employee-equipment.update');

    Route::delete('/employee-equipment/{employeeEquipment}', [EmpEquipController::class, 'destroy'])
        ->middleware('permission:employee-equipment.index,Delete')
        ->name('employee-equipment.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Network
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-network', [EmpNetworkController::class, 'index'])
        ->middleware('permission:employee-network.index,View')
        ->name('employee-network.index');

    Route::get('/employee-network/create', [EmpNetworkController::class, 'create'])
        ->middleware('permission:employee-network.index,Create')
        ->name('employee-network.create');

    Route::post('/employee-network', [EmpNetworkController::class, 'store'])
        ->middleware('permission:employee-network.index,Create')
        ->name('employee-network.store');

    Route::get('/employee-network/{employeeNetwork}/edit', [EmpNetworkController::class, 'edit'])
        ->middleware('permission:employee-network.index,Update')
        ->name('employee-network.edit');

    Route::put('/employee-network/{employeeNetwork}', [EmpNetworkController::class, 'update'])
        ->middleware('permission:employee-network.index,Update')
        ->name('employee-network.update');

    Route::delete('/employee-network/{employeeNetwork}', [EmpNetworkController::class, 'destroy'])
        ->middleware('permission:employee-network.index,Delete')
        ->name('employee-network.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Infrastructure
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-infra', [EmpInfraController::class, 'index'])
        ->middleware('permission:employee-infra.index,View')
        ->name('employee-infra.index');

    Route::get('/employee-infra/create', [EmpInfraController::class, 'create'])
        ->middleware('permission:employee-infra.index,Create')
        ->name('employee-infra.create');

    Route::post('/employee-infra', [EmpInfraController::class, 'store'])
        ->middleware('permission:employee-infra.index,Create')
        ->name('employee-infra.store');

    Route::get('/employee-infra/{employeeInfra}/edit', [EmpInfraController::class, 'edit'])
        ->middleware('permission:employee-infra.index,Update')
        ->name('employee-infra.edit');

    Route::put('/employee-infra/{employeeInfra}', [EmpInfraController::class, 'update'])
        ->middleware('permission:employee-infra.index,Update')
        ->name('employee-infra.update');

    Route::delete('/employee-infra/{employeeInfra}', [EmpInfraController::class, 'destroy'])
        ->middleware('permission:employee-infra.index,Delete')
        ->name('employee-infra.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee IT Area
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-it-area', [EmpITAreaController::class, 'index'])
        ->middleware('permission:employee-it-area.index,View')
        ->name('employee-it-area.index');

    Route::get('/employee-it-area/create', [EmpITAreaController::class, 'create'])
        ->middleware('permission:employee-it-area.index,Create')
        ->name('employee-it-area.create');

    Route::post('/employee-it-area', [EmpITAreaController::class, 'store'])
        ->middleware('permission:employee-it-area.index,Create')
        ->name('employee-it-area.store');

    Route::get('/employee-it-area/{employeeITArea}/edit', [EmpITAreaController::class, 'edit'])
        ->middleware('permission:employee-it-area.index,Update')
        ->name('employee-it-area.edit');

    Route::put('/employee-it-area/{employeeITArea}', [EmpITAreaController::class, 'update'])
        ->middleware('permission:employee-it-area.index,Update')
        ->name('employee-it-area.update');

    Route::delete('/employee-it-area/{employeeITArea}', [EmpITAreaController::class, 'destroy'])
        ->middleware('permission:employee-it-area.index,Delete')
        ->name('employee-it-area.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Software
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-software', [EmpSoftwareController::class, 'index'])
        ->middleware('permission:employee-software.index,View')
        ->name('employee-software.index');

    Route::get('/employee-software/create', [EmpSoftwareController::class, 'create'])
        ->middleware('permission:employee-software.index,Create')
        ->name('employee-software.create');

    Route::post('/employee-software', [EmpSoftwareController::class, 'store'])
        ->middleware('permission:employee-software.index,Create')
        ->name('employee-software.store');

    Route::get('/employee-software/{employeeSoftware}/edit', [EmpSoftwareController::class, 'edit'])
        ->middleware('permission:employee-software.index,Update')
        ->name('employee-software.edit');

    Route::put('/employee-software/{employeeSoftware}', [EmpSoftwareController::class, 'update'])
        ->middleware('permission:employee-software.index,Update')
        ->name('employee-software.update');

    Route::delete('/employee-software/{employeeSoftware}', [EmpSoftwareController::class, 'destroy'])
        ->middleware('permission:employee-software.index,Delete')
        ->name('employee-software.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Sharing Folder
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-sharing-folder', [EmpSharingFolderController::class, 'index'])
    ->middleware('permission:employee-sharing-folder.index,View')
    ->name('employee-sharing-folder.index');

    Route::get('/employee-sharing-folder/create', [EmpSharingFolderController::class, 'create'])
        ->middleware('permission:employee-sharing-folder.index,Create')
        ->name('employee-sharing-folder.create');

    Route::post('/employee-sharing-folder', [EmpSharingFolderController::class, 'store'])
        ->middleware('permission:employee-sharing-folder.index,Create')
        ->name('employee-sharing-folder.store');

    Route::get('/employee-sharing-folder/{employeeSharingFolder}/edit', [EmpSharingFolderController::class, 'edit'])
        ->middleware('permission:employee-sharing-folder.index,Update')
        ->name('employee-sharing-folder.edit');

    Route::put('/employee-sharing-folder/{employeeSharingFolder}', [EmpSharingFolderController::class, 'update'])
        ->middleware('permission:employee-sharing-folder.index,Update')
        ->name('employee-sharing-folder.update');

    Route::delete('/employee-sharing-folder/{employeeSharingFolder}', [EmpSharingFolderController::class, 'destroy'])
        ->middleware('permission:employee-sharing-folder.index,Delete')
        ->name('employee-sharing-folder.destroy');
});
