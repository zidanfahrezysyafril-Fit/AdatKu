<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    /**
     * Proses login user (email + password) + Remember Me.
     * Flow hybrid: BOLEH login walau email belum terverifikasi.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = strtolower($user->role ?? '');

            // DI SINI sengaja TIDAK dicek email_verified_at,
            // karena dibatasi di middleware 'verified' pada route penting.

            if ($role === 'mua') {
                return redirect()->route('dashboard');
            }

            if ($role === 'pengguna') {
                return redirect()->route('home');
            }

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Tampilkan halaman register.
     */
    public function showRegister()
    {
        return view('auth.register', ['title' => 'Daftar']);
    }

    /**
     * Proses registrasi user baru.
     * Setelah register → langsung login + kirim email verifikasi.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|min:3|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => e($validated['name']),
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'Pengguna',
        ]);

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        // Login otomatis
        Auth::login($user);

        // ALIHAN BARU: ke beranda + flag untuk popup verifikasi
        return redirect()
            ->route('home')
            ->with('show_verify_modal', true);
    }


    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah logout.');
    }

    /**
     * Redirect ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google OAuth.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                }

                if ($googleUser->avatar && !$user->avatar) {
                    $user->avatar = $googleUser->avatar;
                }

                // User login via Google dianggap verified (karena email sudah diverifikasi Google)
                if (is_null($user->email_verified_at)) {
                    $user->email_verified_at = now();
                }

                $user->save();
            } else {
                $user = User::create([
                    'name'              => $googleUser->name,
                    'email'             => $googleUser->email,
                    'google_id'         => $googleUser->id,
                    'avatar'            => $googleUser->avatar,
                    'password'          => null,
                    'role'              => 'Pengguna',
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user, true);
            request()->session()->regenerate();

            $role = strtolower($user->role ?? '');

            if ($role === 'mua') {
                return redirect()->route('dashboard');
            }

            if ($role === 'pengguna') {
                return redirect()->route('home');
            }

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }
}
