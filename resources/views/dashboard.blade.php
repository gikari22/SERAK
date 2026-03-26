<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERAK - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans antialiased flex h-screen overflow-hidden">

    <div class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-6 flex items-center justify-center border-b border-gray-700">
            <h1 class="text-2xl font-bold tracking-wider">SERAK<span class="text-blue-500">.</span></h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="/" class="flex items-center gap-3 bg-gray-900 text-white px-4 py-3 rounded-lg">
                <i class="fas fa-home w-5"></i> Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition">
                <i class="fas fa-building w-5"></i> Departemen
            </a>
            <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition">
                <i class="fas fa-users w-5"></i> Karyawan
            </a>
            <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition">
                <i class="fas fa-fingerprint w-5"></i> Rekap Absensi
            </a>
            <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition">
                <i class="fas fa-money-bill-wave w-5"></i> Penggajian
            </a>
        </nav>

        <div class="p-4 border-t border-gray-700 text-sm text-gray-400 text-center">
            &copy; 2024 Partner Coding
        </div>
    </div>

    <div class="flex-1 flex flex-col overflow-y-auto">
        
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Dashboard Overview</h2>
            <div class="flex items-center gap-3 text-gray-600">
                <i class="fas fa-user-circle text-2xl"></i>
                <span>Admin HRD</span>
            </div>
        </header>

        <main class="p-8">
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
        </main>
    </div>
</body>
</html>