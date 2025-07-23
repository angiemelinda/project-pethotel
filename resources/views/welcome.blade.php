<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col relative overflow-hidden">
    <div class="flex flex-col items-center justify-center flex-1 min-h-screen px-4">
        <div class="w-full max-w-2xl bg-white/90 rounded-3xl shadow-2xl border border-blue-100 p-8 md:p-12 flex flex-col items-center relative overflow-hidden z-10 backdrop-blur-sm">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-gradient-to-br from-blue-100 via-blue-50 to-yellow-50 rounded-full opacity-60 z-0"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-gradient-to-tr from-yellow-100 via-white to-blue-50 rounded-full opacity-50 z-0"></div>
            <div class="relative z-10 flex flex-col items-center">
                <span class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 mb-4 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17l6 6m0 0l6-6m-6 6V3" /></svg>
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-4 text-center drop-shadow">Pet Hotel</h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-xl text-center">Berikan hewan peliharaan Anda liburan terbaik saat Anda pergi.<br>Hotel hewan premium kami menawarkan kenyamanan, perawatan, dan kesenangan untuk teman setia Anda.</p>
                <div class="flex gap-4 flex-wrap justify-center">
                    <a href="{{ route('login') }}" class="px-10 py-3 bg-blue-500 text-white text-lg font-bold rounded-full shadow-lg hover:bg-blue-600 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300">Masuk</a>
                    <a href="{{ route('register') }}" class="px-10 py-3 bg-yellow-400 text-white text-lg font-bold rounded-full shadow-lg hover:bg-yellow-500 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-200">Daftar</a>
                </div>
            </div>
        </div>
        <div class="mt-10 text-gray-400 text-sm text-center">&copy; {{ date('Y') }} Pet Hotel. All rights reserved.</div>
    </div>
</body>
</html>
