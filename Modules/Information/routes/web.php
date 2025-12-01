<?php

use Illuminate\Support\Facades\Route;
use Modules\Information\App\Http\Controllers\InformationController;
use Modules\Information\App\Http\Controllers\InformationUserController;

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

Route::get('/', [InformationUserController::class, 'index'])->name('index');
Route::get('{information:slug}', [InformationUserController::class, 'show'])->name('detail');
