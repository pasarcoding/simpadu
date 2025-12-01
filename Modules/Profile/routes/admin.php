<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\Profile\App\Http\Controllers\ProfileController;

Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
Route::put('edit', [ProfileController::class, 'update'])->name('update');
