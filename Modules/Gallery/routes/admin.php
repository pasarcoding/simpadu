<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Gallery\App\Http\Controllers\GalleryController;

Route::get('/', [GalleryController::class, 'index'])->name('index')
    ->middleware('permission:' . PermissionName::gallery_view());
Route::middleware('permission:' . PermissionName::gallery_create())
    ->group(function () {
        Route::get('create', [GalleryController::class, 'create'])->name('create');
        Route::post('create', [GalleryController::class, 'store'])->name('store');
    });
Route::delete('{gallery}/delete', [GalleryController::class, 'destroy'])->name('delete')
    ->middleware('permission:' . PermissionName::gallery_delete());
