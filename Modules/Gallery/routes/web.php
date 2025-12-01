<?php

use Illuminate\Support\Facades\Route;
use Modules\Gallery\App\Http\Controllers\GalleryController;
use Modules\Gallery\App\Http\Controllers\GalleryUserController;

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

Route::get('/', GalleryUserController::class)->name('index');
