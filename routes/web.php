<?php

use App\Admin\Controllers\HomeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AllowancesController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DeductionsController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\GeneralHelperController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\TaxGroupsController;
use App\Http\Controllers\UserManagementController;
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
    Route::resource('/branch', BranchesController::class);
    Route::resource('/department', DepartmentsController::class);
    Route::resource('/position', PositionsController::class);
    Route::resource('/allowance', AllowancesController::class);
    Route::resource('/deduction', DeductionsController::class);
    Route::resource('/taxgroup', TaxGroupsController::class);

    Route::resource('/user-management', UserManagementController::class)->only(['index', 'create', 'edit','store', 'update','destroy']);
    Route::prefix('/user-management')->group(function () {
        Route::get('/roles', [UserManagementController::class, 'show_roles']);
        Route::POST('/permanent', [UserManagementController::class, 'delete_permanently']);
    });

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('settings')->group(function () {
        Route::get('/business', [BusinessController::class, 'index']);
    });

    // get allowance details
    // Route::post('/get/allowance/details', [GeneralHelperController::class, 'get_allowance_details']);
});

Route::group(['middleware' => ['role:Super-Admin|Admin|Accountant']], function () {
    //
    Route::resource('/payroll', PayrollController::class)->only(['index', 'edit']);
    Route::get('/payroll/show', [PayrollController::class,'show']);
    Route::post('/payroll/process', [PayrollController::class, 'process']);
    Route::post('/edit/allowance', [StaffController::class, 'edit_allowance']);
    Route::post('/edit/deduction', [StaffController::class, 'edit_deduction']);
});

