<?php

use App\Admin\Controllers\HomeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AllowancesController;
use App\Http\Controllers\BanksController;
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

    Route::resource('/allowance', AllowancesController::class);
    Route::resource('/branch', BranchesController::class);
    Route::resource('/department', DepartmentsController::class);
    Route::resource('/position', PositionsController::class);
    Route::resource('/allowance', AllowancesController::class);
    Route::resource('/deduction', DeductionsController::class);
    Route::resource('/taxgroup', TaxGroupsController::class);
    Route::resource('/bank', BanksController::class);

    Route::post('/bank/update/primary', [BanksController::class, 'update_primary']);

    Route::resource('/user-management', UserManagementController::class)->only(['index', 'create', 'edit', 'store', 'update', 'destroy']);

    Route::prefix('/user-management')->group(function () {
        Route::get('/roles', [UserManagementController::class, 'show_roles']);
        Route::POST('/permanent', [UserManagementController::class, 'delete_permanently']);
    });

    // Upload csv


    Route::post('/staff/upload/csv', [StaffController::class, 'upload_csv']);
    Route::post('/staff/profile', [StaffController::class, 'profile']);
    Route::resource('/staff', StaffController::class);



    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('settings')->group(function () {
        Route::get('/business', [BusinessController::class, 'index']);
        Route::post('/update', [BusinessController::class, 'update']);
    });
    Route::prefix('settings')->group(function () {
        Route::get('/business', [BusinessController::class, 'index']);
        Route::post('/update', [BusinessController::class, 'update']);
    });

    // Edit staff allowance details
    Route::get('/allowance/edit/{id}', [AllowancesController::class, 'staff_allowances']);
    Route::post('/allowance/update', [AllowancesController::class, 'staff_allowances_update']);

    // Edit staff deduction details
    Route::get('/deduction/edit/{id}', [DeductionsController::class, 'staff_deductions']);
    Route::post('/deduction/update', [DeductionsController::class, 'staff_deductions_update']);
});

Route::group(['middleware' => ['role:Super-Admin|Admin|Accountant']], function () {
    //
    Route::resource('/payroll', PayrollController::class)->only(['index', 'edit']);
    Route::get('/payroll/show', [PayrollController::class, 'show']);
    Route::get('/payroll/filter', [PayrollController::class, 'filter']);
    Route::post('/payroll/process', [PayrollController::class, 'process']);
    Route::post('/edit/allowance', [StaffController::class, 'edit_allowance']);
    Route::post('/edit/deduction', [StaffController::class, 'edit_deduction']);
});
