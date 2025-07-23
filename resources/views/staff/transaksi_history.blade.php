@extends('staff.layout')
@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <rect width="20" height="14" x="2" y="5" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 10h20" />
        </svg>
        Riwayat Transaksi
    </h1>
    <div class="glass rounded-2xl shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Hewan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transaksis ?? [] as $index => $transaksi)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">#{{ $transaksi->id }}</div>
                            <div class="text-sm text-gray-500">{{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 text-xs font-semibold">{{ substr($transaksi->pelanggan?->nama ?? 'N/A', 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaksi->pelanggan?->nama ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $transaksi->pelanggan?->telepon ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                        <span class="text-purple-600 text-xs">
                                            @if($transaksi->hewan?->jenis == 'kucing') 🐱
                                            @elseif($transaksi->hewan?->jenis == 'anjing') 🐕
                                            @elseif($transaksi->hewan?->jenis == 'burung') 🐦
                                            @elseif($transaksi->hewan?->jenis == 'kelinci') 🐰
                                            @elseif($transaksi->hewan?->jenis == 'hamster') 🐹
                                            @else 🐾
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaksi->hewan?->nama ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ ucfirst($transaksi->hewan?->jenis ?? 'N/A') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mb-1 bg-blue-100 text-blue-800">
                                {{ ucfirst($transaksi->jenis_layanan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">{{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') }}</div>
                            @if($transaksi->tanggal_keluar && $transaksi->tanggal_keluar != $transaksi->tanggal_masuk)
                                <div class="text-gray-500 text-xs">s/d {{ \Carbon\Carbon::parse($transaksi->tanggal_keluar)->format('d/m/Y') }}</div>
                                @php
                                    $durasi = \Carbon\Carbon::parse($transaksi->tanggal_masuk)->diffInDays(\Carbon\Carbon::parse($transaksi->tanggal_keluar)) + 1;
                                @endphp
                                <div class="text-blue-600 text-xs font-medium">{{ $durasi }} hari</div>
                            @elseif($transaksi->tanggal_keluar == $transaksi->tanggal_masuk)
                                <div class="text-green-600 text-xs font-medium">Satu hari</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ ucfirst($transaksi->status_pembayaran) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-400 py-8">Tidak ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 