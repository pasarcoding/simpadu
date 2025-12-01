<?php

use App\Constants\PermissionName;
use Illuminate\Support\Facades\Route;
use Modules\ELetter\App\Http\Controllers\ELetterSubmissionController;
use Modules\ELetter\App\Http\Controllers\ELetterTemplateController;

Route::prefix('template')
    ->name('template.')
    ->group(function () {
        Route::get('/', [ELetterTemplateController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::e_letter_template_view());
        Route::middleware('permission:' . PermissionName::e_letter_template_create())
            ->group(function () {
                Route::get('create', [ELetterTemplateController::class, 'create'])->name('create');
                Route::post('create', [ELetterTemplateController::class, 'store'])->name('store');
            });
        Route::middleware('permission:' . PermissionName::e_letter_template_edit())
            ->group(function () {
                Route::get('{eLetterTemplate}/edit', [ELetterTemplateController::class, 'edit'])->name('edit');
                Route::put('{eLetterTemplate}/edit', [ELetterTemplateController::class, 'update'])->name('update');
            });
        Route::delete('{eLetterTemplate}/delete', [ELetterTemplateController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::e_letter_template_delete());
    });

Route::prefix('submission')
    ->name('submission.')
    ->group(function () {
        Route::get('/', [ELetterSubmissionController::class, 'index'])->name('index')
            ->middleware('permission:' . PermissionName::e_letter_submission_view());
        Route::middleware('permission:' . PermissionName::e_letter_submission_edit())
            ->group(function () {
                Route::get('{eLetterSubmission}/edit', [ELetterSubmissionController::class, 'edit'])->name('edit');
                Route::put('{eLetterSubmission}/edit', [ELetterSubmissionController::class, 'update'])->name('update');
            });
        Route::delete('{eLetterSubmission}/delete', [ELetterSubmissionController::class, 'destroy'])->name('delete')
            ->middleware('permission:' . PermissionName::e_letter_submission_delete());
        Route::get('{eLetterSubmission}/download', [ELetterSubmissionController::class, 'download'])->name('download');
        Route::get('{eLetterSubmission}', [ELetterSubmissionController::class, 'show'])->name('detail')
            ->middleware('permission:' . PermissionName::e_letter_submission_detail_view());
    });
