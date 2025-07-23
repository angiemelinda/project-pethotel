<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Hewan (Admin) - Pet Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-indigo-700 flex items-center gap-2"><span>Tambah Hewan</span> <span>🐾</span></h1>
        <form action="{{ route('admin.hewan.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-1">Nama Hewan</label>
                <input type="text" name="nama" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Jenis</label>
                <select name="jenis" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required>
                    <option value="">Pilih Jenis</option>
                    <option value="kucing">Kucing</option>
                    <option value="anjing">Anjing</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Ras</label>
                <input type="text" name="ras" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Usia (tahun)</label>
                <input type="number" name="usia" min="0" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Status Vaksin</label>
                <select name="status_vaksin" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required>
                    <option value="">Pilih Status Vaksin</option>
                    <option value="vaccinated">Sudah</option>
                    <option value="not_vaccinated">Belum</option>
                    <option value="partial">Sebagian</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Pelanggan</label>
                <select name="pelanggan_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required>
                    <option value="">Pilih Pelanggan</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }} ({{ $pelanggan->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="pt-2 flex gap-2">
                <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Simpan
                </button>
                <a href="{{ route('admin.hewan') }}" class="w-full py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg shadow hover:bg-gray-300 transition flex items-center justify-center gap-2">Batal</a>
            </div>
        </form>
    </div>
</body>
</html> 