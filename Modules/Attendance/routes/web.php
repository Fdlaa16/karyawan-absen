<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use Modules\Attendance\app\Http\Controllers\AttendanceController;

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

Route::get('attendance-index', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('attendance-store', [AttendanceController::class, 'store'])->name('attendance.store');

