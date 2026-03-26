<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SERAK - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Dashboard SERAK (Sistem Rekap Absensi)</h1>

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
                <p class="text-sm text-gray-500 uppercase font-bold">Tidak Hadir</p>
                <p class="text-3xl font-semibold text-red-600">{{ $absentToday }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 bg-gray-50 border-b">
                <h2 class="font-bold text-gray-700">Kehadiran Per Departemen</h2>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 italic text-sm">
                        <th class="p-3 border-b">Nama Departemen</th>
                        <th class="p-3 border-b">Total Staff</th>
                        <th class="p-3 border-b">Hadir</th>
                        <th class="p-3 border-b">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekapDivisi as $data)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border-b font-medium">{{ $data['nama'] }}</td>
                        <td class="p-3 border-b">{{ $data['total_staff'] }}</td>
                        <td class="p-3 border-b">{{ $data['hadir'] }}</td>
                        <td class="p-3 border-b">
                            <div class="flex items-center">
                                <span class="mr-2">{{ $data['persen'] }}%</span>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $data['persen'] }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>