<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StaffController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login',[\App\Http\Controllers\LoginController::class,'login']);
Route::group(['prefix' => 'admin'], function () {
    // Auth route
    Route::get('/login', [AuthController::class, 'login'])->middleware(['guest:admin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'loginPost'])->middleware(['guest:admin'])->name('admin.loginPost');

    // Admin route
    Route::middleware(['auth:admin'])->group(function () {

        // Auth
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Staff
        Route::prefix('staff')->group(function () {
            Route::get('/list', [StaffController::class, 'index'])->name('staff.list');
            Route::get('/add', [StaffController::class, 'create'])->name('staff.add');
            Route::post('/add', [StaffController::class, 'store'])->name('staff.addPost');
            Route::get('/delete/{id}', [StaffController::class, 'destroy'])->name('staff.delete');
            Route::get('/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
            Route::post('/edit/{id}', [StaffController::class, 'update'])->name('staff.editPost');
            Route::post('/update-status/{id}', [StaffController::class, 'updateStatus'])->name('staff.updateStatus');
            Route::get('/trash', [StaffController::class, 'trash'])->name('staff.trash');
            Route::get('/restore/{id}', [StaffController::class, 'restore'])->name('staff.restore');
            Route::get('/staff.permanently-deleted/{id}', [StaffController::class, 'permanentlyDeleted'])->name('staff.permanently-deleted');

        });
    });
    // Route admin không tồn tại sẽ bắn về view này
    Route::fallback(function () {
        return view('admin.errors.404');
    });
});





