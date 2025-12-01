<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Product\App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('index')
    ->middleware('permission:' . PermissionName::product_view());
Route::middleware('permission:' . PermissionName::product_create())
    ->group(function () {
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('create', [ProductController::class, 'store'])->name('store');
    });
Route::middleware('permission:' . PermissionName::product_edit())
    ->group(function () {
        Route::get('{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('{product}/edit', [ProductController::class, 'update'])->name('update');
    });
Route::delete('{product}/delete', [ProductController::class, 'destroy'])->name('delete')
    ->middleware('permission:' . PermissionName::product_delete());
