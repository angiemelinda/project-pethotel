@extends('staff.layout')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg p-8 mt-8 print:p-0 print:shadow-none print:bg-white">
    <h2 class="text-2xl font-bold text-center mb-6">Bukti Transaksi Penitipan</h2>
    <div class="mb-4 flex justify-between">
        <span class="font-semibold">ID Transaksi:</span>
        <span>#{{ $transaksi->id }}</span>
    </div>
    <div class="mb-4 flex justify-between">
        <span class="font-semibold">Nama Pelanggan:</span>
        <span>{{ $transaksi->pelanggan->nama ?? '-' }}</span>
    </div>
    <div class="mb-4 flex justify-between">
        <span class="font-semibold">Nama Hewan:</span>
        <span>{{ $transaksi->hewan->nama ?? '-' }} ({{ $transaksi->hewan->jenis ?? '-' }})</span>
    </div>
    <div class="mb-4 flex justify-between">
        <span class="font-semibold">Jenis Layanan:</span>
        @php
            $layananArray = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
            $layananArray = is_array($layananArray) ? $layananArray : [$transaksi->jenis_layanan];
            $statusDetail = is_string($transaksi->status_layanan_detail) ? json_decode($transaksi->status_layanan_detail, true) : ($transaksi->status_layanan_detail ?? []);
        @endphp
        <span>
            @foreach($layananArray as $layanan)
                {{ ucfirst($layanan) }}
                @if(isset($statusDetail[$layanan]))
                    – {{ ucfirst($statusDetail[$layanan]) }}
                @endif
                @if(!$loop->last), @endif
            @endforeach
        </span>
    </div>
    <div class="mb-4 flex justify-between">
        <span class="font-semibold">Tanggal Masuk:</span>
        <span>{{ $transaksi->tanggal_masuk }}</span>
    </div>
    <div class="mb-4 flex justify-between">
        <span class="font-semibold">Tanggal Keluar:</span>
        <span>{{ $transaksi->tanggal_keluar ?? '-' }}</span>
    </div>
    <div class="mb-4 flex justify-between">
        <span class="font-semibold">Total:</span>
        <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
    </div>
    <div class="mb-4 flex justify-between">
        <span class="font-semibold">Status Pembayaran:</span>
        <span>{{ ucfirst($transaksi->status_pembayaran) }}</span>
    </div>
    <div class="mt-8 text-center">
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow font-semibold print:hidden">Cetak</button>
    </div>
</div>
@endsection 