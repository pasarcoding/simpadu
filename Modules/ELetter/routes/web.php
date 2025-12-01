<?php

use Illuminate\Support\Facades\Route;
use Modules\ELetter\App\Http\Controllers\ELetterController;
use Modules\ELetter\App\Http\Controllers\EletterSubmissionUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [EletterSubmissionUserController::class, 'index'])->name('index');
Route::post('resident_by_national_id', [EletterSubmissionUserController::class, 'residentByNationalID'])->name('resident_by_national_id');
Route::post('/', [EletterSubmissionUserController::class, 'store'])->name('store');
