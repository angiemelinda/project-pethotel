@extends('pelanggan.layout')
@section('title', 'Hewan Peliharaan')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Hewan Peliharaan Saya</h2>
    <a href="{{ route('pelanggan.hewan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">+ Tambah Hewan</a>
</div>
@if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700 text-center text-sm">{{ session('success') }}</div>
@endif
<div class="bg-white rounded-2xl shadow-lg p-6">
    <table class="min-w-full table-auto">
        <thead>
            <tr class="bg-gray-50 text-gray-700 text-base">
                <th class="px-4 py-3 font-semibold text-left">Nama</th>
                <th class="px-4 py-3 font-semibold text-center">Jenis</th>
                <th class="px-4 py-3 font-semibold text-center">Ras</th>
                <th class="px-4 py-3 font-semibold text-center">Usia</th>
                <th class="px-4 py-3 font-semibold text-center">Status Vaksin</th>
                <th class="px-4 py-3 font-semibold text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hewan as $i => $h)
            <tr class="hover:bg-blue-50 transition">
                <td class="border-t px-4 py-3 font-semibold text-gray-800 text-left">{{ $h->nama }}</td>
                <td class="border-t px-4 py-3 text-gray-700 text-center">{{ $h->jenis }}</td>
                <td class="border-t px-4 py-3 text-gray-700 text-center">{{ $h->ras }}</td>
                <td class="border-t px-4 py-3 text-gray-700 text-center">{{ $h->usia ?? '-' }} tahun</td>
                <td class="border-t px-4 py-3 text-center">
                    @if($h->status_vaksin == 'vaccinated')
                        <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Sudah Vaksin</span>
                    @elseif($h->status_vaksin == 'not_vaccinated')
                        <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Belum Vaksin</span>
                    @elseif($h->status_vaksin == 'partial')
                        <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Parsial</span>
                    @else
                        <span class="inline-block px-3 py-1 rounded-full bg-gray-100 text-gray-500 text-xs font-semibold">-</span>
                    @endif
                </td>
                <td class="border-t px-4 py-3 flex gap-2 items-center justify-center">
                    <a href="{{ route('pelanggan.hewan.edit', $h->id) }}" class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 text-sm font-semibold transition">Edit</a>
                    <form action="{{ route('pelanggan.hewan.destroy', $h->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-semibold transition">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-gray-400 py-6">Belum ada hewan terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 