@extends('staff.layout')
@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <span class="text-2xl">🐾</span> Tambah Hewan
    </h1>
    <form action="{{ route('staff.hewan.store') }}" method="POST" class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold mb-1">Nama Hewan</label>
            <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Jenis</label>
            <select name="jenis" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Jenis</option>
                <option value="kucing">Kucing</option>
                <option value="anjing">Anjing</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Ras</label>
            <input type="text" name="ras" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Usia (tahun)</label>
            <input type="number" name="usia" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Pemilik</label>
            <select name="pelanggan_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Pemilik</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-1">Status Vaksin</label>
            <select name="status_vaksin" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Status</option>
                <option value="vaccinated">Sudah Vaksin</option>
                <option value="not_vaccinated">Belum Vaksin</option>
                <option value="partial">Vaksin Sebagian</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg shadow transition-all flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            Simpan Hewan
        </button>
    </form>
</div>
@endsection 