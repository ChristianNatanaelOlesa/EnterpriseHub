<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

require __DIR__.'/security.php';
require __DIR__.'/master.php';
require __DIR__.'/transaction.php';
require __DIR__.'/reporting.php';
require __DIR__.'/dashboard.php';
require __DIR__.'/setting.php';
