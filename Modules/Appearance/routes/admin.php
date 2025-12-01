<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Appearance\App\Http\Controllers\AppearanceMenuController;
use Modules\Appearance\App\Http\Controllers\AppearancePageController;

Route::prefix('menu')
    ->name('menu.')
    ->group(function () {
        Route::get('/', [AppearanceMenuController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::appearance_menu_view());
        Route::middleware('permission:' . PermissionName::appearance_menu_create())
            ->group(function () {
                Route::get('create', [AppearanceMenuController::class, 'create'])->name('create');
                Route::post('create', [AppearanceMenuController::class, 'store'])->name('store');
            });
        Route::middleware('permission:' . PermissionName::appearance_menu_edit())
            ->group(function () {
                Route::get('{appearanceMenu}/edit', [AppearanceMenuController::class, 'edit'])->name('edit');
                Route::put('{appearanceMenu}/edit', [AppearanceMenuController::class, 'update'])->name('update');
            });
        Route::delete('{appearanceMenu}/delete', [AppearanceMenuController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::appearance_menu_delete());
    });

Route::prefix('page')
    ->name('page.')
    ->group(function () {
        Route::get('/', [AppearancePageController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::appearance_page_view());
        Route::middleware('permission:' . PermissionName::appearance_page_create())
            ->group(function () {
                Route::get('create', [AppearancePageController::class, 'create'])->name('create');
                Route::post('create', [AppearancePageController::class, 'store'])->name('store');
            });
        Route::middleware('permission:' . PermissionName::appearance_page_edit())
            ->group(function () {
                Route::get('{appearancePage}/edit', [AppearancePageController::class, 'edit'])->name('edit');
                Route::put('{appearancePage}/edit', [AppearancePageController::class, 'update'])->name('update');
            });
        Route::delete('{appearancePage}/delete', [AppearancePageController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::appearance_page_delete());
    });
