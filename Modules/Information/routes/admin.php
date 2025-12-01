<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Information\App\Http\Controllers\InformationController;

Route::get('/', [InformationController::class, 'index'])->name('index')
    ->middleware('permission:' . PermissionName::information_view());
Route::middleware('permission:' . PermissionName::information_create())
    ->group(function () {
        Route::get('create', [InformationController::class, 'create'])->name('create');
        Route::post('create', [InformationController::class, 'store'])->name('store');
    });
Route::middleware('permission:' . PermissionName::information_edit())
    ->group(function () {
        Route::get('{information}/edit', [InformationController::class, 'edit'])->name('edit');
        Route::put('{information}/edit', [InformationController::class, 'update'])->name('update');
    });
Route::delete('{information}/delete', [InformationController::class, 'destroy'])->name('delete')
    ->middleware('permission:' . PermissionName::information_delete());
