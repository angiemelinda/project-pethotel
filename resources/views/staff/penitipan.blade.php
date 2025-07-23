@extends('staff.layout')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Penitipan Hari Ini / Aktif</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <form method="GET" class="flex flex-wrap gap-2 mb-4 items-end">
        <div>
            <label class="block text-sm font-semibold mb-1">Cari Nama Hewan</label>
            <input type="text" name="search" value="{{ request('search') }}" class="border rounded px-3 py-2 w-48" placeholder="Nama hewan...">
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Status Layanan</label>
            <select name="status_layanan" class="border rounded px-3 py-2 w-40">
                <option value="">Semua Status</option>
                <option value="check-in" {{ request('status_layanan')=='check-in'?'selected':'' }}>Check-in</option>
                <option value="sedang dirawat" {{ request('status_layanan')=='sedang dirawat'?'selected':'' }}>Sedang Dirawat</option>
                <option value="selesai" {{ request('status_layanan')=='selesai'?'selected':'' }}>Selesai</option>
                <option value="diambil" {{ request('status_layanan')=='diambil'?'selected':'' }}>Diambil</option>
            </select>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700" type="submit">Filter</button>
    </form>
    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama Hewan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Jenis Layanan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status Layanan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal Masuk</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal Keluar</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama Pelanggan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transaksis as $transaksi)
                <tr>
                    <td class="px-4 py-3">{{ $transaksi->hewan->nama ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $transaksi->jenis_layanan }}</td>
                    <td class="px-4 py-3">
                        <form action="{{ route('staff.penitipan.update_status', $transaksi->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <select name="status_layanan" class="border rounded px-2 py-1 text-xs">
                                <option value="check-in" {{ ($transaksi->status_layanan ?? 'check-in') == 'check-in' ? 'selected' : '' }}>Check-in</option>
                                <option value="sedang dirawat" {{ ($transaksi->status_layanan ?? '') == 'sedang dirawat' ? 'selected' : '' }}>Sedang Dirawat</option>
                                <option value="selesai" {{ ($transaksi->status_layanan ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="diambil" {{ ($transaksi->status_layanan ?? '') == 'diambil' ? 'selected' : '' }}>Diambil</option>
                            </select>
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600">Update</button>
                        </form>
                    </td>
                    <td class="px-4 py-3">{{ $transaksi->tanggal_masuk }}</td>
                    <td class="px-4 py-3">{{ $transaksi->tanggal_keluar ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $transaksi->pelanggan->nama ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('staff.transaksi.cetak', $transaksi->id) }}" target="_blank" class="text-indigo-600 hover:underline text-xs">Cetak</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">Tidak ada data penitipan hari ini/aktif.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 