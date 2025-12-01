<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Resident\App\Http\Controllers\ResidentController;
use Modules\Resident\App\Http\Controllers\ResidentFormController;

Route::get('/', [ResidentController::class, 'index'])->name('index')
    ->middleware('permission:' . PermissionName::resident_view());
Route::middleware('permission:' . PermissionName::resident_create())
    ->group(function () {
        Route::get('create', [ResidentController::class, 'create'])->name('create');
        Route::post('create', [ResidentController::class, 'store'])->name('store');
    });
Route::middleware('permission:' . PermissionName::resident_import_view())
    ->group(function () {
        Route::get('import', [ResidentController::class, 'import'])->name('import');
        Route::post('import', [ResidentController::class, 'store_import'])->name('store-import');
        Route::get('export_template', [ResidentController::class, 'export_template'])->name('export-template');
    });
Route::get('export', [ResidentController::class, 'export'])->name('export')
    ->middleware('permission:' . PermissionName::resident_export_view());
Route::prefix('form')
    ->name('form.')
    ->group(function () {
        Route::get('/', [ResidentFormController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::resident_form_view());
        Route::middleware('permission:' . PermissionName::resident_form_create())
            ->group(function () {
                Route::get('create', [ResidentFormController::class, 'create'])->name('create');
                Route::post('create', [ResidentFormController::class, 'store'])->name('store');
            });
        Route::middleware('permission:' . PermissionName::resident_form_edit())
            ->group(function () {
                Route::get('{residentForm}/edit', [ResidentFormController::class, 'edit'])->name('edit');
                Route::put('{residentForm}/edit', [ResidentFormController::class, 'update'])->name('update');
            });
        Route::delete('{residentForm}/delete', [ResidentFormController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::resident_form_delete());
    });
Route::middleware('permission:' . PermissionName::resident_edit())->group(function () {
    Route::get('{resident}/edit', [ResidentController::class, 'edit'])->name('edit');
    Route::put('{resident}/edit', [ResidentController::class, 'update'])->name('update');
});
Route::delete('{resident}/delete', [ResidentController::class, 'destroy'])->name('delete')
    ->middleware('permission:' . PermissionName::resident_delete());
Route::delete('reset', [ResidentController::class, 'reset'])->name('reset')
    ->middleware('permission:' . PermissionName::resident_delete());
Route::get('{resident}', [ResidentController::class, 'show'])->name('detail')
    ->middleware('permission:' . PermissionName::resident_detail_view());
