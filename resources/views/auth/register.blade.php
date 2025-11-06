@extends('layouts.auth')
@section('content')
<div class="bg-white/90 shadow-xl rounded-2xl p-3 space-y-1 border border-gray-200 backdrop-blur-sm">
    <h1 class="text-3xl font-bold text-center text-red-800 ">Register</h1>

    <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
        @csrf

        <input type="text" name="name" placeholder="Nama Lengkap"
            class="border border-gray-300 p-3 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300"
            value="{{ old('name') }}" required>

        <input type="email" name="email" placeholder="Email"
            class="border border-gray-300 p-3 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300"
            value="{{ old('email') }}" required>

        <input type="password" name="password" placeholder="Password"
            class="border border-gray-300 p-3 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300"
            required>

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
            class="border border-gray-300 p-3 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300"
            required>

        <button type="submit"
            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg w-full transition duration-300">
            Daftar
        </button>
    </form>

    <p class="text-center text-sm text-gray-600">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-red-500 font-medium hover:underline">Login</a>
    </p>
</div>
@endsection
