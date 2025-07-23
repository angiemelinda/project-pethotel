@extends('pelanggan.layout')
@section('title', 'Dashboard')
@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2 mb-1">
        Halo, {{ session('pelanggan_nama', 'Pelanggan') }}! <span class="text-xl">👋</span>
    </h1>
    <div class="text-blue-500 text-base">
        Selamat datang di <span class="font-semibold">Pet Hotel</span>, tempat terbaik untuk hewan kesayangan Anda!
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Card Hewan -->
    <div class="rounded-xl shadow p-5 bg-gradient-to-br from-blue-50 via-white to-blue-100 flex flex-col items-center group transition hover:scale-105 hover:shadow-xl duration-200">
        <div class="bg-blue-500 text-white rounded-full p-3 mb-2 shadow flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 17l6 6m0 0l6-6m-6 6V3" />
            </svg>
        </div>
        <div class="text-2xl font-extrabold mb-0.5 text-blue-700">{{ $totalHewan }}</div>
        <div class="text-gray-600 font-medium text-base">Hewan Peliharaan</div>
    </div>
    <!-- Card Booking -->
    <div class="rounded-xl shadow p-5 bg-gradient-to-br from-green-50 via-white to-green-100 flex flex-col items-center group transition hover:scale-105 hover:shadow-xl duration-200">
        <div class="bg-green-500 text-white rounded-full p-3 mb-2 shadow flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect width="18" height="14" x="3" y="5" rx="2" />
                <path d="M16 3v4M8 3v4M3 9h18" />
            </svg>
        </div>
        <div class="text-2xl font-extrabold mb-0.5 text-green-700">{{ $totalBookingAktif }}</div>
        <div class="text-gray-600 font-medium text-base">Booking Aktif</div>
    </div>
    <!-- Card Transaksi -->
    <div class="rounded-xl shadow p-5 bg-gradient-to-br from-yellow-50 via-white to-yellow-100 flex flex-col items-center group transition hover:scale-105 hover:shadow-xl duration-200">
        <div class="bg-yellow-400 text-white rounded-full p-3 mb-2 shadow flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect width="18" height="14" x="3" y="5" rx="2" />
                <path d="M8 11h8M8 15h6" />
            </svg>
        </div>
        <div class="text-2xl font-extrabold mb-0.5 text-yellow-600">{{ $totalTransaksi }}</div>
        <div class="text-gray-600 font-medium text-base">Transaksi</div>
    </div>
</div>
@endsection 