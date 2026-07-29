<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\CompanyController;

Route::resource('companies', CompanyController::class);
