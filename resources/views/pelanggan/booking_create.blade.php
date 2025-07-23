@extends('pelanggan.layout')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded-xl shadow p-8 mt-8">
    <h2 class="text-2xl font-bold mb-6 text-blue-700 flex items-center gap-2">Booking Layanan <span>📝</span></h2>
    <form action="{{ route('pelanggan.booking.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Hewan</label>
            <select name="hewan_id" required class="w-full border rounded px-3 py-2">
                <option value="">Pilih Hewan</option>
                @foreach($hewans as $hewan)
                    <option value="{{ $hewan->id }}">{{ $hewan->nama }} ({{ ucfirst($hewan->jenis) }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
            <div class="flex flex-col gap-2">
                @foreach($layanans as $layanan)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="jenis_layanan[]" value="{{ strtolower($layanan->nama) }}" class="form-checkbox text-blue-600" data-harga="{{ $layanan->harga }}">
                        <span class="ml-2">{{ $layanan->nama }} (Rp{{ number_format($layanan->harga, 0, ',', '.') }})</span>
                    </label>
                @endforeach
            </div>
            @if($errors->has('jenis_layanan'))
                <div class="text-red-600 text-sm mt-1">{{ $errors->first('jenis_layanan') }}</div>
            @endif
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" required class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">Booking</button>
    </form>
</div>
@endsection 