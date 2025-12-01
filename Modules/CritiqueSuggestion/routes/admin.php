<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\CritiqueSuggestion\App\Http\Controllers\CritiqueSuggestionController;

Route::get('/', [CritiqueSuggestionController::class, 'index'])->name('index')
    ->middleware('permission:' . PermissionName::critique_suggestion_view());
Route::delete('{critiqueSuggestion}/delete', [CritiqueSuggestionController::class, 'destroy'])->name('delete')
    ->middleware('permission:' . PermissionName::critique_suggestion_delete());
