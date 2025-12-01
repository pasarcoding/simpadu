<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\App\Http\Controllers\ProductController;
use Modules\Product\App\Http\Controllers\ProductUserController;

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
Route::get('/', [ProductUserController::class, 'index'])->name('index');
Route::get('{product:slug}', [ProductUserController::class, 'show'])->name('detail');
