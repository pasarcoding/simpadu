<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Setting\App\Http\Controllers\SettingController;


Route::middleware('permission:' . PermissionName::setting_manage())
    ->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('app', [SettingController::class, 'app'])->name('app');
        Route::post('appearance', [SettingController::class, 'appearance'])->name('appearance');
        Route::post('contact', [SettingController::class, 'contact'])->name('contact');
        Route::post('e-letter', [SettingController::class, 'e_letter'])->name('e-letter');
    });
