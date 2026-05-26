<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;

use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    // Data Dummy Sementara
    $totalEmployee = 150;
    $presentToday = 142;
    $absentToday = 8;
    $rekapDivisi = [
        ['nama' => 'IT Support', 'total_staff' => 20, 'hadir' => 19, 'persen' => 95],
        ['nama' => 'Human Resource', 'total_staff' => 5, 'hadir' => 5, 'persen' => 100],
        ['nama' => 'Finance', 'total_staff' => 15, 'hadir' => 12, 'persen' => 80],
    ];

    return view('dashboard', compact('totalEmployee', 'presentToday', 'absentToday', 'rekapDivisi'));
});
Route::resource('departments', DepartmentController::class)->except(['create', 'show', 'edit']);

Route::post('employees/bulk-delete', [App\Http\Controllers\EmployeeController::class, 'bulkDelete'])->name('employees.bulkDelete');

Route::resource('employees', EmployeeController::class)->except(['create', 'show', 'edit']);