@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
    <div x-data="{ showAddModal: false, showEditModal: null }">
        
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <p class="text-gray-600">Kelola data seluruh karyawan, status, dan gaji pokok.</p>
            <button @click="showAddModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2">
                <i class="fas fa-user-plus"></i> Tambah Karyawan
            </button>
        </div>

        <form action="{{ route('employees.index') }}" method="GET" class="bg-white p-4 rounded-lg shadow mb-6 flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm text-gray-600 mb-1">Cari NIK / Nama</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       x-on:input.debounce.500ms="$el.closest('form').submit()" 
                       placeholder="Ketik kata kunci lalu tunggu sejenak..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none">
            </div>
            
            <div class="w-48">
                <label class="block text-sm text-gray-600 mb-1">Departemen</label>
                <select name="department" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-48">
                <label class="block text-sm text-gray-600 mb-1">Tipe Karyawan</label>
                <select name="type" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:outline-none">
                    <option value="">Semua Tipe</option>
                    <option value="Tetap" {{ request('type') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="Kontrak" {{ request('type') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                    <option value="Harian Lepas" {{ request('type') == 'Harian Lepas' ? 'selected' : '' }}>Harian Lepas</option>
                </select>
            </div>
            
            @if(request()->hasAny(['search', 'department', 'type']))
            <div>
                <a href="{{ route('employees.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition flex items-center gap-2 h-[42px]">
                    <i class="fas fa-times"></i> Reset
                </a>
            </div>
            @endif
        </form>

       <div x-data="{ selectedItems: [], selectAll: false }" class="bg-white rounded-lg shadow overflow-hidden">
            
            <div x-show="selectedItems.length > 0" x-transition class="bg-blue-50 p-4 border-b border-blue-100 flex justify-between items-center" style="display: none;">
                <span class="text-blue-800 font-medium">
                    <span x-text="selectedItems.length"></span> karyawan dipilih
                </span>
                <form action="{{ route('employees.bulkDelete') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="ids" x-bind:value="selectedItems.join(',')">
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus semua karyawan yang dipilih?')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg text-sm transition shadow-sm">
                        <i class="fas fa-trash"></i> Hapus Terpilih
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-100 text-sm uppercase text-gray-600">
                            <th class="p-4 border-b w-10 text-center">
                                <input type="checkbox" x-model="selectAll" @change="selectedItems = selectAll ? {{ json_encode($employees->pluck('id')) }} : []" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                            </th>
                            <th class="p-4 border-b">NIK</th>
                            <th class="p-4 border-b">Nama</th>
                            <th class="p-4 border-b">Departemen</th>
                            <th class="p-4 border-b">Tipe Karyawan</th>
                            <th class="p-4 border-b text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $emp)
                        <tr class="hover:bg-gray-50 {{ request('search') ? 'bg-yellow-50' : '' }}">
                            <td class="p-4 border-b text-center">
                                <input type="checkbox" value="{{ $emp->NIK }}" x-model="selectedItems" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                            </td>
                            <td class="p-4 border-b font-medium text-gray-800">{{ $emp->NIK }}</td>
                            <td class="p-4 border-b">{{ $emp->name }}</td>
                            <td class="p-4 border-b">{{ $emp->department->name ?? '-' }}</td>
                            <td class="p-4 border-b">
                                @if($emp->type == 'Tetap')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Tetap</span>
                                @elseif($emp->type == 'Harian Lepas')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Harian Lepas</span>
                                @elseif($emp->type == 'Kontrak')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Kontrak</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $emp->type }}</span>
                                @endif
                            </td>
                            <td class="p-4 border-b text-center">
                                <div class="flex justify-center gap-2">
                                    <button @click="showEditModal = {{ $emp->id }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div x-show="showEditModal === {{ $emp->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto" style="display: none;">
                            <div class="bg-white rounded-lg w-1/2 shadow-xl my-8" @click.away="showEditModal = null">
                                <form action="{{ route('employees.update', $emp->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                                        <h3 class="font-bold text-gray-700">Edit Karyawan</h3>
                                        <button type="button" @click="showEditModal = null" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="p-6 grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">NIK</label>
                                            <input type="text" name="NIK" value="{{ $emp->NIK }}" class="w-full border rounded px-3 py-2" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                                            <input type="text" name="name" value="{{ $emp->name }}" class="w-full border rounded px-3 py-2" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">Departemen</label>
                                            <select name="department_id" class="w-full border rounded px-3 py-2" required>
                                                @foreach($departments as $dept)
                                                    <option value="{{ $dept->id }}" {{ $emp->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">Shift</label>
                                            <select name="shift_id" class="w-full border rounded px-3 py-2">
                                                <option value="">-- Pilih Shift --</option>
                                                @foreach($shifts as $shift)
                                                    <option value="{{ $shift->id }}" {{ $emp->shift_id == $shift->id ? 'selected' : '' }}>{{ $shift->name ?? 'Shift '.$shift->id }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">Tipe Karyawan</label>
                                            <select name="type" class="w-full border rounded px-3 py-2" required>
                                                <option value="Tetap" {{ $emp->type == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                                <option value="Kontrak" {{ $emp->type == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                                <option value="Harian Lepas" {{ $emp->type == 'Harian Lepas' ? 'selected' : '' }}>Harian Lepas</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">Status Karyawan</label>
                                            <select name="status" class="w-full border rounded px-3 py-2" required>
                                                <option value="Aktif" {{ $emp->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Resign" {{ $emp->status == 'Resign' ? 'selected' : '' }}>Resign</option>
                                                <option value="PHK" {{ $emp->status == 'PHK' ? 'selected' : '' }}>PHK</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">Gaji Pokok / Bulanan (Rp)</label>
                                            <input type="number" name="base_salary" value="{{ intval($emp->base_salary) }}" class="w-full border rounded px-3 py-2">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">Gaji Harian (Rp)</label>
                                            <input type="number" name="daily_salary" value="{{ intval($emp->daily_salary) }}" class="w-full border rounded px-3 py-2">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">Tarif Lembur per Jam (Rp)</label>
                                            <input type="number" name="overtime_rate" value="{{ intval($emp->overtime_rate) }}" class="w-full border rounded px-3 py-2">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-600 mb-1">Tanggal Bergabung</label>
                                            <input type="date" name="joined_at" value="{{ $emp->joined_at ? \Carbon\Carbon::parse($emp->joined_at)->format('Y-m-d') : '' }}" class="w-full border rounded px-3 py-2" required>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 border-t bg-gray-50 flex justify-end gap-3">
                                        <button type="button" @click="showEditModal = null" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach

                        @if($employees->isEmpty())
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">Data karyawan tidak ditemukan.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $employees->links() }}
        </div>

        <div x-show="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto" style="display: none;">
            <div class="bg-white rounded-lg w-1/2 shadow-xl my-8" @click.away="showAddModal = false">
                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf
                    <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Tambah Karyawan Baru</h3>
                        <button type="button" @click="showAddModal = false" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="p-6 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">NIP</label>
                            <input type="text" name="NIK" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Departemen</label>
                            <select name="department_id" class="w-full border rounded px-3 py-2" required>
                                <option value="">-- Pilih Departemen --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Shift</label>
                            <select name="shift_id" class="w-full border rounded px-3 py-2">
                                <option value="">-- Pilih Shift (Opsional) --</option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->name ?? 'Shift '.$shift->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tipe Karyawan</label>
                            <select name="type" class="w-full border rounded px-3 py-2" required>
                                <option value="Tetap">Tetap</option>
                                <option value="Kontrak">Kontrak</option>
                                <option value="Harian Lepas">Harian Lepas</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Status Karyawan</label>
                            <select name="status" class="w-full border rounded px-3 py-2" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Resign">Resign</option>
                                <option value="PHK">PHK</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Gaji Pokok / Bulanan (Rp)</label>
                            <input type="number" name="base_salary" value="0" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Gaji Harian (Rp)</label>
                            <input type="number" name="daily_salary" value="0" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tarif Lembur per Jam (Rp)</label>
                            <input type="number" name="overtime_rate" value="0" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tanggal Bergabung</label>
                            <input type="date" name="joined_at" class="w-full border rounded px-3 py-2" required>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t bg-gray-50 flex justify-end gap-3">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection