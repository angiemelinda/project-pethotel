@extends('staff.layout')
@section('content')
<div class="flex justify-center items-center min-h-[60vh] bg-gradient-to-br from-indigo-100 via-sky-50 to-white py-8">
    <div class="w-full max-w-md bg-white/80 glass rounded-2xl shadow-xl p-8">
        <div class="flex flex-col items-center mb-6">
            <div class="bg-indigo-100 p-3 rounded-full mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4z"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-indigo-700">Ganti Password</h2>
            <p class="text-gray-500 text-sm mt-1">Pastikan password baru mudah diingat dan aman.</p>
        </div>
        @if(session('success'))
            <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-700 text-center text-sm font-semibold">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 px-4 py-2 rounded bg-red-100 text-red-700 text-center text-sm font-semibold">
                {{ $errors->first() }}
            </div>
        @endif
        <form action="{{ route('staff.update_password') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Password Baru</label>
                <input type="password" name="password" class="w-full border border-indigo-200 focus:border-indigo-400 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-100 transition" required placeholder="Password baru">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-indigo-200 focus:border-indigo-400 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-100 transition" required placeholder="Ulangi password baru">
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg shadow transition-all flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Simpan Password
            </button>
        </form>
    </div>
</div>
@endsection 