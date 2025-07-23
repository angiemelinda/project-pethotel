@php
    use App\Models\JadwalLayanan;
@endphp
@extends('pelanggan.layout')
@section('title', 'Riwayat Transaksi')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-8 mt-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Riwayat Transaksi</h2>
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700 text-center text-sm">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto rounded-xl overflow-hidden shadow">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-base">
                    <th class="px-4 py-3 font-semibold text-left">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-center">Hewan</th>
                    <th class="px-4 py-3 font-semibold text-center">Layanan</th>
                    <th class="px-4 py-3 font-semibold text-center">Status</th>
                    <th class="px-4 py-3 font-semibold text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr class="hover:bg-blue-50 transition">
                    <td class="border-t px-4 py-3 text-gray-800 text-left">{{ $t->tanggal_masuk ? \Carbon\Carbon::parse($t->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                    <td class="border-t px-4 py-3 text-gray-700 text-center">{{ $t->hewan->nama ?? '-' }}</td>
                    <td class="border-t px-4 py-3 text-gray-700 text-center">
                        @php
                            $layanans = [];
                            if (!empty($t->jenis_layanan)) {
                                $layanans = is_array($t->jenis_layanan) ? $t->jenis_layanan : json_decode($t->jenis_layanan, true);
                            }
                        @endphp
                        @if($layanans && is_array($layanans))
                            <div class="flex flex-wrap gap-1 justify-center">
                                @foreach($layanans as $layanan)
                                    @php
                                        $jadwal = JadwalLayanan::where('hewan_id', $t->hewan_id)
                                            ->where('tanggal', $t->tanggal_masuk)
                                            ->whereHas('layanan', function($q) use ($layanan) {
                                                $q->whereRaw('LOWER(nama) = ?', [strtolower($layanan)]);
                                            })->first();
                                    @endphp
                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                        {{ ucfirst($layanan) }}
                                        @if($jadwal)
                                            <span class="ml-1 px-2 py-0.5 rounded-full text-xs font-medium
                                                @if($jadwal->status == 'selesai') bg-green-100 text-green-800
                                                @elseif($jadwal->status == 'proses') bg-yellow-100 text-yellow-800
                                                @elseif($jadwal->status == 'dibatalkan') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif
                                            ">
                                                {{ ucfirst($jadwal->status) }}
                                            </span>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="border-t px-4 py-3 text-center">
                        @if($t->status_pembayaran === 'lunas')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Lunas</span>
                        @elseif($t->status_pembayaran === 'dp')
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">DP</span>
                        @else
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Belum Lunas</span>
                        @endif
                    </td>
                    <td class="border-t px-4 py-3 text-center font-bold text-green-700">Rp{{ number_format($t->total_harga ?? 0,0,',','.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-400 py-6">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection