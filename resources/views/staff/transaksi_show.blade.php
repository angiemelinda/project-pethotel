@extends('staff.layout')
@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <rect width="20" height="14" x="2" y="5" rx="2" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 10h20" />
            </svg>
            Detail Transaksi
        </h1>
        <div class="mb-4">
            <div class="font-semibold">ID Transaksi:</div>
            <div class="text-gray-700">#{{ $transaksi->id }}</div>
        </div>
        <div class="mb-4">
            <div class="font-semibold">Pelanggan:</div>
            <div class="text-gray-700">{{ $transaksi->pelanggan->nama ?? '-' }}</div>
        </div>
        <div class="mb-4">
            <div class="font-semibold">Hewan:</div>
            <div class="text-gray-700">{{ $transaksi->hewan->nama ?? '-' }} ({{ $transaksi->hewan->jenis ?? '-' }})</div>
        </div>
        <div class="mb-4">
            <div class="font-semibold">Jenis Layanan:</div>
            @php
                $layananArray = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
                $layananArray = is_array($layananArray) ? $layananArray : [$transaksi->jenis_layanan];
                $statusDetail = is_string($transaksi->status_layanan_detail) ? json_decode($transaksi->status_layanan_detail, true) : ($transaksi->status_layanan_detail ?? []);
            @endphp
            <div class="text-gray-700">
                @foreach($layananArray as $layanan)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mb-1
                        @if(($statusDetail[$layanan] ?? '') == 'selesai') bg-green-100 text-green-800
                        @elseif(($statusDetail[$layanan] ?? '') == 'proses') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800
                        @endif
                    ">
                        {{ ucfirst($layanan) }}
                        @if(isset($statusDetail[$layanan]))
                            &ndash; {{ ucfirst($statusDetail[$layanan]) }}
                        @endif
                    </span>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <div class="font-semibold">Tanggal Masuk:</div>
            <div class="text-gray-700">{{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') }}</div>
        </div>
        <div class="mb-4">
            <div class="font-semibold">Tanggal Keluar:</div>
            <div class="text-gray-700">{{ $transaksi->tanggal_keluar ? \Carbon\Carbon::parse($transaksi->tanggal_keluar)->format('d/m/Y') : '-' }}</div>
        </div>
        <div class="mb-4">
            <div class="font-semibold">Total:</div>
            <div class="text-gray-700">Rp {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="mb-4">
            <div class="font-semibold">Status Pembayaran:</div>
            <div class="text-gray-700">{{ ucfirst($transaksi->status_pembayaran) }}</div>
        </div>
        <div class="flex gap-4 mt-6">
            <a href="{{ route('staff.transaksi.edit', $transaksi->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded shadow text-sm font-semibold flex items-center gap-1 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3z" /></svg>
                Edit
            </a>
            <a href="{{ route('staff.transaksi.cetak', $transaksi->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow text-sm font-semibold flex items-center gap-1 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Cetak Bukti
            </a>
            <a href="{{ route('staff.transaksi') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow text-sm font-semibold flex items-center gap-1 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection 