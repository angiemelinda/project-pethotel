@extends('staff.layout')
@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <rect width="20" height="14" x="2" y="5" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 10h20" />
        </svg>
        Daftar Check-out Hari Ini
    </h1>
    @if(session('success'))
        <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-700 text-center text-sm font-semibold">{{ session('success') }}</div>
    @endif
    <div class="glass rounded-2xl shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase">Hewan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase">Tanggal Keluar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transaksis as $index => $transaksi)
                    <tr>
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $transaksi->hewan->nama ?? '-' }} ({{ $transaksi->hewan->jenis ?? '-' }})</td>
                        <td class="px-6 py-4">{{ $transaksi->pelanggan->nama ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $transaksi->tanggal_keluar }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ ucfirst($transaksi->status_layanan ?? '-') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('staff.transaksi.update_status', $transaksi->id) }}" method="POST" class="inline">
                                @csrf
                                <select name="status_layanan" class="border rounded px-2 py-1 text-xs">
                                    <option value="sedang dirawat" {{ ($transaksi->status_layanan ?? '') == 'sedang dirawat' ? 'selected' : '' }}>Sedang Dirawat</option>
                                    <option value="selesai" {{ ($transaksi->status_layanan ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="diambil" {{ ($transaksi->status_layanan ?? '') == 'diambil' ? 'selected' : '' }}>Diambil</option>
                                </select>
                                <button type="submit" class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs">Update</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-8">Tidak ada data check-out hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 