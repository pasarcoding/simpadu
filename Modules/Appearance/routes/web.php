<?php

use Illuminate\Support\Facades\Route;
use Modules\Appearance\App\Http\Controllers\AppearanceController;
use Modules\Appearance\App\Http\Controllers\AppearancePageUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('page')
    ->name('page.')
    ->group(function () {
        Route::get('{appearancePage:slug}', AppearancePageUserController::class)->name('index');
    });
