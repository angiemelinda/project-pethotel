@extends('staff.layout')
@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Tambah Transaksi
    </h1>
    @php
        $layanans = \App\Models\Layanan::all();
    @endphp
    <form action="{{ route('staff.transaksi.store') }}" method="POST" class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold mb-1">Pelanggan</label>
            <select name="pelanggan_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Pelanggan</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Hewan</label>
            <select name="hewan_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Hewan</option>
                @foreach($hewans as $h)
                    <option value="{{ $h->id }}">{{ $h->nama }} ({{ $h->jenis }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Jenis Layanan</label>
            <div class="space-y-2">
                @foreach($layanans as $layanan)
                    <label class="flex items-center">
                        <input type="checkbox" name="jenis_layanan[]" value="{{ strtolower($layanan->nama) }}" data-harga="{{ $layanan->harga }}" class="mr-2">
                        <span>{{ $layanan->nama }} (Rp {{ number_format($layanan->harga, 0, ',', '.') }}{{ strtolower($layanan->nama) == 'penitipan' ? '/hari' : '' }})</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" class="w-full border rounded px-3 py-2">
            </div>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Total (Rp)</label>
            <input type="number" name="total_harga" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-1">Status Pembayaran</label>
            <select name="status_pembayaran" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Status</option>
                <option value="belum_lunas">Belum Lunas</option>
                <option value="dp">DP</option>
                <option value="lunas">Lunas</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg shadow transition-all flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            Simpan Transaksi
        </button>
    </form>
</div>
@endsection 