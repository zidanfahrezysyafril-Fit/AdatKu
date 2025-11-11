@extends('layouts.auth')
@section('content')
    <div class="bg-[rgba(255,255,255,0.6)] shadow-lg rounded-xl p-9 space-y-2 border border-[#f5d547]/60">
        <h1 class="text-3xl font-bold text-center bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent drop-shadow-lg">
            Login
        </h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4 p-8">
            @csrf
            <div>
                <input type="email" name="email" placeholder="Email"
                    class="bg-[rgba(255,255,255,0.8)] border border-[#f8e48c] focus:border-[#eab308] focus:ring-1 focus:ring-[#f8e48c] p-2 w-full rounded placeholder:text-gray-500 text-gray-800"
                    value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="password" name="password" placeholder="Password"
                    class="bg-[rgba(255,255,255,0.8)] border border-[#f8e48c] focus:border-[#eab308] focus:ring-1 focus:ring-[#f8e48c] p-2 w-full rounded placeholder:text-gray-500 text-gray-800"
                    required>
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="flex items-center space-x-2 text-gray-700">
                    <input class="accent-[#eab308]" type="checkbox" name="remember" id="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-[#f8e48c] hover:to-[#e0a100] transition">
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-700">
            Belum punya akun?
            <a href="{{ route('register') }}"
                class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent font-semibold hover:underline">
                Daftar
            </a>
        </p>
    </div>
@endsection
