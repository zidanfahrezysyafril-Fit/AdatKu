<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);
        
        $lockUntil = session('login_lock_until');

        if ($lockUntil && Carbon::now()->lt(Carbon::parse($lockUntil))) {
            $sisaDetik = Carbon::now()->diffInSeconds(Carbon::parse($lockUntil));
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $sisaDetik . ' detik.',
            ])->onlyInput('email');
        }

        if ($lockUntil && Carbon::now()->gte(Carbon::parse($lockUntil))) {
            session()->forget(['login_attempts', 'login_lock_until']);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            session()->forget(['login_attempts', 'login_lock_until']);

            return redirect()->intended('/home')->with('success', 'Login berhasil! Selamat datang 👋');
        }

        $attempts = (int) session('login_attempts', 0) + 1;
        session(['login_attempts' => $attempts]);

        if ($attempts >= 5) {
            session(['login_lock_until' => Carbon::now()->addSeconds(60)->toDateTimeString()]);
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ])->status(422);
    }

    public function showRegister()
    {
        return view('auth.register', ['title' => 'Daftar']);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|min:3|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => e($validated['name']),
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah logout.');
    }
}
