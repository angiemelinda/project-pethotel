@extends('staff.layout')
@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Edit Transaksi
    </h1>
    @php
        $layananHarga = collect(\App\Models\Layanan::pluck('harga', 'nama'))->mapWithKeys(function($v, $k) {
            return [strtolower($k) => $v];
        })->toArray();
    @endphp
    <form action="{{ route('staff.transaksi.update', $transaksi->id) }}" method="POST" class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto" id="formTransaksi">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block font-semibold mb-1">Pelanggan</label>
            <select name="pelanggan_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Pelanggan</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}" {{ $transaksi->pelanggan_id == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Hewan</label>
            <select name="hewan_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Hewan</option>
                @foreach($hewans as $h)
                    <option value="{{ $h->id }}" {{ $transaksi->hewan_id == $h->id ? 'selected' : '' }}>{{ $h->nama }} ({{ $h->jenis }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Jenis Layanan</label>
            @php
                $layananArray = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
                $layananArray = is_array($layananArray) ? $layananArray : [$transaksi->jenis_layanan];
                $statusDetail = is_string($transaksi->status_layanan_detail) ? json_decode($transaksi->status_layanan_detail, true) : ($transaksi->status_layanan_detail ?? []);
            @endphp
            <div class="space-y-2" id="layananCheckboxes">
                @foreach(['penitipan','grooming','vaksinasi','checkup'] as $layanan)
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="jenis_layanan[]" value="{{ $layanan }}" class="mr-2 layanan-check" {{ in_array($layanan, $layananArray) ? 'checked' : '' }} data-harga="{{ $layananHarga[$layanan] ?? 0 }}">
                        <span>{{ ucfirst($layanan) }} <span class="text-xs text-gray-500">({{ isset($layananHarga[$layanan]) ? 'Rp '.number_format($layananHarga[$layanan],0,',','.') : 'Rp 0' }})</span></span>
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="w-full border rounded px-3 py-2" value="{{ $transaksi->tanggal_masuk }}" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" class="w-full border rounded px-3 py-2" value="{{ $transaksi->tanggal_keluar }}">
            </div>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Total (Rp)</label>
            <input type="number" name="total_harga" class="w-full border rounded px-3 py-2" value="{{ $transaksi->total_harga ?? '' }}" required id="totalHarga">
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-1">Status Pembayaran</label>
            <select name="status_pembayaran" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Status</option>
                <option value="belum_lunas" {{ $transaksi->status_pembayaran == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="dp" {{ $transaksi->status_pembayaran == 'dp' ? 'selected' : '' }}>DP</option>
                <option value="lunas" {{ $transaksi->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 rounded-lg shadow transition-all flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            Update Transaksi
        </button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hargaLayanan = @json($layananHarga);
        const checkboxes = document.querySelectorAll('.layanan-check');
        const totalHargaInput = document.getElementById('totalHarga');
        function updateTotal() {
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseInt(hargaLayanan[cb.value] || 0);
                }
            });
            totalHargaInput.value = total;
        }
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateTotal);
        });
        updateTotal(); // initial
    });
</script>
@endsection 