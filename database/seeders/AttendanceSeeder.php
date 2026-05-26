<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $statuses = ['Hadir', 'Izin', 'Sakit', 'Alpa'];

        foreach ($employees as $emp) {
            // Generate data untuk 30 hari ke belakang
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::now()->subDays($i);
                
                // Hari Sabtu & Minggu biasanya libur, jadi kita lewati
                if ($date->isWeekend()) continue;

                // Random status dengan probabilitas: Hadir paling sering (70%)
                $status = $this->getRandomStatus($statuses);

                Attendance::create([
                    'employee_id' => $emp->id,
                    'date' => $date->format('Y-m-d'),
                    'time_in' => $status == 'Hadir' ? '08:00:00' : null,
                    'time_out' => $status == 'Hadir' ? '17:00:00' : null,
                    'status' => $status,
                    'source' => 'app',
                    'is_late' => ($status == 'Hadir' && rand(1, 10) > 8) ? 1 : 0, // 20% kemungkinan terlambat
                ]);
            }
        }
    }

    private function getRandomStatus($statuses) {
        $rand = rand(1, 100);
        if ($rand <= 70) return 'Hadir';
        if ($rand <= 85) return 'Izin';
        if ($rand <= 95) return 'Sakit';
        return 'Alpa';
    }
}