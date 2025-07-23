@php
    use App\Models\JadwalLayanan;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Transaksi - Pet Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { backdrop-filter: blur(16px) saturate(180%); background: rgba(255, 255, 255, 0.75); border: 1px solid rgba(209, 213, 219, 0.3); }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Navigation -->
    <nav class="sticky top-0 z-30 bg-white/80 backdrop-blur shadow-lg flex items-center justify-between px-8 py-4">
        <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl flex items-center gap-2 text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v6m0 0h4m-4 0a2 2 0 01-2-2V7m6 11a2 2 0 002-2v-6m0 0l2 2m-2-2V7a2 2 0 00-2-2h-4a2 2 0 00-2 2v6" />
            </svg>
            Pet Hotel Admin
        </a>
        <ul class="flex gap-6 text-base font-semibold">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-500 transition">Dashboard</a></li>
            <li><a href="{{ route('admin.pelanggan') }}" class="hover:text-indigo-500 transition">Pelanggan</a></li>
            <li><a href="{{ route('admin.staff') }}" class="hover:text-indigo-500 transition">Staff</a></li>
            <li><a href="{{ route('admin.admin') }}" class="hover:text-indigo-500 transition">Admin</a></li>
            <li><a href="{{ route('admin.hewan') }}" class="hover:text-indigo-500 transition">Hewan</a></li>
            <li><a href="{{ route('admin.transaksi') }}" class="text-indigo-600 border-b-2 border-indigo-600">Transaksi</a></li>
            <li><a href="{{ route('admin.statusLayanan') }}" class="hover:text-indigo-500 transition">Status Layanan</a></li>
            <li><a href="{{ route('admin.laporan') }}" class="hover:text-indigo-500 transition">Laporan</a></li>
        </ul>
    </nav>

    <div class="container mx-auto py-8 px-4">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 10h20" />
                    </svg>
                    Manajemen Transaksi
                </h1>
            </div>
            <a href="{{ route('admin.transaksi.create') }}" 
               class="mt-4 md:mt-0 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold py-3 px-6 rounded-xl hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Transaksi
            </a>
        </div>

        <!-- Search and Filter Section -->
        <div class="glass rounded-2xl p-6 mb-8 shadow-xl">
            <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari transaksi..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white/80 backdrop-blur-sm">
                </div>
                
                <!-- Filter by Service Type -->
                <select name="jenis_layanan" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white/80 backdrop-blur-sm">
                    <option value="">Semua Layanan</option>
                    <option value="penitipan" {{ request('jenis_layanan') == 'penitipan' ? 'selected' : '' }}>Penitipan</option>
                    <option value="grooming" {{ request('jenis_layanan') == 'grooming' ? 'selected' : '' }}>Grooming</option>
                    <option value="vaksinasi" {{ request('jenis_layanan') == 'vaksinasi' ? 'selected' : '' }}>Vaksinasi</option>
                    <option value="checkup" {{ request('jenis_layanan') == 'checkup' ? 'selected' : '' }}>Check-up</option>
                </select>

                <!-- Filter by Payment Status -->
                <select name="status_pembayaran" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white/80 backdrop-blur-sm">
                    <option value="">Semua Status Pembayaran</option>
                    <option value="belum_lunas" {{ request('status_pembayaran') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="dp" {{ request('status_pembayaran') == 'dp' ? 'selected' : '' }}>DP</option>
                    <option value="lunas" {{ request('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
                
                <!-- Submit Button -->
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all">Filter</button>
            </form>
            
            <!-- Reset Filter -->
            @if(request('search') || request('jenis_layanan') || request('status_pembayaran'))
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('admin.transaksi') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset Filter
                    </a>
                </div>
            @endif
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="glass rounded-2xl p-6 shadow-xl">
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
            
            <div class="glass rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="glass rounded-2xl p-6 shadow-xl">
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
            
            <div class="glass rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Transaksi Lunas</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $transaksis->where('status_pembayaran', 'lunas')->count() ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="glass rounded-2xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">ID Transaksi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Hewan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Layanan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Status Layanan</th> <!-- Tambahan -->
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Pembayaran</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transaksis ?? [] as $index => $transaksi)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $transaksi->id }}</div>
                                <div class="text-sm text-gray-500">{{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-600 text-xs font-semibold">{{ substr($transaksi->pelanggan?->nama ?? 'N/A', 0, 2) }}</span>
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
                                        <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                            <span class="text-purple-600 text-xs">
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
                                    </span>
                                    @if(!$loop->last)<br>@endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $jadwals = JadwalLayanan::where('hewan_id', $transaksi->hewan_id)
                                        ->where('tanggal', $transaksi->tanggal_masuk)
                                        ->get();
                                @endphp
                                @foreach($jadwals as $jadwal)
                                    <div class="mb-1">
                                        <b>{{ $jadwal->layanan->nama ?? '-' }}</b>:
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                                            @if($jadwal->status == 'selesai') bg-green-100 text-green-800
                                            @elseif($jadwal->status == 'proses') bg-yellow-100 text-yellow-800
                                            @elseif($jadwal->status == 'dibatalkan') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                            {{ ucfirst($jadwal->status) }}
                                        </span>
                                    </div>
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
                                @else
                                    <div class="text-orange-600 text-xs font-medium">Tanggal keluar belum ditentukan</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="font-semibold text-green-600">Rp {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    @switch($transaksi->metode_pembayaran)
                                        @case('cash')
                                            💵 Cash
                                            @break
                                        @case('transfer')
                                            🏦 Transfer
                                            @break
                                        @case('qris')
                                            📱 QRIS
                                            @break
                                        @case('dana')
                                            💙 DANA
                                            @break
                                        @case('ovo')
                                            🟣 OVO
                                            @break
                                        @case('gopay')
                                            🟢 GoPay
                                            @break
                                        @default
                                            {{ ucfirst($transaksi->metode_pembayaran ?? 'N/A') }}
                                    @endswitch
                                </div>
                                <div class="text-xs">
                                    @if($transaksi->status_pembayaran == 'lunas')
                                        <span class="text-green-600 font-medium">✅ Lunas</span>
                                    @elseif($transaksi->status_pembayaran == 'dp')
                                        <span class="text-yellow-600 font-medium">💰 DP</span>
                                        <div class="text-gray-500">Rp {{ number_format($transaksi->jumlah_dibayar, 0, ',', '.') }}</div>
                                    @else
                                        <span class="text-red-600 font-medium">❌ Belum Lunas</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.transaksi.edit', $transaksi->id) }}" 
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg shadow text-xs flex items-center gap-1 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
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
                            <td colspan="10" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect width="20" height="14" x="2" y="5" rx="2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 10h20" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data transaksi</h3>
                                    <p class="text-gray-500 mb-4">Mulai dengan menambahkan transaksi pertama</p>
                                    <a href="{{ route('admin.transaksi.create') }}" 
                                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                        Tambah Transaksi Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(isset($transaksis) && method_exists($transaksis, 'hasPages') && $transaksis->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="glass rounded-xl p-4">
                {{ $transaksis->links() }}
            </div>
        </div>
        @endif
    </div>
</body>
</html> 