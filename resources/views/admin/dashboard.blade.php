<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pet Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-active { background: #f1f5f9; color: #6366f1; }
        .sidebar-icon { color: #6366f1; width: 28px !important; height: 28px !important; }
        .card { border-radius: 1.25rem; background: #fff; box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04); }
        .stat-gradient-1 { background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%); }
        .stat-gradient-2 { background: linear-gradient(135deg, #f0fdfa 0%, #fef9c3 100%); }
        .stat-gradient-3 { background: linear-gradient(135deg, #fef9c3 0%, #f3e8ff 100%); }
        .stat-gradient-4 { background: linear-gradient(135deg, #f3e8ff 0%, #e0e7ff 100%); }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between py-6 px-4">
        <div>
            <div class="flex items-center gap-2 mb-10 px-2">
                <span class="text-2xl font-extrabold text-indigo-600">🐾 Pet Hotel</span>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold sidebar-active">
                    <i data-feather="home" class="sidebar-icon"></i> Dashboard
                </a>
                <a href="{{ route('admin.pelanggan') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                    <i data-feather="users" class="sidebar-icon text-gray-400"></i> Pelanggan
                </a>
                <a href="{{ route('admin.hewan') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                    <i data-feather="github" class="sidebar-icon text-gray-400"></i> Hewan
                </a>
                <a href="{{ route('admin.transaksi') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                    <i data-feather="file-text" class="sidebar-icon text-gray-400"></i> Transaksi
                </a>
                <a href="{{ route('admin.statusLayanan') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                    <i data-feather="clipboard" class="sidebar-icon text-gray-400"></i> Status Layanan
                </a>
                <a href="{{ route('admin.staff') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                    <i data-feather="user-check" class="sidebar-icon text-gray-400"></i> Staff
                </a>
                <a href="{{ route('admin.admin') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                    <i data-feather="user-check" class="sidebar-icon text-gray-400"></i> Admin
                </a>
                <a href="{{ route('admin.laporan') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                    <i data-feather="bar-chart-2" class="sidebar-icon text-gray-400"></i> Laporan
                </a>
                <a href="{{ route('admin.change_password') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded shadow transition-all mt-4">Ganti Password</a>
            </nav>
        </div>
        <div class="flex flex-col items-start gap-2 px-4 py-3 rounded-lg bg-gray-50 mt-10">
            <div class="flex items-center gap-3">
                <i data-feather="user" class="text-indigo-400"></i>
                <div>
                    <div class="font-semibold text-gray-700 text-sm">
                        {{ optional(\App\Models\Admin::find(session('admin_id')))->nama ?? 'Admin' }}
                    </div>
                    <div class="text-xs text-gray-400">
                        {{ optional(\App\Models\Admin::find(session('admin_id')))->email ?? '-' }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="w-full mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 justify-center py-2 px-3 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg text-xs font-semibold transition">
                    <i data-feather="log-out" class="w-4 h-4"></i> Logout
                </button>
            </form>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-8">
        <!-- Topbar -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">Dashboard Admin <span class="text-2xl">👋</span></h1>
                <div class="text-gray-500 text-sm mt-1">Selamat datang kembali, semoga harimu menyenangkan!</div>
            </div>
            <div class="flex items-center gap-6">
                <!-- Hapus notifikasi bell -->
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i data-feather="user" class="text-indigo-500"></i>
                    </div>
                    <span class="font-semibold text-gray-700">Admin</span>
                </div>
            </div>
        </div>
        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="card stat-gradient-1 p-6 flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 font-medium mb-1">Total Pelanggan</div>
                    <div class="text-2xl font-bold text-gray-800 flex items-center gap-2">{{ $statPelanggan ?? 0 }} <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-semibold">+5%</span></div>
                </div>
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center">
                    <i data-feather="users" class="w-7 h-7 text-indigo-400"></i>
                </div>
            </div>
            <div class="card stat-gradient-2 p-6 flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 font-medium mb-1">Total Hewan</div>
                    <div class="text-2xl font-bold text-gray-800 flex items-center gap-2">{{ $statHewan ?? 0 }} <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-semibold">+3%</span></div>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i data-feather="github" class="w-7 h-7 text-green-400"></i>
                </div>
            </div>
            <div class="card stat-gradient-3 p-6 flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 font-medium mb-1">Total Transaksi</div>
                    <div class="text-2xl font-bold text-gray-800 flex items-center gap-2">{{ $statTransaksi ?? 0 }} <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-semibold">-2%</span></div>
                </div>
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i data-feather="file-text" class="w-7 h-7 text-yellow-400"></i>
                </div>
            </div>
            <div class="card stat-gradient-4 p-6 flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 font-medium mb-1">Total Staff</div>
                    <div class="text-2xl font-bold text-gray-800 flex items-center gap-2">{{ $statStaff ?? 0 }} <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-semibold">+1%</span></div>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <i data-feather="user-check" class="w-7 h-7 text-purple-400"></i>
                </div>
            </div>
        </div>
        <!-- Aktivitas Terbaru -->
        <div class="card p-8 mb-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">Aktivitas Terbaru <span class="text-xl">📈</span></h2>
            <ul class="space-y-3">
                <li class="flex items-center gap-3 text-gray-600"><span class="text-2xl">🟢</span> {{ $pelangganBaru }} pelanggan baru mendaftar hari ini</li>
                <li class="flex items-center gap-3 text-gray-600"><span class="text-2xl">🐶</span> {{ $hewanBaru }} hewan baru ditambahkan</li>
                <li class="flex items-center gap-3 text-gray-600"><span class="text-2xl">💳</span> {{ $transaksiBaru }} transaksi berhasil diproses</li>
                <li class="flex items-center gap-3 text-gray-600"><span class="text-2xl">🧑‍💼</span> {{ $staffBaru }} staff baru bergabung</li>
            </ul>
        </div>
        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-12 flex items-center justify-center gap-1">© 2025 Pet Hotel <span class="text-lg">🐾</span> All rights reserved.</div>
    </main>
</div>
<script>feather.replace();</script>
</body>
</html> 