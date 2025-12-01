<?php

use Illuminate\Support\Facades\Route;
use Modules\VillageOfficial\App\Http\Controllers\VillageOfficialController;
use Modules\VillageOfficial\App\Http\Controllers\VillageOfficialHistoryUserController;
use Modules\VillageOfficial\App\Http\Controllers\VillageOfficialMemberUserController;
use Modules\VillageOfficial\App\Http\Controllers\VillageOfficialVissionMissionUserController;

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

Route::prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/', VillageOfficialMemberUserController::class)->name('index');
    });

Route::prefix('history')
    ->name('history.')
    ->group(function () {
        Route::get('/', VillageOfficialHistoryUserController::class)->name('index');
    });

Route::prefix('vision-mission')
    ->name('vision-mission.')
    ->group(function () {
        Route::get('/', VillageOfficialVissionMissionUserController::class)->name('index');
    });
