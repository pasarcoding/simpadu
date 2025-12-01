<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Access\App\Http\Controllers\AccessRolePermissionController;
use Modules\Access\App\Http\Controllers\AccessUserController;

Route::prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/', [AccessUserController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::access_user_view());
        Route::middleware('permission:' . PermissionName::access_user_create())
            ->group(function () {
                Route::get('create', [AccessUserController::class, 'create'])->name('create');
                Route::post('create', [AccessUserController::class, 'store'])->name('store');
            });
        Route::middleware('permission:' . PermissionName::access_user_edit())
            ->group(function () {
                Route::get('{user}/edit', [AccessUserController::class, 'edit'])->name('edit');
                Route::put('{user}/edit', [AccessUserController::class, 'update'])->name('update');
            });
        Route::delete('{user}/delete', [AccessUserController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::access_user_delete());
    });

Route::prefix('role-permission')
    ->name('role-permission.')
    ->group(function () {
        Route::get('/', [AccessRolePermissionController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::access_role_permission_view());
        Route::middleware('permission:' . PermissionName::access_role_permission_create())
            ->group(function () {
                Route::get('create', [AccessRolePermissionController::class, 'create'])->name('create');
                Route::post('create', [AccessRolePermissionController::class, 'store'])->name('store');
            });
        Route::middleware('permission:' . PermissionName::access_role_permission_edit())
            ->group(function () {
                Route::get('{role}/edit', [AccessRolePermissionController::class, 'edit'])->name('edit');
                Route::put('{role}/edit', [AccessRolePermissionController::class, 'update'])->name('update');
            });
        Route::delete('{role}/delete', [AccessRolePermissionController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::access_role_permission_delete());
    });
