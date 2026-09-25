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
        ->middleware('permission:employee-form.index,CanOpen')
        ->name('employee-form.index');

    Route::get('/employee-form/create', [EmployeeFormController::class, 'create'])
        ->middleware('permission:employee-form.index,CanAdd')
        ->name('employee-form.create');

    Route::post('/employee-form', [EmployeeFormController::class, 'store'])
        ->middleware('permission:employee-form.index,CanAdd')
        ->name('employee-form.store');

    Route::get('/employee-form/{empFormId}/edit', [EmployeeFormController::class, 'edit'])
        ->middleware('permission:employee-form.index,CanEdit')
        ->name('employee-form.edit');

    Route::put('/employee-form/{empFormId}', [EmployeeFormController::class, 'update'])
        ->middleware('permission:employee-form.index,CanEdit')
        ->name('employee-form.update');

    Route::delete('/employee-form/{empFormId}', [EmployeeFormController::class, 'destroy'])
        ->middleware('permission:employee-form.index,CanDelete')
        ->name('employee-form.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Form - Address Cascading
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-form/provinces/{countryId}', [EmployeeFormController::class, 'provinces'])
        ->middleware('permission:employee-form.index,CanOpen')
        ->name('employee-form.provinces');

    Route::get('/employee-form/cities/{provinceId}', [EmployeeFormController::class, 'cities'])
        ->middleware('permission:employee-form.index,CanOpen')
        ->name('employee-form.cities');

    Route::get('/employee-form/districts/{cityId}', [EmployeeFormController::class, 'districts'])
        ->middleware('permission:employee-form.index,CanOpen')
        ->name('employee-form.districts');

    Route::get('/employee-form/villages/{districtId}', [EmployeeFormController::class, 'villages'])
        ->middleware('permission:employee-form.index,CanOpen')
        ->name('employee-form.villages');

    Route::get('/employee-form/divisions/{directorateId}', [EmployeeFormController::class, 'divisions'])
        ->middleware('permission:employee-form.index,CanOpen')
        ->name('employee-form.divisions');

    Route::get('/employee-form/departments/{divisionId}', [EmployeeFormController::class, 'departments'])
        ->middleware('permission:employee-form.index,CanOpen')
        ->name('employee-form.departments');

    /*
    |--------------------------------------------------------------------------
    | Employee Application
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-app', [EmpAppController::class, 'index'])
        ->middleware('permission:employee-app.index,CanOpen')
        ->name('employee-app.index');

    Route::get('/employee-app/create', [EmpAppController::class, 'create'])
        ->middleware('permission:employee-app.index,CanAdd')
        ->name('employee-app.create');

    Route::post('/employee-app', [EmpAppController::class, 'store'])
        ->middleware('permission:employee-app.index,CanAdd')
        ->name('employee-app.store');

    Route::get('/employee-app/{employeeApp}/edit', [EmpAppController::class, 'edit'])
        ->middleware('permission:employee-app.index,CanEdit')
        ->name('employee-app.edit');

    Route::put('/employee-app/{employeeApp}', [EmpAppController::class, 'update'])
        ->middleware('permission:employee-app.index,CanEdit')
        ->name('employee-app.update');

    Route::delete('/employee-app/{employeeApp}', [EmpAppController::class, 'destroy'])
        ->middleware('permission:employee-app.index,CanDelete')
        ->name('employee-app.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Email
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-email', [EmpEmailController::class, 'index'])
        ->middleware('permission:employee-email.index,CanOpen')
        ->name('employee-email.index');

    Route::get('/employee-email/create', [EmpEmailController::class, 'create'])
        ->middleware('permission:employee-email.index,CanAdd')
        ->name('employee-email.create');

    Route::post('/employee-email', [EmpEmailController::class, 'store'])
        ->middleware('permission:employee-email.index,CanAdd')
        ->name('employee-email.store');

    Route::get('/employee-email/{employeeEmail}/edit', [EmpEmailController::class, 'edit'])
        ->middleware('permission:employee-email.index,CanEdit')
        ->name('employee-email.edit');

    Route::put('/employee-email/{employeeEmail}', [EmpEmailController::class, 'update'])
        ->middleware('permission:employee-email.index,CanEdit')
        ->name('employee-email.update');

    Route::post('/employee-email/{employeeEmail}/submit-approval', [EmpEmailController::class, 'submitApproval'])
        ->middleware('permission:employee-email.index,CanEdit')
        ->name('employee-email.submit-approval');

    Route::delete('/employee-email/{employeeEmail}', [EmpEmailController::class, 'destroy'])
        ->middleware('permission:employee-email.index,CanDelete')
        ->name('employee-email.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Equipment
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-equipment', [EmpEquipController::class, 'index'])
        ->middleware('permission:employee-equipment.index,CanOpen')
        ->name('employee-equipment.index');

    Route::get('/employee-equipment/create', [EmpEquipController::class, 'create'])
        ->middleware('permission:employee-equipment.index,CanAdd')
        ->name('employee-equipment.create');

    Route::post('/employee-equipment', [EmpEquipController::class, 'store'])
        ->middleware('permission:employee-equipment.index,CanAdd')
        ->name('employee-equipment.store');

    Route::get('/employee-equipment/{employeeEquipment}/edit', [EmpEquipController::class, 'edit'])
        ->middleware('permission:employee-equipment.index,CanEdit')
        ->name('employee-equipment.edit');

    Route::put('/employee-equipment/{employeeEquipment}', [EmpEquipController::class, 'update'])
        ->middleware('permission:employee-equipment.index,CanEdit')
        ->name('employee-equipment.update');

    Route::delete('/employee-equipment/{employeeEquipment}', [EmpEquipController::class, 'destroy'])
        ->middleware('permission:employee-equipment.index,CanDelete')
        ->name('employee-equipment.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Network
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-network', [EmpNetworkController::class, 'index'])
        ->middleware('permission:employee-network.index,CanOpen')
        ->name('employee-network.index');

    Route::get('/employee-network/create', [EmpNetworkController::class, 'create'])
        ->middleware('permission:employee-network.index,CanAdd')
        ->name('employee-network.create');

    Route::post('/employee-network', [EmpNetworkController::class, 'store'])
        ->middleware('permission:employee-network.index,CanAdd')
        ->name('employee-network.store');

    Route::get('/employee-network/{employeeNetwork}/edit', [EmpNetworkController::class, 'edit'])
        ->middleware('permission:employee-network.index,CanEdit')
        ->name('employee-network.edit');

    Route::put('/employee-network/{employeeNetwork}', [EmpNetworkController::class, 'update'])
        ->middleware('permission:employee-network.index,CanEdit')
        ->name('employee-network.update');

    Route::delete('/employee-network/{employeeNetwork}', [EmpNetworkController::class, 'destroy'])
        ->middleware('permission:employee-network.index,CanDelete')
        ->name('employee-network.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Infrastructure
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-infra', [EmpInfraController::class, 'index'])
        ->middleware('permission:employee-infra.index,CanOpen')
        ->name('employee-infra.index');

    Route::get('/employee-infra/create', [EmpInfraController::class, 'create'])
        ->middleware('permission:employee-infra.index,CanAdd')
        ->name('employee-infra.create');

    Route::post('/employee-infra', [EmpInfraController::class, 'store'])
        ->middleware('permission:employee-infra.index,CanAdd')
        ->name('employee-infra.store');

    Route::get('/employee-infra/{employeeInfra}/edit', [EmpInfraController::class, 'edit'])
        ->middleware('permission:employee-infra.index,CanEdit')
        ->name('employee-infra.edit');

    Route::put('/employee-infra/{employeeInfra}', [EmpInfraController::class, 'update'])
        ->middleware('permission:employee-infra.index,CanEdit')
        ->name('employee-infra.update');

    Route::delete('/employee-infra/{employeeInfra}', [EmpInfraController::class, 'destroy'])
        ->middleware('permission:employee-infra.index,CanDelete')
        ->name('employee-infra.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee IT Area
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-it-area', [EmpITAreaController::class, 'index'])
        ->middleware('permission:employee-it-area.index,CanOpen')
        ->name('employee-it-area.index');

    Route::get('/employee-it-area/create', [EmpITAreaController::class, 'create'])
        ->middleware('permission:employee-it-area.index,CanAdd')
        ->name('employee-it-area.create');

    Route::post('/employee-it-area', [EmpITAreaController::class, 'store'])
        ->middleware('permission:employee-it-area.index,CanAdd')
        ->name('employee-it-area.store');

    Route::get('/employee-it-area/{employeeITArea}/edit', [EmpITAreaController::class, 'edit'])
        ->middleware('permission:employee-it-area.index,CanEdit')
        ->name('employee-it-area.edit');

    Route::put('/employee-it-area/{employeeITArea}', [EmpITAreaController::class, 'update'])
        ->middleware('permission:employee-it-area.index,CanEdit')
        ->name('employee-it-area.update');

    Route::delete('/employee-it-area/{employeeITArea}', [EmpITAreaController::class, 'destroy'])
        ->middleware('permission:employee-it-area.index,CanDelete')
        ->name('employee-it-area.destroy');


    /*
    |--------------------------------------------------------------------------
    | Employee Network Drive
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-net-drive', [EmpNetDriveController::class, 'index'])
        ->middleware('permission:employee-net-drive.index,CanOpen')
        ->name('employee-net-drive.index');

    Route::get('/employee-net-drive/create', [EmpNetDriveController::class, 'create'])
        ->middleware('permission:employee-net-drive.index,CanAdd')
        ->name('employee-net-drive.create');

    Route::post('/employee-net-drive', [EmpNetDriveController::class, 'store'])
        ->middleware('permission:employee-net-drive.index,CanAdd')
        ->name('employee-net-drive.store');

    Route::get('/employee-net-drive/{employeeNetDrive}/edit', [EmpNetDriveController::class, 'edit'])
        ->middleware('permission:employee-net-drive.index,CanEdit')
        ->name('employee-net-drive.edit');

    Route::put('/employee-net-drive/{employeeNetDrive}', [EmpNetDriveController::class, 'update'])
        ->middleware('permission:employee-net-drive.index,CanEdit')
        ->name('employee-net-drive.update');

    Route::delete('/employee-net-drive/{employeeNetDrive}', [EmpNetDriveController::class, 'destroy'])
        ->middleware('permission:employee-net-drive.index,CanDelete')
        ->name('employee-net-drive.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Software
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-software', [EmpSoftwareController::class, 'index'])
        ->middleware('permission:employee-software.index,CanOpen')
        ->name('employee-software.index');

    Route::get('/employee-software/create', [EmpSoftwareController::class, 'create'])
        ->middleware('permission:employee-software.index,CanAdd')
        ->name('employee-software.create');

    Route::post('/employee-software', [EmpSoftwareController::class, 'store'])
        ->middleware('permission:employee-software.index,CanAdd')
        ->name('employee-software.store');

    Route::get('/employee-software/{employeeSoftware}/edit', [EmpSoftwareController::class, 'edit'])
        ->middleware('permission:employee-software.index,CanEdit')
        ->name('employee-software.edit');

    Route::put('/employee-software/{employeeSoftware}', [EmpSoftwareController::class, 'update'])
        ->middleware('permission:employee-software.index,CanEdit')
        ->name('employee-software.update');

    Route::delete('/employee-software/{employeeSoftware}', [EmpSoftwareController::class, 'destroy'])
        ->middleware('permission:employee-software.index,CanDelete')
        ->name('employee-software.destroy');

    /*
    |--------------------------------------------------------------------------
    | Employee Sharing Folder
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-sharing-folder', [EmpSharingFolderController::class, 'index'])
    ->middleware('permission:employee-sharing-folder.index,CanOpen')
    ->name('employee-sharing-folder.index');

    Route::get('/employee-sharing-folder/create', [EmpSharingFolderController::class, 'create'])
        ->middleware('permission:employee-sharing-folder.index,CanAdd')
        ->name('employee-sharing-folder.create');

    Route::post('/employee-sharing-folder', [EmpSharingFolderController::class, 'store'])
        ->middleware('permission:employee-sharing-folder.index,CanAdd')
        ->name('employee-sharing-folder.store');

    Route::get('/employee-sharing-folder/{employeeSharingFolder}/edit', [EmpSharingFolderController::class, 'edit'])
        ->middleware('permission:employee-sharing-folder.index,CanEdit')
        ->name('employee-sharing-folder.edit');

    Route::put('/employee-sharing-folder/{employeeSharingFolder}', [EmpSharingFolderController::class, 'update'])
        ->middleware('permission:employee-sharing-folder.index,CanEdit')
        ->name('employee-sharing-folder.update');

    Route::delete('/employee-sharing-folder/{employeeSharingFolder}', [EmpSharingFolderController::class, 'destroy'])
        ->middleware('permission:employee-sharing-folder.index,CanDelete')
        ->name('employee-sharing-folder.destroy');
});
