<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Shift;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
       // 1. Mulai query dasar
        $query = Employee::with('department');

        // 2. Filter Pencarian (Cari berdasarkan Nama ATAU NIK)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%"); // <--- Sesuaikan ini
            });
        }

        // 3. Filter berdasarkan Departemen
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // 4. Filter berdasarkan Status Aktif/Resign
        if ($request->filled('type')) {
            $query->where('type', $request->status);
        }

        // 5. Eksekusi query dengan Pagination (misal: 10 data per halaman)
        // withQueryString() berguna agar filter tidak hilang saat pindah halaman
        $employees = $query->latest()->paginate(10)->withQueryString();
        
        $departments = Department::all();

        $shifts = Shift::all();
        
        return view('karyawan', compact('employees', 'departments', 'shifts'));
    }

    public function store(Request $request)
    {
       // Validasi menggunakan nama kolom yang baru (sesuai database)
        $request->validate([
            'NIK' => 'required|unique:employees,NIK',
            'name' => 'required|string|max:255',
            'department_id' => 'required',
            'shift_id' => 'nullable',
            'fingerprint_device_id' => 'nullable|numeric',
            'type' => 'required',
            'status' => 'required',
            'base_salary' => 'nullable|numeric',
            'daily_salary' => 'nullable|numeric',
            'overtime_rate' => 'nullable|numeric',
            'joined_at' => 'required|date',
        ]);

        Employee::create($request->all());
        return redirect()->back()->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'NIK' => 'required|unique:employees,NIK,' . $employee->id,
            'name' => 'required|string|max:255',
            'department_id' => 'required',
            'shift_id' => 'nullable',
            'fingerprint_device_id' => 'nullable|numeric',
            'type' => 'required',
            'status' => 'required',
            'base_salary' => 'nullable|numeric',
            'daily_salary' => 'nullable|numeric',
            'overtime_rate' => 'nullable|numeric',
            'joined_at' => 'required|date',
        ]);

        $employee->update($request->all());
        return redirect()->back()->with('success', 'Data karyawan berhasil diperbarui!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->back()->with('success', 'Data karyawan berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        if ($request->ids) {
            // Karena dari form Alpine wujudnya string "1,2,3", kita ubah jadi array
            $ids = explode(',', $request->ids); 
            Employee::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', count($ids) . ' karyawan terpilih berhasil dihapus!');
        }
        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }
}
