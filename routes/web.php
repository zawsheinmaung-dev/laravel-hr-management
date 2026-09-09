<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\SalaryStructureController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login_check'])->name('login_check');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('dashboard',DashboardController::class);
    Route::get('role', [RoleAndPermissionController::class, 'get_role'])->name('get_role');
    Route::post('role/update', [RoleAndPermissionController::class, 'update_role'])->name('update_role');
    Route::post('role/create', [RoleAndPermissionController::class, 'create_role'])->name('create_role');
    Route::post('role/delete/{id}', [RoleAndPermissionController::class, 'delete_role'])->name('delete_role');
    Route::post('role/update/permissions', [RoleAndPermissionController::class, 'update_role_permissions'])->name('update_role_permissions');

    Route::get('/branches/search/{search}', [BranchController::class, 'search'])->name('branches_search');


    Route::resource('employees', EmployeeController::class);
    Route::get('/employees-search', [EmployeeController::class, 'search'])->name('search.manager');

    Route::resource('branches', BranchController::class);
    Route::resource('deparments', DepartmentController::class);
    Route::resource('positions', PositionController::class);

    Route::post("/shifts-assign", [ShiftController::class, "shift_assign"])->name('shift.assign');
    Route::post("/shifts-delete/{id}", [ShiftController::class, "shift_assign_delete"])->name('shift.delete');
    Route::resource('shifts', ShiftController::class);

    Route::get('/attendance',[AttendanceController::class,'index'])->name('attendance.index');
    Route::post('/attendance/checkIn',[AttendanceController::class,'check_in'])->name('attendance.checkIn');
    Route::post('/attendance/checkOut',[AttendanceController::class,'check_out'])->name('attendance.checkOut');
    Route::get('/attendance/show/{id}',[AttendanceController::class,'show'])->name('attendance.show');
    
    Route::resource('/overtime',OvertimeController::class);
    Route::resource('/leave',LeaveController::class);

    Route::resource('/payroll',SalaryStructureController::class);
});
