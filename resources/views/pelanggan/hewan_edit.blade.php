@extends('pelanggan.layout')
@section('title', 'Edit Hewan')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-8 mt-6">
    <div class="flex flex-col items-center mb-6">
        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-2xl font-bold text-blue-600 border-4 border-blue-200 mb-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 17l6 6m0 0l6-6m-6 6V3" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Hewan</h2>
        <div class="text-gray-400 text-sm">Perbarui data hewan peliharaan Anda</div>
    </div>
    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ url('pelanggan/hewan/'.$hewan->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $hewan->nama) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Jenis</label>
            <input type="text" name="jenis" value="{{ old('jenis', $hewan->jenis) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Ras</label>
            <input type="text" name="ras" value="{{ old('ras', $hewan->ras) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Usia (tahun)</label>
            <input type="number" name="usia" min="0" value="{{ old('usia', $hewan->usia) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Status Vaksin</label>
            <select name="status_vaksin" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Pilih Status</option>
                <option value="vaccinated" {{ old('status_vaksin', $hewan->status_vaksin) == 'vaccinated' ? 'selected' : '' }}>Sudah Vaksin</option>
                <option value="not_vaccinated" {{ old('status_vaksin', $hewan->status_vaksin) == 'not_vaccinated' ? 'selected' : '' }}>Belum Vaksin</option>
                <option value="partial" {{ old('status_vaksin', $hewan->status_vaksin) == 'partial' ? 'selected' : '' }}>Parsial</option>
            </select>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-lg font-semibold shadow hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection 