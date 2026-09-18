<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth', 'permission:dashboard'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});
