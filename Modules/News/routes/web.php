<?php

use Illuminate\Support\Facades\Route;
use Modules\News\App\Http\Controllers\NewsController;
use Modules\News\App\Http\Controllers\NewsUserController;

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

Route::get('/', [NewsUserController::class, 'index'])->name('index');
Route::get('{news:slug}', [NewsUserController::class, 'show'])->name('detail');
Route::post('{news:slug}/comment', [NewsUserController::class, 'comment'])->name('comment');
