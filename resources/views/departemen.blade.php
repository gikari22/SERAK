@extends('layouts.app')

@section('title', 'Manajemen Departemen')

@section('content')
    <div x-data="{ showAddModal: false, showEditModal: null }">
        
        <div class="flex justify-between items-center mb-6">
            <p class="text-gray-600">Kelola data divisi atau departemen di perusahaan.</p>
            <button @click="showAddModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Departemen
            </button>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Gagal!</p>
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-sm uppercase text-gray-600">
                        <th class="p-4 border-b w-16 text-center">No</th>
                        <th class="p-4 border-b">Nama Departemen</th>
                        <th class="p-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $dept)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 border-b text-center text-gray-700">{{ $loop->iteration }}</td>
                        <td class="p-4 border-b font-medium text-gray-800">{{ $dept->name }}</td>
                        <td class="p-4 border-b text-center">
                            <div class="flex justify-center gap-2">
                                <button @click="showEditModal = {{ $dept->id }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                
                                <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus departemen ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div x-show="showEditModal === {{ $dept->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
                        <div class="bg-white rounded-lg w-1/3 shadow-xl overflow-hidden" @click.away="showEditModal = null">
                            <form action="{{ route('departments.update', $dept->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                                    <h3 class="font-bold text-gray-700">Edit Departemen</h3>
                                    <button type="button" @click="showEditModal = null" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                                </div>
                                <div class="p-6">
                                    <label class="block text-sm text-gray-600 mb-2">Nama Departemen</label>
                                    <input type="text" name="name" value="{{ $dept->name }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                                </div>
                                <div class="px-6 py-4 border-t bg-gray-50 flex justify-end gap-3">
                                    <button type="button" @click="showEditModal = null" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach

                    @if($departments->isEmpty())
                    <tr>
                        <td colspan="3" class="p-6 text-center text-gray-500">Belum ada data departemen.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div x-show="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-lg w-1/3 shadow-xl overflow-hidden" @click.away="showAddModal = false">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Tambah Departemen Baru</h3>
                        <button type="button" @click="showAddModal = false" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="p-6">
                        <label class="block text-sm text-gray-600 mb-2">Nama Departemen</label>
                        <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="Contoh: Finance, HRD, IT" required>
                    </div>
                    <div class="px-6 py-4 border-t bg-gray-50 flex justify-end gap-3">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection