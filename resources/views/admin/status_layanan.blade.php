@php
    use App\Models\JadwalLayanan;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Layanan - Pet Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { backdrop-filter: blur(16px) saturate(180%); background: rgba(255, 255, 255, 0.75); border: 1px solid rgba(209, 213, 219, 0.3); }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="gradient-bg min-h-screen">
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
            <li><a href="{{ route('admin.statusLayanan') }}" class="text-indigo-600 border-b-2 border-indigo-600">Status Layanan</a></li>
            <li><a href="{{ route('admin.laporan') }}" class="hover:text-indigo-500 transition">Laporan</a></li>
        </ul>
    </nav>
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6 text-indigo-700 flex items-center gap-2">
            <span>Status Semua Layanan</span>
        </h1>
        <a href="{{ route('admin.dashboard') }}" class="inline-block mb-4 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow text-sm font-semibold flex items-center gap-1 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke Dashboard
        </a>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <table class="min-w-full table-auto rounded-xl overflow-hidden shadow">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-base">
                        <th class="px-4 py-3 font-semibold text-left">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-left">Hewan</th>
                        <th class="px-4 py-3 font-semibold text-left">Layanan</th>
                        <th class="px-4 py-3 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $data = JadwalLayanan::with(['hewan','layanan'])->orderBy('tanggal','desc')->get(); @endphp
                    @forelse($data as $jadwal)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="border-t px-4 py-3 text-gray-800 text-left">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}</td>
                        <td class="border-t px-4 py-3 text-gray-700 text-left flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                {{ strtoupper(substr($jadwal->hewan->nama ?? '-', 0, 2)) }}
                            </div>
                            <span>{{ $jadwal->hewan->nama ?? '-' }}</span>
                        </td>
                        <td class="border-t px-4 py-3 text-gray-700 text-left">{{ $jadwal->layanan->nama ?? '-' }}</td>
                        <td class="border-t px-4 py-3 text-center">
                            <form action="{{ route('admin.jadwal.updateStatus', $jadwal->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="rounded border-gray-300 text-xs px-2 py-1 bg-gray-50">
                                    <option value="menunggu" {{ $jadwal->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="proses" {{ $jadwal->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="selesai" {{ $jadwal->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ $jadwal->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                <span class="inline-block ml-2 px-2 py-1 rounded-full text-xs font-semibold
                                    {{
                                        $jadwal->status == 'selesai' ? 'bg-green-100 text-green-700' :
                                        ($jadwal->status == 'proses' ? 'bg-yellow-100 text-yellow-700' :
                                        ($jadwal->status == 'dibatalkan' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700'))
                                    }}">
                                    {{ ucfirst($jadwal->status) }}
                                </span>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-400 py-8">Belum ada data layanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 