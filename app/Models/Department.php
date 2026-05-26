<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Pastikan ini ada
    public function employees()
    {
        // Department punya banyak Employee melalui kolom department_id
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function attendances()
    {
        // Department punya banyak Attendance melalui relasi karyawan
        return $this->hasManyThrough(Attendance::class, Employee::class, 'department_id', 'employee_id');
    }
}
