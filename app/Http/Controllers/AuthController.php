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
     */
    public function login(Request $request)
    {
        // Validasi input + custom message
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        // Batasi percobaan login
        if (session()->has('login_attempts') && session('login_attempts') >= 5) {
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam 1 menit.',
            ]);
        }

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
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
            if ($role === 'admin') {
                return redirect()->route('dashboard_a');
            }

            return redirect()->route('dashboard');
        }

        session()->increment('login_attempts', 1);

        throw ValidationException::withMessages([
            // ini error “email atau password salah”
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
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|min:3|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'              => e($validated['name']),
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role'              => 'Pengguna',   // Sesuai enum di DB
            // Kalau mau dianggap sudah verifikasi email, boleh tambahkan:
            // 'email_verified_at' => now(),
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')
            ->with('success', 'Anda telah logout.');
    }

    /**
     * Redirect ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        // Tanpa prompt -> setelah logout, login lagi langsung pakai akun Google terakhir
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
                // Update google_id jika belum ada
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                }

                // Update avatar kalau di DB masih kosong
                if ($googleUser->avatar && !$user->avatar) {
                    $user->avatar = $googleUser->avatar;
                }

                $user->save();
            } else {
                // Buat user baru dengan role default 'Pengguna'
                $user = User::create([
                    'name'              => $googleUser->name,
                    'email'             => $googleUser->email,
                    'google_id'         => $googleUser->id,
                    'avatar'            => $googleUser->avatar,
                    'password'          => null,         // login via Google, tidak perlu password lokal
                    'role'              => 'Pengguna',   // Role default
                    'email_verified_at' => now(),        // Dianggap terverifikasi
                ]);
            }

            // Login user + aktifkan remember me juga
            Auth::login($user, true);
            session()->regenerate();

            // Redirect sesuai role (sama seperti login biasa)
            $role = strtolower($user->role ?? '');

            if ($role === 'mua') {
                return redirect()->route('dashboard');
            }
            if ($role === 'pengguna') {
                return redirect()->route('home');
            }
            if ($role === 'admin') {
                return redirect()->route('dashboard_a');
            }

            return redirect()->route('dashboard');
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }
}
