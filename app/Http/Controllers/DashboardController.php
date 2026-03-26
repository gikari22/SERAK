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
        
        // 1. Statistik Utama
        $totalEmployee = Employee::where('status', 'Aktif')->count();
        $presentToday = Attendance::where('date', $today)->where('status', 'Hadir')->count();
        $absentToday = $totalEmployee - $presentToday;

        // 2. Persentase Kehadiran Per Departemen
        $departments = Department::withCount(['employees' => function($query) {
            $query->where('status', 'Aktif');
        }])->get();

        $rekapDivisi = $departments->map(function($dept) use ($today) {
            $hadir = Attendance::where('date', $today)
                ->whereHas('employee', function($q) use ($dept) {
                    $q->where('department_id', $dept->id);
                })->count();
            
            // Hitung persentase
            $persen = $dept->employees_count > 0 
                ? round(($hadir / $dept->employees_count) * 100, 2) 
                : 0;

            return [
                'nama' => $dept->name,
                'total_staff' => $dept->employees_count,
                'hadir' => $hadir,
                'persen' => $persen
            ];
        });

        return view('dashboard', compact('totalEmployee', 'presentToday', 'absentToday', 'rekapDivisi'));
    }
}
