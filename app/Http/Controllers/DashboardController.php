<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Department;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $today = Carbon::today();

    $today = Carbon::today();
    $startOfWeek = Carbon::now()->startOfWeek();
    $startOfMonth = Carbon::now()->startOfMonth();

    // 1. Statistik Harian
    $presentToday = Attendance::where('date', $today)->where('status', 'Hadir')->count();

    // 2. Statistik Mingguan (Range 7 hari terakhir atau startOfWeek)
    $presentWeek = Attendance::where('date', '>=', $startOfWeek)
                             ->where('status', 'Hadir')
                             ->count();

    // 3. Statistik Bulanan (StartOfMonth sampai sekarang)
    $presentMonth = Attendance::where('date', '>=', $startOfMonth)
                              ->where('status', 'Hadir')
                              ->count();
    
    // 1. Statistik Utama
    $totalEmployee = Employee::where('status', 'Aktif')->count();
    $presentToday = Attendance::where('date', $today)->where('status', 'Hadir')->count();
    $absentToday = $totalEmployee - $presentToday;

   // 2. Persentase Kehadiran Per Departemen
    $rekapDivisi = Department::withCount([
        'employees as total_staff' => function($q) { 
            // Tambahkan 'employees.' sebelum 'status'
            $q->where('employees.status', 'Aktif'); 
        },
        'attendances as hadir' => function($q) use ($today) {
            // Tambahkan 'attendances.' sebelum 'status'
            $q->where('attendances.date', $today)
              ->where('attendances.status', 'Hadir');
        }
    ])->get()->map(function($dept) {
        $persen = $dept->total_staff > 0 
            ? round(($dept->hadir / $dept->total_staff) * 100, 2) 
            : 0;

        return [
            'nama' => $dept->name,
            'total_staff' => $dept->total_staff,
            'hadir' => $dept->hadir,
            'persen' => $persen
        ];
    });

   return view('dashboard', compact(
        'totalEmployee', 
        'absentToday',
        'presentToday', 
        'presentWeek', 
        'presentMonth', 
        'rekapDivisi'
    ));
}
}
