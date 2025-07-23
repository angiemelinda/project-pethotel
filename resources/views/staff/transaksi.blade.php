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
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect width="20" height="14" x="2" y="5" rx="2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 10h20" />
                </svg>
                Manajemen Transaksi
            </h1>
        </div>
        <a href="{{ route('staff.transaksi.create') }}" 
           class="mt-4 md:mt-0 bg-gradient-to-r from-green-400 to-emerald-500 text-white font-semibold py-3 px-6 rounded-xl hover:from-green-500 hover:to-emerald-600 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Transaksi
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
                       placeholder="Cari transaksi..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-transparent bg-white/80">
            </div>
            <!-- Filter by Service Type -->
            <select name="jenis_layanan" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-transparent bg-white/80">
                <option value="">Semua Layanan</option>
                <option value="penitipan" {{ request('jenis_layanan') == 'penitipan' ? 'selected' : '' }}>Penitipan</option>
                <option value="grooming" {{ request('jenis_layanan') == 'grooming' ? 'selected' : '' }}>Grooming</option>
                <option value="vaksinasi" {{ request('jenis_layanan') == 'vaksinasi' ? 'selected' : '' }}>Vaksinasi</option>
                <option value="checkup" {{ request('jenis_layanan') == 'checkup' ? 'selected' : '' }}>Check-up</option>
            </select>
            <!-- Filter by Payment Status -->
            <select name="status_pembayaran" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-400 focus:border-transparent bg-white/80">
                <option value="">Semua Status Pembayaran</option>
                <option value="belum_lunas" {{ request('status_pembayaran') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="dp" {{ request('status_pembayaran') == 'dp' ? 'selected' : '' }}>DP</option>
                <option value="lunas" {{ request('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
            <!-- Submit Button -->
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-xl transition-all">Filter</button>
        </form>
        <!-- Reset Filter -->
        @if(request('search') || request('jenis_layanan') || request('status_pembayaran'))
            <div class="mt-4 flex justify-end">
                <a href="{{ route('staff.transaksi') }}" class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center gap-1">
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
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $transaksis->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 10h20" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Transaksi Belum Lunas</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $transaksis->where('status_pembayaran', 'belum_lunas')->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Transaksi Lunas</p>
                    <p class="text-2xl font-bold text-green-600">{{ $transaksis->where('status_pembayaran', 'lunas')->count() ?? 0 }}</p>
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
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Hewan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Pembayaran</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($transaksis ?? [] as $index => $transaksi)
                    <tr class="hover:bg-green-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">#{{ $transaksi->id }}</div>
                            <div class="text-sm text-gray-500">{{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-green-600 text-xs font-semibold">{{ substr($transaksi->pelanggan?->nama ?? 'N/A', 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaksi->pelanggan?->nama ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $transaksi->pelanggan?->telepon ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-green-600 text-xs">
                                            @if($transaksi->hewan?->jenis == 'kucing') 🐱
                                            @elseif($transaksi->hewan?->jenis == 'anjing') 🐕
                                            @elseif($transaksi->hewan?->jenis == 'burung') 🐦
                                            @elseif($transaksi->hewan?->jenis == 'kelinci') 🐰
                                            @elseif($transaksi->hewan?->jenis == 'hamster') 🐹
                                            @else 🐾
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaksi->hewan?->nama ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ ucfirst($transaksi->hewan?->jenis ?? 'N/A') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $layananArray = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
                                $layananArray = is_array($layananArray) ? $layananArray : [$transaksi->jenis_layanan];
                                $statusDetail = is_string($transaksi->status_layanan_detail) ? json_decode($transaksi->status_layanan_detail, true) : ($transaksi->status_layanan_detail ?? []);
                            @endphp
                            @foreach($layananArray as $layanan)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mb-1
                                    @if($layanan == 'penitipan') bg-blue-100 text-blue-800
                                    @elseif($layanan == 'grooming') bg-green-100 text-green-800
                                    @elseif($layanan == 'vaksinasi') bg-yellow-100 text-yellow-800
                                    @elseif($layanan == 'checkup') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($layanan) }}
                                    @if(isset($statusDetail[$layanan]))
                                        <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold
                                            @if($statusDetail[$layanan]=='selesai') bg-green-200 text-green-800
                                            @elseif($statusDetail[$layanan]=='proses') bg-yellow-200 text-yellow-800
                                            @else bg-gray-200 text-gray-700
                                            @endif">
                                            {{ ucfirst($statusDetail[$layanan]) }}
                                        </span>
                                    @endif
                                </span>
                                @if(!$loop->last)<br>@endif
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">{{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') }}</div>
                            @if($transaksi->tanggal_keluar && $transaksi->tanggal_keluar != $transaksi->tanggal_masuk)
                                <div class="text-gray-500 text-xs">s/d {{ \Carbon\Carbon::parse($transaksi->tanggal_keluar)->format('d/m/Y') }}</div>
                                @php
                                    $durasi = \Carbon\Carbon::parse($transaksi->tanggal_masuk)->diffInDays(\Carbon\Carbon::parse($transaksi->tanggal_keluar)) + 1;
                                @endphp
                                <div class="text-blue-600 text-xs font-medium">{{ $durasi }} hari</div>
                            @elseif($transaksi->tanggal_keluar == $transaksi->tanggal_masuk)
                                <div class="text-green-600 text-xs font-medium">Satu hari</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaksi->status_pembayaran == 'lunas')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Lunas</span>
                            @elseif($transaksi->status_pembayaran == 'belum_lunas')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Belum Lunas</span>
                            @elseif($transaksi->status_pembayaran == 'dp')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">DP</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($transaksi->status_pembayaran) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="{{ route('staff.transaksi.show', $transaksi->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg shadow text-xs flex items-center gap-1 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h.01M12 12h.01M9 12h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z" />
                                    </svg>
                                    Detail
                                </a>
                                <a href="{{ route('staff.transaksi.edit', $transaksi->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg shadow text-xs flex items-center gap-1 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('staff.transaksi.destroy', $transaksi->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow text-xs flex items-center gap-1 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-gray-400 py-8">Tidak ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
