@extends('layouts.auth')
@section('content')
    <div class="bg-[rgb(255,255,255,0.6)] shadow-lg rounded-xl p-9 space-y-2">
        <h1 class="text-2xl font-bold text-center text-red-800">Login</h1>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded text-center">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('login.post') }}" class="space-y-4 borde p-8">
            @csrf
            <div>
                <input type="email" name="email" placeholder="Email"
                    class="bg-[rgb(255,255,255,0.8)] border p-2 w-full rounded @error('email') border-red500 @enderror"
                    value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="password" name="password" placeholder="Password"
                    class="bg-[rgb(255,255,255,0.8)] border p-2 w-full rounded @error('password') borderred-500 @enderror"
                    required>
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <span class="bg-[blue] form-check-sign"></span>
                        {{ __('Remember me') }}
                    </label>
                </div>
            </div>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded w-full">
                Login
            </button>
        </form>
        <p class="text-center text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar</a>
        </p>
    </div>
@endsection
