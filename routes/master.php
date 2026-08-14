<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\CompanyController;

Route::middleware(['auth'])
    ->prefix('master')
    ->name('master.')
    ->group(function () {

        Route::resource('company', CompanyController::class);

    });
