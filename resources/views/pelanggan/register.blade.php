<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pelanggan - Pet Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-200 via-sky-100 to-white min-h-screen flex flex-col justify-center items-center">
    <div class="w-full max-w-md bg-white/80 rounded-2xl shadow-xl p-8 mt-10">
        <h2 class="text-3xl font-bold text-indigo-700 mb-2 text-center">Register Pelanggan</h2>
        <p class="text-gray-500 text-center mb-6">Buat akun untuk penitipan hewan peliharaan Anda</p>
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="nama" class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 bg-white/80" placeholder="Nama lengkap">
            </div>
            <div>
                <label for="email" class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 bg-white/80" placeholder="Email aktif">
            </div>
            <div>
                <label for="telepon" class="block text-sm font-semibold mb-1">No. Telepon</label>
                <input type="text" id="telepon" name="telepon" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 bg-white/80" placeholder="08xxxxxxxxxx">
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold mb-1">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 bg-white/80" placeholder="Password minimal 6 karakter">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold mb-1">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 bg-white/80" placeholder="Ulangi password">
            </div>
            <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow hover:bg-indigo-700 transition">Daftar</button>
        </form>
        <div class="text-center mt-6">
            <span class="text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 ml-1">Masuk di sini</a>
        </div>
    </div>
</body>
</html> 