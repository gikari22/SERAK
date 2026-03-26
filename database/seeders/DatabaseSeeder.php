<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Divisi
    $depts = ['IT', 'Produksi', 'HRD', 'Gudang'];
    $deptIds = [];
    foreach ($depts as $name) {
        $deptIds[] = Department::create(['name' => $name])->id;
    }

    // 2. Buat Shift
    $shiftPagi = Shift::create([
        'name' => 'Shift Pagi',
        'start_time' => '09:00:00',
        'end_time' => '18:00:00'
    ]);

    $shiftMalam = Shift::create([
        'name' => 'Shift Malam',
        'start_time' => '21:00:00',
        'end_time' => '06:00:00'
    ]);

    // 3. Buat 20 Karyawan dengan Faker
    $faker = \Faker\Factory::create('id_ID'); // Gunakan lokalisasi Indonesia

    for ($i = 1; $i <= 20; $i++) {
        $isTetap = $i <= 10; // 10 Tetap, 10 Harian
        
        $employee = Employee::create([
            'department_id' => $faker->randomElement($deptIds),
            'nip' => 'NIP-' . (1000 + $i),
            'name' => $faker->name,
            'fingerprint_device_id' => $i,
            'type' => $isTetap ? 'Tetap' : 'Harian Lepas',
            'base_salary' => $isTetap ? $faker->numberBetween(5000000, 8000000) : 0,
            'daily_salary' => !$isTetap ? $faker->numberBetween(150000, 200000) : 0,
            'overtime_rate' => $faker->randomElement([20000, 25000, 30000]),
            'joined_at' => $faker->date(),
        ]);

        // 4. Buat Jadwal Rolling untuk Minggu Ini
        // Contoh: ID Ganjil Pagi, ID Genap Malam
        Schedule::create([
            'employee_id' => $employee->id,
            'shift_id' => ($i % 2 == 0) ? $shiftMalam->id : $shiftPagi->id,
            'start_date' => Carbon::now()->startOfWeek(),
            'end_date' => Carbon::now()->endOfWeek()
        ]);
    }
}
