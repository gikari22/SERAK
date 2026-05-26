<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('departments', DepartmentController::class)->except(['create', 'show', 'edit']);

Route::post('employees/bulk-delete', [App\Http\Controllers\EmployeeController::class, 'bulkDelete'])->name('employees.bulkDelete');

Route::resource('employees', EmployeeController::class)->except(['create', 'show', 'edit']);

Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');