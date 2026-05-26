<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
{
    // Mengambil data absensi beserta relasi ke karyawan
    $query = Attendance::with('employee');

    // Filter berdasarkan Tanggal
    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

   $attendances = Attendance::with('employee')->paginate(15);
    return view('attendance', compact('attendances'));
}
}
