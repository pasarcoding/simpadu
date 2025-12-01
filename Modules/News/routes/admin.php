<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\News\App\Http\Controllers\NewsCommentController;
use Modules\News\App\Http\Controllers\NewsController;

Route::get('/', [NewsController::class, 'index'])->name('index')
    ->middleware('permission:' . PermissionName::news_view());
Route::middleware('permission:' . PermissionName::news_create())
    ->group(function () {
        Route::get('create', [NewsController::class, 'create'])->name('create');
        Route::post('create', [NewsController::class, 'store'])->name('store');
    });
Route::middleware('permission:' . PermissionName::news_edit())
    ->group(function () {
        Route::get('{news}/edit', [NewsController::class, 'edit'])->name('edit');
        Route::put('{news}/edit', [NewsController::class, 'update'])->name('update');
    });
Route::delete('{news}/delete', [NewsController::class, 'destroy'])->name('delete')
    ->middleware('permission:' . PermissionName::news_delete());

Route::prefix('{news}/comment')
    ->name('comment.')
    ->group(function () {
        Route::get('/', [NewsCommentController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::news_comment_view());
        Route::delete('{newsComment}/delete', [NewsCommentController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::news_comment_delete());
    });
