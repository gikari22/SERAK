@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <p class="text-sm text-gray-500 uppercase font-bold">Total Karyawan</p>
            <p class="text-3xl font-semibold">{{ $totalEmployee }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <p class="text-sm text-gray-500 uppercase font-bold">Hadir Hari Ini</p>
            <p class="text-3xl font-semibold text-green-600">{{ $presentToday }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
            <p class="text-sm text-gray-500 uppercase font-bold">Tidak Hadir (Izin/Alpa)</p>
            <p class="text-3xl font-semibold text-red-600">{{ $absentToday }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 bg-gray-50 border-b">
            <h2 class="font-bold text-gray-700">Kehadiran Per Departemen</h2>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-sm uppercase text-gray-600">
                    <th class="p-4 border-b">Nama Departemen</th>
                    <th class="p-4 border-b text-center">Total Staff</th>
                    <th class="p-4 border-b text-center">Hadir</th>
                    <th class="p-4 border-b">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekapDivisi as $data)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 border-b font-medium text-gray-800">{{ $data['nama'] }}</td>
                    <td class="p-4 border-b text-center">{{ $data['total_staff'] }}</td>
                    <td class="p-4 border-b text-center">{{ $data['hadir'] }}</td>
                    <td class="p-4 border-b w-1/3">
                        <div class="flex items-center">
                            <span class="mr-3 font-semibold text-gray-700 w-12">{{ $data['persen'] }}%</span>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $data['persen'] }}%"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection