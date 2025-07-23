@php
    use App\Models\JadwalLayanan;
@endphp
@extends('staff.layout')
@section('title', 'Status Layanan')
@section('content')
@include('staff.partials.navbar')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6 text-indigo-700 flex items-center gap-2">
        <span>Status Semua Layanan</span>
    </h1>
    <a href="{{ route('staff.dashboard') }}" class="inline-block mb-4 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow text-sm font-semibold flex items-center gap-1 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Kembali ke Dashboard
    </a>
    <div class="bg-white rounded-xl shadow-lg p-6">
        <table class="min-w-full table-auto rounded-xl overflow-hidden shadow">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-base">
                    <th class="px-4 py-3 font-semibold text-left">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-left">Hewan</th>
                    <th class="px-4 py-3 font-semibold text-left">Layanan</th>
                    <th class="px-4 py-3 font-semibold text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach(JadwalLayanan::with(['hewan','layanan'])->orderBy('tanggal','desc')->get() as $jadwal)
                <tr class="hover:bg-blue-50 transition">
                    <td class="border-t px-4 py-3 text-gray-800 text-left">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}</td>
                    <td class="border-t px-4 py-3 text-gray-700 text-left">{{ $jadwal->hewan->nama ?? '-' }}</td>
                    <td class="border-t px-4 py-3 text-gray-700 text-left">{{ $jadwal->layanan->nama ?? '-' }}</td>
                    <td class="border-t px-4 py-3 text-center">
                        <form action="{{ route('admin.jadwal.updateStatus', $jadwal->id) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="rounded border-gray-300 text-xs">
                                <option value="menunggu" {{ $jadwal->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="proses" {{ $jadwal->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai" {{ $jadwal->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $jadwal->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 