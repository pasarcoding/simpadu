<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\App\Http\Controllers\ContactUserController;

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

Route::get('/', [ContactUserController::class, 'index'])->name('index');
Route::post('critique-suggestion', [ContactUserController::class, 'critique_suggestion'])->name('critique-suggestion');
