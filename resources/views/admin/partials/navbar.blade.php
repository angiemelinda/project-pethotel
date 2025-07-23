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
<script>feather.replace();</script> 