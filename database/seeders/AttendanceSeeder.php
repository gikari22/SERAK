<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua karyawan yang sudah kita buat di MasterSeeder
        $employees = Employee::all();
        $today = Carbon::today();

        foreach ($employees as $emp) {
            // Kita buat probabilitas 80% karyawan hadir
            if (rand(1, 10) <= 8) {
                
                // Cek apakah dia telat (random jam 08:00 sampai 09:30)
                $hour = rand(8, 9);
                $minute = rand(0, 59);
                $timeIn = sprintf('%02d:%02d:00', $hour, $minute);
                
                // Tandai terlambat jika lewat jam 09:00
                $isLate = ($hour >= 9 && $minute > 0);

                Attendance::create([
                    'employee_id' => $emp->id,
                    'date' => $today,
                    'time_in' => $timeIn,
                    'time_out' => '17:00:00',
                    'status' => 'Hadir',
                    'source' => rand(1, 2) == 1 ? 'fingerprint' : 'app',
                    'is_late' => $isLate,
                ]);
            } else {
                // Sisa 20% karyawan statusnya Izin atau Alpa
                Attendance::create([
                    'employee_id' => $emp->id,
                    'date' => $today,
                    'status' => rand(1, 2) == 1 ? 'Izin' : 'Alpa',
                    'source' => 'app',
                ]);
            }
        }
    }
}
