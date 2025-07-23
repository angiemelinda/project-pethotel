<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Pet Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <li><a href="{{ route('admin.transaksi') }}" class="hover:text-indigo-500 transition">Transaksi</a></li>
            <li><a href="{{ route('admin.laporan') }}" class="text-indigo-600 border-b-2 border-indigo-600">Laporan</a></li>
        </ul>
    </nav>

    <div class="container mx-auto py-8 px-4">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Laporan
                </h1>
            </div>
            
            <!-- Export PDF Button Only -->
            <div class="flex gap-3 mt-4 md:mt-0">
                <a href="{{ route('admin.laporan.pdf', request()->query()) }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="glass rounded-2xl p-6 mb-8 shadow-xl">
            <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Laporan</label>
                    <select name="periode" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white/80 backdrop-blur-sm">
                        <option value="today" {{ request('periode') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="week" {{ request('periode') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="month" {{ request('periode') == 'month' || !request('periode') ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="quarter" {{ request('periode') == 'quarter' ? 'selected' : '' }}>Kuartal Ini</option>
                        <option value="year" {{ request('periode') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Layanan</label>
                    <select name="jenis_layanan" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white/80 backdrop-blur-sm">
                        <option value="" {{ !request('jenis_layanan') ? 'selected' : '' }}>Semua Layanan</option>
                        <option value="penitipan" {{ request('jenis_layanan') == 'penitipan' ? 'selected' : '' }}>Penitipan</option>
                        <option value="grooming" {{ request('jenis_layanan') == 'grooming' ? 'selected' : '' }}>Grooming</option>
                        <option value="vaksinasi" {{ request('jenis_layanan') == 'vaksinasi' ? 'selected' : '' }}>Vaksinasi</option>
                        <option value="checkup" {{ request('jenis_layanan') == 'checkup' ? 'selected' : '' }}>Check-up</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Pembayaran</label>
                    <select name="status_pembayaran" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white/80 backdrop-blur-sm">
                        <option value="" {{ !request('status_pembayaran') ? 'selected' : '' }}>Semua Status</option>
                        <option value="lunas" {{ request('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="dp" {{ request('status_pembayaran') == 'dp' ? 'selected' : '' }}>DP</option>
                        <option value="belum_lunas" {{ request('status_pembayaran') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200">
                        Generate Laporan
                    </button>
                </div>
            </form>
            
            <!-- Reset Filter -->
            @if(request('periode') || request('jenis_layanan') || request('status_pembayaran'))
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('admin.laporan') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
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
                        <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</p>
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
                        <p class="text-sm font-medium text-gray-600">Transaksi Bulan Ini</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $monthlyTransactions ?? 0 }}</p>
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
                        <p class="text-sm font-medium text-gray-600">Total Hewan</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $totalHewan ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <span class="text-2xl">🐾</span>
                    </div>
                </div>
            </div>
            
            <div class="glass rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pelanggan</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $totalPelanggan ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 10-8 0 4 4 0 008 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Revenue Chart -->
            <div class="glass rounded-2xl p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Pendapatan 6 Bulan Terakhir
                </h3>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>

            <!-- Service Distribution Chart -->
            <div class="glass rounded-2xl p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    Distribusi Layanan
                </h3>
                <canvas id="serviceChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Financial Report Section -->
        <div class="glass rounded-2xl p-6 shadow-xl">
            <h3 class="text-lg font-semibold text-red-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Laporan Keuangan per Layanan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Penitipan</span>
                        <span class="text-sm font-semibold text-green-600">Rp {{ number_format($serviceIncome['penitipan'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        {{ $serviceCount['penitipan'] ?? 0 }} transaksi
                    </div>
                </div>
                <div class="p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Grooming</span>
                        <span class="text-sm font-semibold text-blue-600">Rp {{ number_format($serviceIncome['grooming'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        {{ $serviceCount['grooming'] ?? 0 }} transaksi
                    </div>
                </div>
                <div class="p-4 bg-yellow-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Vaksinasi</span>
                        <span class="text-sm font-semibold text-yellow-600">Rp {{ number_format($serviceIncome['vaksinasi'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        {{ $serviceCount['vaksinasi'] ?? 0 }} transaksi
                    </div>
                </div>
                <div class="p-4 bg-purple-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Check-up</span>
                        <span class="text-sm font-semibold text-purple-600">Rp {{ number_format($serviceIncome['checkup'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        {{ $serviceCount['checkup'] ?? 0 }} transaksi
                    </div>
                </div>
            </div>
            <div class="border-t mt-4 pt-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-800">Total Pendapatan</span>
                    <span class="text-lg font-bold text-green-600">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['{{ now()->subMonths(5)->format("M Y") }}', '{{ now()->subMonths(4)->format("M Y") }}', '{{ now()->subMonths(3)->format("M Y") }}', '{{ now()->subMonths(2)->format("M Y") }}', '{{ now()->subMonths(1)->format("M Y") }}', '{{ now()->format("M Y") }}'],
                datasets: [{
                    label: 'Pendapatan (Rupiah)',
                    data: {!! json_encode($monthlyIncome ?? [0, 0, 0, 0, 0, 0]) !!},
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }
            }
        });

        // Service Distribution Chart
        const serviceCtx = document.getElementById('serviceChart').getContext('2d');
        new Chart(serviceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Penitipan', 'Grooming', 'Vaksinasi', 'Check-up'],
                datasets: [{
                    data: [
                        {{ $serviceDistribution['penitipan'] ?? 0 }},
                        {{ $serviceDistribution['grooming'] ?? 0 }},
                        {{ $serviceDistribution['vaksinasi'] ?? 0 }},
                        {{ $serviceDistribution['checkup'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 191, 36)',
                        'rgb(168, 85, 247)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html> 