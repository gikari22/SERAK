<?php

namespace App\Http\Controllers;
use App\Models\Department;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index() {
        $departments = Department::all();
        return view('departemen', compact('departments'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:departments,name']);
        Department::create($request->all());
        return redirect()->back()->with('success', 'Departemen berhasil ditambah!');
    }

    public function update(Request $request, Department $department) {
        $request->validate(['name' => 'required|unique:departments,name,'.$department->id]);
        $department->update($request->all());
        return redirect()->back()->with('success', 'Departemen berhasil diupdate!');
    }

    public function destroy(Department $department) {
        try {
            $department->delete();
            return redirect()->back()->with('success', 'Departemen berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == "23000") {
                return redirect()->back()->with('error', 'Departemen tidak bisa dihapus karena masih ada karyawan di dalamnya!');
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
