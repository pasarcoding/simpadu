<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\SynergyProgram\App\Http\Controllers\SynergyProgramController;

Route::get('/', [SynergyProgramController::class, 'index'])->name('index')
    ->middleware('permission:' . PermissionName::synergy_program_view());
Route::middleware('permission:' . PermissionName::synergy_program_create())
    ->group(function () {
        Route::get('create', [SynergyProgramController::class, 'create'])->name('create');
        Route::post('create', [SynergyProgramController::class, 'store'])->name('store');
    });
Route::delete('{synergyProgram}/delete', [SynergyProgramController::class, 'destroy'])->name('delete')
    ->middleware('permission:' . PermissionName::synergy_program_delete());
