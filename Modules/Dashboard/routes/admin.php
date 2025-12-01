<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\DashboardController;

Route::get('/', DashboardController::class)
    ->name('dashboard')
    ->middleware('permission:' . PermissionName::dashboard_view());
