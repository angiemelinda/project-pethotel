<nav class="sticky top-0 z-30 bg-white/80 backdrop-blur shadow-lg flex items-center justify-between px-8 py-4">
    <a href="{{ route('staff.dashboard') }}" class="font-bold text-xl flex items-center gap-2 text-green-700">
        Pet Hotel Staff
    </a>
    <ul class="flex gap-6 text-base font-semibold">
        <li><a href="{{ route('staff.dashboard') }}" class="hover:text-green-500 transition">Dashboard</a></li>
        <li><a href="{{ route('staff.hewan') }}" class="hover:text-green-500 transition">Hewan</a></li>
        <li><a href="{{ route('staff.transaksi') }}" class="hover:text-green-500 transition">Transaksi</a></li>
        <li><a href="{{ route('staff.statusLayanan') }}" class="hover:text-green-500 transition">Status Layanan</a></li>
        <li><a href="{{ route('staff.change_password') }}" class="hover:text-green-500 transition">Ganti Password</a></li>
    </ul>
</nav> 