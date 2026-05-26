<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERAK - HRIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased flex h-screen overflow-hidden">

    <div class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-6 flex items-center justify-center border-b border-gray-700">
            <h1 class="text-2xl font-bold tracking-wider">SERAK<span class="text-blue-500">.</span></h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="/" class="flex items-center gap-3 hover:bg-gray-900 text-white px-4 py-3 rounded-lg transition {{ request()->is('/') ? 'bg-gray-900' : 'text-gray-400' }}">
                <i class="fas fa-home w-5"></i> Dashboard
            </a>
            <a href="{{ route('departments.index') }}" class="flex items-center gap-3 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition {{ request()->routeIs('departments.*') ? 'bg-gray-700 text-white' : 'text-gray-400' }}">
                <i class="fas fa-building w-5"></i> Departemen
            </a>
            <a href="{{ route('employees.index') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition">
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
            <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
            <div class="flex items-center gap-3 text-gray-600">
                <i class="fas fa-user-circle text-2xl"></i>
                <span>Admin HRD</span>
            </div>
        </header>

        <main class="p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>