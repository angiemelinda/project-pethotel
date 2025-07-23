@extends('admin.layout')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Tambah Layanan</h1>
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('layanan.store') }}" method="POST" class="bg-white rounded-xl shadow p-6">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold mb-1">Nama Layanan</label>
            <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Harga (Rp)</label>
            <input type="number" name="harga" value="{{ old('harga') }}" class="w-full border rounded px-3 py-2" required min="0">
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Durasi (menit)</label>
            <input type="number" name="durasi" value="{{ old('durasi') }}" class="w-full border rounded px-3 py-2" required min="1">
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi" class="w-full border rounded px-3 py-2" rows="3">{{ old('deskripsi') }}</textarea>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('layanan.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
        </div>
    </form>
</div>
@endsection 