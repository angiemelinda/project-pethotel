@extends('staff.layout')
@section('content')
<div class="min-h-screen bg-white py-8 px-4">
    <!-- Tombol Kembali ke Dashboard -->
    <a href="{{ route('staff.dashboard') }}" class="inline-flex items-center mb-6 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg shadow-sm transition gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Kembali ke Dashboard
    </a>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2 flex items-center gap-3">
                <span class="text-4xl">🐾</span>
                Manajemen Hewan
            </h1>
        </div>
        <a href="{{ route('staff.hewan.create') }}" 
           class="mt-4 md:mt-0 bg-gradient-to-r from-green-400 to-emerald-500 text-white font-semibold py-3 px-6 rounded-xl hover:from-green-500 hover:to-emerald-600 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Hewan
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white/80 backdrop-blur rounded-2xl p-6 mb-8 shadow-xl border border-green-100">
        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari hewan..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-transparent bg-white/80">
            </div>
            <!-- Filter by Type -->
            <select name="jenis" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-transparent bg-white/80">
                <option value="">Semua Jenis</option>
                <option value="kucing" {{ request('jenis') == 'kucing' ? 'selected' : '' }}>Kucing</option>
                <option value="anjing" {{ request('jenis') == 'anjing' ? 'selected' : '' }}>Anjing</option>
            </select>
            <!-- Filter by Vaccination Status -->
            <select name="status_vaksin" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-transparent bg-white/80">
                <option value="">Status Vaksinasi</option>
                <option value="vaccinated" {{ request('status_vaksin') == 'vaccinated' ? 'selected' : '' }}>Sudah Vaksin</option>
                <option value="not_vaccinated" {{ request('status_vaksin') == 'not_vaccinated' ? 'selected' : '' }}>Belum Vaksin</option>
                <option value="partial" {{ request('status_vaksin') == 'partial' ? 'selected' : '' }}>Vaksin Sebagian</option>
            </select>
            <!-- Tombol submit -->
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-xl transition-all">Filter</button>
        </form>
        <!-- Reset Filter -->
        @if(request('search') || request('jenis') || request('status_vaksin'))
            <div class="mt-4 flex justify-end">
                <a href="{{ route('staff.hewan') }}" class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset Filter
                </a>
            </div>
        @endif
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Hewan</p>
                    <p class="text-2xl font-bold text-green-600">{{ $hewans->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <span class="text-2xl">🐾</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Kucing</p>
                    <p class="text-2xl font-bold text-orange-500">{{ $hewans->where('jenis', 'kucing')->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <span class="text-2xl">🐱</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Anjing</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $hewans->where('jenis', 'anjing')->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <span class="text-2xl">🐕</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sudah Vaksin</p>
                    <p class="text-2xl font-bold text-green-600">{{ $hewans->where('status_vaksin', 'vaccinated')->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-green-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Nama Hewan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Ras</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Usia</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Pemilik</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Status Vaksin</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($hewans ?? [] as $index => $hewan)
                    <tr class="hover:bg-green-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-green-600 text-lg">
                                            @if($hewan->jenis == 'kucing') 🐱
                                            @elseif($hewan->jenis == 'anjing') 🐕
                                            @else 🐾
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $hewan->nama }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $hewan->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($hewan->jenis) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $hewan->ras ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $hewan->usia ?? '-' }} tahun
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-green-600 text-xs font-semibold">{{ substr($hewan->pelanggan?->nama ?? 'N/A', 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900">{{ $hewan->pelanggan?->nama ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($hewan->status_vaksin == 'vaccinated')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Sudah Vaksin
                                </span>
                            @elseif($hewan->status_vaksin == 'partial')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    Sebagian
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Belum Vaksin
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="{{ route('staff.hewan.edit', $hewan->id) }}" 
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg shadow text-xs flex items-center gap-1 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('staff.hewan.destroy', $hewan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hewan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow text-xs flex items-center gap-1 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-400 py-8">Tidak ada data hewan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 