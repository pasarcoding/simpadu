<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Budget\App\Http\Controllers\BudgetController;
use Modules\Budget\App\Http\Controllers\ItemBudgetController;

Route::get('/', [BudgetController::class, 'index'])->name('index')
    ->middleware('permission:' . PermissionName::budget_view());
Route::middleware('permission:' . PermissionName::budget_create())
    ->group(function () {
        Route::get('create', [BudgetController::class, 'create'])->name('create');
        Route::post('create', [BudgetController::class, 'store'])->name('store');
    });
Route::middleware('permission:' . PermissionName::budget_edit())
    ->group(function () {
        Route::get('{budget}/edit', [BudgetController::class, 'edit'])->name('edit');
        Route::put('{budget}/edit', [BudgetController::class, 'update'])->name('update');
    });
Route::delete('{budget}/delete', [BudgetController::class, 'destroy'])->name('delete')
    ->middleware('permission:' . PermissionName::budget_delete());

Route::prefix('{budget}/detail')
    ->name('detail.')
    ->group(function () {
        Route::get('/', [ItemBudgetController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::budget_detail_view());
        Route::middleware('permission:' . PermissionName::budget_detail_create())
            ->group(function () {
                Route::get('create', [ItemBudgetController::class, 'create'])->name('create');
                Route::post('create', [ItemBudgetController::class, 'store'])->name('store');
            });
        Route::delete('{itemBudget}/delete', [ItemBudgetController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::budget_detail_delete());
    });
