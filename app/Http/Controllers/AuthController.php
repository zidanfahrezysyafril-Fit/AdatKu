<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    /**
     * Proses login user
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6']
        ]);

        // Batasi percobaan login
        if (session()->has('login_attempts') && session('login_attempts') >= 5) {
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam 1 menit.'
            ]);
        }

        // Cek login valid
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            session()->forget('login_attempts');

            $user = Auth::user();
            $role = strtolower($user->role ?? '');

            if ($role === 'mua') {
                return redirect()->route('dashboard');
            }
            if ($role === 'pengguna') {
                return redirect()->route('home');
            }
            return redirect()->route('dashboard');
            }
        // Jika gagal login
        session()->increment('login_attempts', 1);
        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.'
        ]);
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        return view('auth.register', ['title' => 'Daftar']);
    }

    /**
     * Proses registrasi user baru
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        User::create([
            'name' => e($validated['name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pengguna',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah logout.');
    }
}
