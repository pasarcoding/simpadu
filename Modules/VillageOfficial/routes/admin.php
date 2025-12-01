<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\VillageOfficial\App\Http\Controllers\VillageOfficialGreetingController;
use Modules\VillageOfficial\App\Http\Controllers\VillageOfficialHistoryController;
use Modules\VillageOfficial\App\Http\Controllers\VillageOfficialMemberController;
use Modules\VillageOfficial\App\Http\Controllers\VillageOfficialVisionMissionController;

Route::prefix('greeting')
    ->name('greeting.')
    ->group(function () {
        Route::get('/', [VillageOfficialGreetingController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::village_official_greeting_view());
        Route::middleware('permission:' . PermissionName::village_official_greeting_edit())
            ->group(function () {
                Route::get('edit', [VillageOfficialGreetingController::class, 'edit'])->name('edit');
                Route::put('edit', [VillageOfficialGreetingController::class, 'update'])->name('update');
            });
        Route::delete('delete', [VillageOfficialGreetingController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::village_official_greeting_delete());
    });

Route::prefix('history')
    ->name('history.')
    ->group(function () {
        Route::get('/', [VillageOfficialHistoryController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::village_official_history_view());
        Route::middleware('permission:' . PermissionName::village_official_history_edit())
            ->group(function () {
                Route::get('edit', [VillageOfficialHistoryController::class, 'edit'])->name('edit');
                Route::put('edit', [VillageOfficialHistoryController::class, 'update'])->name('update');
            });
        Route::delete('delete', [VillageOfficialHistoryController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::village_official_history_delete());
    });

Route::prefix('vision-mission')
    ->name('vision-mission.')
    ->group(function () {
        Route::get('/', [VillageOfficialVisionMissionController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::village_official_vision_mission_view());
        Route::middleware('permission:' . PermissionName::village_official_vision_mission_edit())
            ->group(function () {
                Route::get('edit', [VillageOfficialVisionMissionController::class, 'edit'])->name('edit');
                Route::put('edit', [VillageOfficialVisionMissionController::class, 'update'])->name('update');
            });
        Route::delete('delete', [VillageOfficialVisionMissionController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::village_official_vision_mission_delete());
    });

Route::prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/', [VillageOfficialMemberController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::village_official_member_view());
        Route::middleware('permission:' . PermissionName::village_official_member_create())
            ->group(function () {
                Route::get('create', [VillageOfficialMemberController::class, 'create'])->name('create');
                Route::post('create', [VillageOfficialMemberController::class, 'store'])->name('store');
            });
        Route::middleware('permission:' . PermissionName::village_official_member_edit())
            ->group(function () {
                Route::get('{villageOfficialMember}/edit', [VillageOfficialMemberController::class, 'edit'])->name('edit');
                Route::put('{villageOfficialMember}/edit', [VillageOfficialMemberController::class, 'update'])->name('update');
            });
        Route::delete('{villageOfficialMember}/delete', [VillageOfficialMemberController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::village_official_member_delete());
    });
