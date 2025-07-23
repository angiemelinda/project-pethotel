@extends('staff.layout')
@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <span class="text-2xl">🐾</span> Edit Hewan
    </h1>
    <form action="{{ route('staff.hewan.update', $hewan->id) }}" method="POST" class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block font-semibold mb-1">Nama Hewan</label>
            <input type="text" name="nama" class="w-full border rounded px-3 py-2" value="{{ $hewan->nama }}" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Jenis</label>
            <select name="jenis" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Jenis</option>
                <option value="kucing" {{ $hewan->jenis == 'kucing' ? 'selected' : '' }}>Kucing</option>
                <option value="anjing" {{ $hewan->jenis == 'anjing' ? 'selected' : '' }}>Anjing</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Ras</label>
            <input type="text" name="ras" class="w-full border rounded px-3 py-2" value="{{ $hewan->ras }}">
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Usia (tahun)</label>
            <input type="number" name="usia" class="w-full border rounded px-3 py-2" value="{{ $hewan->usia }}">
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Pemilik</label>
            <select name="pelanggan_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Pemilik</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}" {{ $hewan->pelanggan_id == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-1">Status Vaksin</label>
            <select name="status_vaksin" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Status</option>
                <option value="vaccinated" {{ $hewan->status_vaksin == 'vaccinated' ? 'selected' : '' }}>Sudah Vaksin</option>
                <option value="not_vaccinated" {{ $hewan->status_vaksin == 'not_vaccinated' ? 'selected' : '' }}>Belum Vaksin</option>
                <option value="partial" {{ $hewan->status_vaksin == 'partial' ? 'selected' : '' }}>Vaksin Sebagian</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 rounded-lg shadow transition-all flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            Update Hewan
        </button>
    </form>
</div>
@endsection 