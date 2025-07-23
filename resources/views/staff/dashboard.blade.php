@extends('staff.layout')
@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-green-50 border-r border-gray-100 flex flex-col justify-between py-6 px-4">
        <div>
            <div class="flex items-center gap-2 mb-10 px-2">
                <span class="text-2xl font-extrabold text-green-600">🐾 Pet Hotel</span>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold bg-green-100 text-green-700">
                    <i data-feather="home" class="sidebar-icon text-green-400"></i> Dashboard
                </a>
                <a href="{{ route('staff.hewan') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-green-50">
                    <i data-feather="github" class="sidebar-icon text-gray-400"></i> Hewan
                </a>
                <a href="{{ route('staff.transaksi') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-green-50">
                    <i data-feather="file-text" class="sidebar-icon text-gray-400"></i> Transaksi
                </a>
                <a href="{{ route('staff.statusLayanan') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-gray-700 hover:bg-green-50">
                    <i data-feather="clipboard" class="sidebar-icon text-gray-400"></i> Status Layanan
                </a>
                <a href="{{ route('staff.change_password') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-green-600 hover:bg-green-100 transition-all">
                    <i data-feather="lock" class="sidebar-icon text-green-400"></i> Ganti Password
                </a>
            </nav>
        </div>
        <div>
            <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-green-100 mt-10 mb-4">
                <i data-feather="user" class="text-green-400"></i>
                <div>
                    <div class="font-semibold text-gray-700 text-sm">{{ auth()->guard('staff')->user()->nama ?? 'Staff' }}</div>
                    <div class="text-xs text-gray-400">{{ auth()->guard('staff')->user()->email ?? 'staff@email.com' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-4 px-4 py-3 rounded-lg font-semibold text-red-600 hover:bg-red-50 w-full text-left">
                    <i data-feather="log-out" class="sidebar-icon text-red-400"></i> Logout
                </button>
            </form>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-8 bg-gray-50 min-h-screen">
        <!-- Notifikasi -->
        @if(isset($notifCheckout) && $notifCheckout > 0)
            <div class="mb-4 p-4 bg-orange-50 border-l-4 border-orange-400 text-orange-700 rounded">
                <strong>Notifikasi:</strong> Ada {{ $notifCheckout }} hewan yang harus check-out hari ini!
            </div>
        @endif
        @if(isset($notifBelumLunas) && $notifBelumLunas > 0)
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded">
                <strong>Perhatian:</strong> Ada {{ $notifBelumLunas }} transaksi yang belum lunas!
            </div>
        @endif
        <!-- Topbar -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">Dashboard Staff <span class="text-2xl">👋</span></h1>
                <div class="text-gray-500 text-sm mt-1">Selamat bertugas, semoga harimu produktif!</div>
            </div>
            <div class="flex items-center gap-6">
                <!-- Notifikasi dihapus -->
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center">
                        <i data-feather="user" class="text-green-500"></i>
                    </div>
                    <span class="font-semibold text-gray-700">{{ auth()->guard('staff')->user()->nama ?? 'Staff' }}</span>
                </div>
            </div>
        </div>
        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-green-100 rounded-lg p-6 flex items-center justify-between shadow-sm">
                <div>
                    <div class="text-sm text-gray-500 font-medium mb-1">Total Hewan</div>
                    <div class="text-2xl font-bold text-gray-800 flex items-center gap-2">{{ $statHewan ?? 0 }} <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-semibold">+2%</span></div>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center">
                    <i data-feather="github" class="w-7 h-7 text-green-400"></i>
                </div>
            </div>
            <div class="bg-white border border-green-100 rounded-lg p-6 flex items-center justify-between shadow-sm">
                <div>
                    <div class="text-sm text-gray-500 font-medium mb-1">Check-in Hari Ini</div>
                    <div class="text-2xl font-bold text-gray-800 flex items-center gap-2">{{ $statCheckin ?? 0 }} <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-semibold">+1%</span></div>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center">
                    <i data-feather="log-in" class="w-7 h-7 text-green-400"></i>
                </div>
            </div>
            <div class="bg-white border border-orange-100 rounded-lg p-6 flex items-center justify-between shadow-sm">
                <div>
                    <div class="text-sm text-gray-500 font-medium mb-1">Check-out Hari Ini</div>
                    <div class="text-2xl font-bold text-gray-800 flex items-center gap-2">{{ $statCheckout ?? 0 }} <span class="text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full font-semibold">-1%</span></div>
                </div>
                <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center">
                    <i data-feather="log-out" class="w-7 h-7 text-orange-400"></i>
                </div>
            </div>
        </div>
        <!-- Aktivitas Terbaru -->
        <div class="bg-white border border-green-100 rounded-lg p-8 mb-8 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">Aktivitas Terbaru <span class="text-xl">📋</span></h2>
            <ul class="space-y-3">
                <li class="flex items-center gap-3 text-gray-600"><span class="text-2xl">🐾</span> 2 hewan baru check-in hari ini</li>
                <li class="flex items-center gap-3 text-gray-600"><span class="text-2xl">✅</span> 1 hewan berhasil check-out</li>
                <li class="flex items-center gap-3 text-gray-600"><span class="text-2xl">💬</span> 3 pesan baru dari pelanggan</li>
            </ul>
        </div>
        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-12 flex items-center justify-center gap-1">© 2025 Pet Hotel <span class="text-lg">🐾</span> All rights reserved.</div>
    </main>
</div>
<script>feather.replace();</script>
@endsection 