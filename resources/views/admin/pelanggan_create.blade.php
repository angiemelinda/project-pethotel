<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan - Admin Pet Hotel</title>
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
            <li><a href="{{ route('admin.pelanggan') }}" class="text-indigo-600 border-b-2 border-indigo-600">Pelanggan</a></li>
            <li><a href="{{ route('admin.staff') }}" class="hover:text-indigo-500 transition">Staff</a></li>
            <li><a href="{{ route('admin.admin') }}" class="hover:text-indigo-500 transition">Admin</a></li>
            <li><a href="{{ route('admin.hewan') }}" class="hover:text-indigo-500 transition">Hewan</a></li>
            <li><a href="{{ route('admin.transaksi') }}" class="hover:text-indigo-500 transition">Transaksi</a></li>
            <li><a href="{{ route('admin.laporan') }}" class="hover:text-indigo-500 transition">Laporan</a></li>
        </ul>
    </nav>

    <div class="container mx-auto py-8 px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-4xl font-bold text-white mb-2 flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Pelanggan Baru
                    </h2>
                    <p class="text-indigo-100">Masukkan informasi pelanggan baru ke sistem</p>
                </div>
                <a href="{{ route('admin.pelanggan') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur text-white rounded-xl hover:bg-white/30 transition-all border border-white/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="glass rounded-2xl shadow-2xl p-8 max-w-2xl mx-auto">
            <form action="{{ route('admin.pelanggan.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="text-red-500">*</span> Nama Lengkap
                    </label>
                    <input type="text" name="nama" id="nama" 
                           value="{{ old('nama') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('nama') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap pelanggan">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="text-red-500">*</span> Email
                    </label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                           placeholder="contoh@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="text-red-500">*</span> Nomor Telepon
                    </label>
                    <input type="text" name="telepon" id="telepon" 
                           value="{{ old('telepon') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('telepon') border-red-500 @enderror"
                           placeholder="081234567890" pattern="[0-9]{10,12}" minlength="10" maxlength="12">
                    @error('telepon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Pelanggan
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-8 glass rounded-2xl p-6 max-w-2xl mx-auto">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-gray-900">Informasi</h3>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>• Semua field yang ditandai dengan <span class="text-red-500">*</span> wajib diisi</p>
                        <p>• Email harus unik dan valid</p>
                        <p>• Nomor telepon akan digunakan untuk kontak darurat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 