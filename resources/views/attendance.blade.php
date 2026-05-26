@extends('layouts.app')
@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Laporan Absensi</h2>
    
    <form method="GET" class="mb-4">
        <input type="date" name="date" value="{{ request('date') }}" class="border p-2 rounded">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
    </form>

    <table class="w-full text-left">
        <tr class="bg-gray-100">
            <th class="p-3">NIP</th>
            <th class="p-3">Nama</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Jam Masuk</th>
            <th class="p-3">Status</th>
        </tr>
        @foreach($attendances as $att)
        <tr>
            <td class="p-3">{{ $att->employee->NIK }}</td> <td class="p-3">{{ $att->employee->name }}</td>
            <td class="p-3">{{ $att->date }}</td>
            <td class="p-3">{{ $att->time_in }}</td>
            <td class="p-3">
                <span class="px-2 py-1 rounded {{ $att->status == 'Hadir' ? 'bg-green-200' : 'bg-red-200' }}">
                    {{ $att->status }}
                </span>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $attendances->links() }}
</div>
@endsection