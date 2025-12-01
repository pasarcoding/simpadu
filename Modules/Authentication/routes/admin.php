<?php

use Illuminate\Support\Facades\Route;
use Modules\Authentication\App\Http\Controllers\AuthenticationController;

Route::middleware('guest')
    ->prefix('login')
    ->name('login.')
    ->group(function () {
        Route::get('/', [AuthenticationController::class, 'login'])->name('index');
        Route::post('/', [AuthenticationController::class, 'do_login'])->name('do');
    });

Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout')
    ->middleware('auth');
