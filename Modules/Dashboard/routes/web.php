<?php

use App\Models\Absen;
use App\Models\Cuti;
use App\Models\Employee;
use Modules\Dashboard\app\Http\Controllers\AbsenController;
use Modules\Dashboard\app\Http\Controllers\EmployeeController;
use Modules\Dashboard\app\Http\Controllers\EmployeeGroupController;
use Modules\Dashboard\app\Http\Controllers\PresenceController;
use Modules\Dashboard\app\Http\Controllers\ShiftController;
use Modules\Dashboard\app\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Modules\Dashboard\app\Http\Controllers\ApprovalCutiController;
use Modules\Dashboard\app\Http\Controllers\CutiController;
use Modules\Dashboard\app\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function(){
    return view('login');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function(){
        return view('Dashboard::index', [
            'absens' => Absen::all(),
            'cutis' => Cuti::all(),
            'employees' => Employee::all(),
        ]);
    });

    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee/search', [EmployeeController::class, 'index'])->name('employee.search');
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::put('/employee/{id}/sendEmail', [EmployeeController::class, 'sendEmail'])->name('employee.sendEmail');
    Route::resource('/employee', EmployeeController::class);

    Route::get('/employeeGroup', [EmployeeGroupController::class, 'index'])->name('employeeGroup.index');
    Route::get('/employeeGroup/search', [EmployeeGroupController::class, 'index'])->name('employeeGroup.search');
    Route::get('/employeeGroup/create', [EmployeeGroupController::class, 'create'])->name('employeeGroup.create');
    Route::resource('/employeeGroup', EmployeeGroupController::class);

    Route::get('/presence', [PresenceController::class, 'index'])->name('presence.index');
    Route::get('/presence/search', [PresenceController::class, 'index'])->name('presence.search');
    Route::get('/presence/create', [PresenceController::class, 'create'])->name('presence.create');
    Route::resource('/presence', PresenceController::class);

    Route::get('/absen', [AbsenController::class, 'index'])->name('absen.index');
    Route::get('/absen/search', [AbsenController::class, 'index'])->name('absen.search');
    Route::get('/absen/create', [AbsenController::class, 'create'])->name('absen.create');
    Route::resource('/absen', AbsenController::class);
    
    Route::get('/laporan', [AbsenController::class, 'laporanIndex'])->name('laporan.index');
    Route::post('/laporan/download', [AbsenController::class, 'download'])->name('laporan.download');
    Route::post('/laporan/search', [AbsenController::class, 'search'])->name('laporan.search');

    Route::get('/shift', [ShiftController::class, 'index'])->name('shift.index');
    Route::get('/shift/search', [ShiftController::class, 'index'])->name('shift.search');
    Route::get('/shift/create', [ShiftController::class, 'create'])->name('shift.create');
    Route::resource('/shift', ShiftController::class);

    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/search', [CutiController::class, 'index'])->name('cuti.search');
    Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
    Route::resource('/cuti', CutiController::class);

    Route::get('/approval-cuti', [ApprovalCutiController::class, 'index'])->name('approval-cuti.index');
    Route::get('/approval-cuti/search', [ApprovalCutiController::class, 'index'])->name('approval-cuti.search');
    Route::put('/approval-cuti/{id}/approve', [ApprovalCutiController::class, 'approve'])->name('approval-cuti.approve');
    Route::put('/approval-cuti/{id}/reject', [ApprovalCutiController::class, 'reject'])->name('approval-cuti.reject');
    Route::resource('/approval-cuti', ApprovalCutiController::class);

    Route::get('/logout', [UserController::class, 'destroy']);
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile-update', [UserController::class, 'update'])->name('profile-update');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [UserController::class, 'create']);
    Route::post('/session', [UserController::class, 'store']);
	// Route::get('/login/forgot-password', [ResetController::class, 'create']);
	// Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	// Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	// Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});
