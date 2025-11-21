<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect ke halaman login Google.
     * TANPA prompt -> supaya setelah logout, login lagi
     * langsung pakai akun Google terakhir (tidak pilih akun).
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menangani callback dari Google setelah user login.
     */
    public function handleGoogleCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // Kalau user sudah ada -> update data seperlunya

                // Isi google_id kalau sebelumnya masih null
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                }

                // Isi avatar dari Google kalau di DB masih kosong
                if ($googleUser->avatar && !$user->avatar) {
                    $user->avatar = $googleUser->avatar;
                }

                $user->save();
            } else {
                // Kalau user belum pernah ada -> buat user baru
                $user = User::create([
                    'name'              => $googleUser->name,
                    'email'             => $googleUser->email,
                    'google_id'         => $googleUser->id,
                    'avatar'            => $googleUser->avatar,
                    'password'          => null,       
                    'role'              => 'Pengguna', 
                    'email_verified_at' => now(), //      
                ]);
            }

            // Login-kan user ke aplikasi
            Auth::login($user);

            // Redirect sesuai role
            return $this->redirectBasedOnRole($user);
        } catch (Exception $e) {
            // Bisa kamu dd($e->getMessage()) saat debug kalau perlu
            return redirect('/login')
                ->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }

    /**
     * Redirect user setelah login berdasarkan role.
     */
    private function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case 'Admin':
                return redirect()->intended('/admin/dashboard');

            case 'MUA':
                return redirect()->intended('/dashboard');

            case 'Pengguna':
            default:
                return redirect()->intended('/home');
        }
    }

    /**
     * Logout user dari aplikasi (session Laravel saja, bukan dari akun Google).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session lama
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
