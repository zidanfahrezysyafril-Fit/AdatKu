@extends('layouts.auth')
@section('content')
<div class="bg-white/90 shadow-xl rounded-2xl p-6 space-y-3 border border-[#f5d547]/60 backdrop-blur-sm">
    <h1 class="text-3xl font-bold text-center bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent drop-shadow-lg">
        Register
    </h1>

    <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
        @csrf

        <input type="text" name="name" placeholder="Nama Lengkap"
            class="border border-[#f8e48c] focus:border-[#eab308] focus:ring-1 focus:ring-[#f8e48c] bg-[rgba(255,255,255,0.85)] p-3 w-full rounded-lg placeholder:text-gray-500 text-gray-800"
            value="{{ old('name') }}" required>

        <input type="email" name="email" placeholder="Email"
            class="border border-[#f8e48c] focus:border-[#eab308] focus:ring-1 focus:ring-[#f8e48c] bg-[rgba(255,255,255,0.85)] p-3 w-full rounded-lg placeholder:text-gray-500 text-gray-800"
            value="{{ old('email') }}" required>

        <input type="password" name="password" placeholder="Password"
            class="border border-[#f8e48c] focus:border-[#eab308] focus:ring-1 focus:ring-[#f8e48c] bg-[rgba(255,255,255,0.85)] p-3 w-full rounded-lg placeholder:text-gray-500 text-gray-800"
            required>

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
            class="border border-[#f8e48c] focus:border-[#eab308] focus:ring-1 focus:ring-[#f8e48c] bg-[rgba(255,255,255,0.85)] p-3 w-full rounded-lg placeholder:text-gray-500 text-gray-800"
            required>
        <button type="submit"
            class="w-full bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-[#f8e48c] hover:to-[#e0a100] transition duration-300">
            Daftar
        </button>
    </form>

    <p class="text-center text-sm text-gray-700">
        Sudah punya akun?
        <a href="{{ route('login') }}"
            class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent font-semibold hover:underline">
            Login
        </a>
    </p>
</div>
@endsection
