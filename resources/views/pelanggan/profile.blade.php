@extends('pelanggan.layout')
@section('title', 'Profile')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-8 mt-6">
    <div class="flex flex-col items-center mb-6">
        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-3xl font-bold text-blue-600 border-4 border-blue-200 mb-2">
            {{ strtoupper(substr($pelanggan->nama,0,1)) }}
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Profile</h2>
        <div class="text-gray-400 text-sm">Perbarui data akun Anda di bawah ini</div>
            </div>
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700 text-center text-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('pelanggan.profile.update') }}" method="POST" class="space-y-5">
        @csrf
            <div>
            <label class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $pelanggan->nama) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
            <label class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $pelanggan->email) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
            <label class="block text-gray-700 font-medium mb-1">Password Baru <span class="text-gray-400 text-xs">(Kosongkan jika tidak ingin ganti)</span></label>
            <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-lg font-semibold shadow hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection 