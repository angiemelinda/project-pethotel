<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
        }
        .sidebar-active { background: #f1f5f9; color: #6366f1; }
        .sidebar-icon { color: #6366f1; width: 28px !important; height: 28px !important; }
        .card { border-radius: 1.25rem; background: #fff; box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04); }
        .stat-gradient-1 { background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%); }
        .stat-gradient-2 { background: linear-gradient(135deg, #f0fdfa 0%, #fef9c3 100%); }
        .stat-gradient-3 { background: linear-gradient(135deg, #fef9c3 0%, #f3e8ff 100%); }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    @yield('content')
    <script>feather.replace();</script>
</body>
</html> 