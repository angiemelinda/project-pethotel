@extends('pelanggan.layout')
@section('title', 'Booking Layanan')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-8 mt-6">
    <div class="flex flex-col items-center mb-6">
        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-2xl font-bold text-green-600 border-4 border-green-200 mb-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Booking Layanan</h2>
        <div class="text-gray-400 text-sm">Pilih hewan, layanan, dan tanggal booking</div>
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
    <form action="{{ route('pelanggan.booking.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-gray-700 font-medium mb-1">Hewan</label>
            <select name="hewan_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">-- Pilih Hewan --</option>
                @foreach($hewan as $h)
                    <option value="{{ $h->id }}">{{ $h->nama }} ({{ $h->jenis }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Layanan</label>
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
            <label class="block text-gray-700 font-medium mb-1">Tanggal Booking</label>
            <input type="date" name="tanggal_masuk" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-8 py-2 rounded-lg font-semibold shadow hover:bg-green-700 transition">Booking</button>
        </div>
    </form>
</div>
@endsection 