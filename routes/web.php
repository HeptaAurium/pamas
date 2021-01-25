<?php

use App\Admin\Controllers\HomeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AllowancesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::resource('/staff', StaffController::class);
    Route::resource('/allowance', AllowancesController::class);

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
