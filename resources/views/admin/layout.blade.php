<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-200 via-sky-100 to-white min-h-screen">
    {{-- Navbar atau sidebar admin bisa diletakkan di sini --}}
    <div class="container mx-auto py-8 px-4">
        @yield('content')
    </div>
</body>
</html> 