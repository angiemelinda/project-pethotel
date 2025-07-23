<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Staff - Pet Hotel</title>
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
            <li><a href="{{ route('admin.staff') }}" class="text-indigo-600 border-b-2 border-indigo-600">Staff</a></li>
            <li><a href="{{ route('admin.admin') }}" class="hover:text-indigo-500 transition">Admin</a></li>
            <li><a href="{{ route('admin.hewan') }}" class="hover:text-indigo-500 transition">Hewan</a></li>
            <li><a href="{{ route('admin.transaksi') }}" class="hover:text-indigo-500 transition">Transaksi</a></li>
            <li><a href="{{ route('admin.statusLayanan') }}" class="hover:text-indigo-500 transition">Status Layanan</a></li>
            <li><a href="{{ route('admin.laporan') }}" class="hover:text-indigo-500 transition">Laporan</a></li>
        </ul>
    </nav>
    <div class="container mx-auto py-10 px-4">
        <h2 class="text-3xl font-bold text-green-800 mb-8 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a4 4 0 01-8 0 4 4 0 018 0zm6 8v-1a4 4 0 00-3-3.87" /></svg>
            Data Staff
        </h2>
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.staff.create') }}" class="inline-flex items-center px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Staff
            </a>
        </div>
        <div class="overflow-x-auto rounded-2xl glass">
            <table class="min-w-full divide-y divide-green-200">
                <thead class="bg-green-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">ID Staff</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-green-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-green-100">
                    @forelse($staff as $i => $s)
                    <tr class="hover:bg-green-50 transition">
                        <td class="px-6 py-4">{{ $s->id }}</td>
                        <td class="px-6 py-4 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-sm">
                                {{ strtoupper(substr($s->nama, 0, 2)) }}
                            </div>
                            <span>{{ $s->nama }}</span>
                        </td>
                        <td class="px-6 py-4">{{ $s->email }}</td>
                        <td class="px-6 py-4">{{ $s->telepon }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                {{
                                    $s->jabatan == 'Groomer' ? 'bg-blue-100 text-blue-700' :
                                    ($s->jabatan == 'Pet Sitter' ? 'bg-yellow-100 text-yellow-700' :
                                    ($s->jabatan == 'Veterinarian' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700'))
                                }}">
                                {{ $s->jabatan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.staff.edit', $s->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow text-xs flex items-center gap-1 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3z" /></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.staff.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus staff ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-xs flex items-center gap-1 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-400">Belum ada data staff.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 