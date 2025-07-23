@extends('admin.layout')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Daftar Layanan</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <div class="mb-4 flex justify-end">
        <a href="{{ route('layanan.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Tambah Layanan</a>
    </div>
    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Harga</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Durasi (menit)</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Deskripsi</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($layanans as $layanan)
                <tr>
                    <td class="px-4 py-3">{{ $layanan->nama }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($layanan->harga,0,',','.') }}</td>
                    <td class="px-4 py-3">{{ $layanan->durasi }}</td>
                    <td class="px-4 py-3">{{ $layanan->deskripsi }}</td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('layanan.edit', $layanan->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs">Edit</a>
                        <form action="{{ route('layanan.destroy', $layanan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus layanan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada layanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 