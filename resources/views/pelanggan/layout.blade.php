<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan | @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex flex-col border-r flex-grow-0">
            <div class="h-20 flex items-center justify-center border-b">
                <span class="font-bold text-xl text-blue-600 tracking-wide flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17l6 6m0 0l6-6m-6 6V3" /></svg>
                    Pet Hotel
                </span>
            </div>
            <nav class="flex-1 py-6 px-4 space-y-1">
                <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg transition hover:bg-blue-50 @if(request()->routeIs('pelanggan.dashboard')) bg-blue-100 text-blue-700 font-semibold @else text-gray-700 @endif">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5 0a2 2 0 002-2V7a2 2 0 00-2-2h-3.5" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('pelanggan.profile') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg transition hover:bg-blue-50 @if(request()->routeIs('pelanggan.profile')) bg-blue-100 text-blue-700 font-semibold @else text-gray-700 @endif">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Profile
                </a>
                <a href="{{ route('pelanggan.hewan') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg transition hover:bg-blue-50 @if(request()->routeIs('pelanggan.hewan')) bg-blue-100 text-blue-700 font-semibold @else text-gray-700 @endif">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    Hewan
                </a>
                <a href="{{ route('pelanggan.booking') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg transition hover:bg-blue-50 @if(request()->routeIs('pelanggan.booking')) bg-blue-100 text-blue-700 font-semibold @else text-gray-700 @endif">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Booking
                </a>
                <a href="{{ route('pelanggan.transaksi') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg transition hover:bg-blue-50 @if(request()->routeIs('pelanggan.transaksi')) bg-blue-100 text-blue-700 font-semibold @else text-gray-700 @endif">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-5a2 2 0 00-2-2h-1.5M7 7h.01M7 7a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2H9a2 2 0 01-2-2V7z" /></svg>
                    Transaksi
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-8">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 py-2 px-3 rounded-lg transition hover:bg-red-50 text-red-600 font-semibold">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" /></svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="h-16 bg-white shadow flex items-center justify-between px-8 sticky top-0 z-10">
                <div class="text-lg font-semibold text-gray-700">@yield('title', 'Dashboard')</div>
                <div class="flex items-center space-x-4">
                    <span class="font-semibold text-gray-700">{{ session('pelanggan_nama') }}</span>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-500 text-sm">{{ session('pelanggan_email') }}</span>
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 font-bold">
                        {{ strtoupper(substr(session('pelanggan_nama'),0,1)) }}
                    </span>
                </div>
            </header>
            <main class="flex-1 p-6 md:p-10 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
