<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Update google_id dan avatar jika belum ada
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                }
                
                // Update avatar dari Google (opsional)
                if ($googleUser->avatar && !$user->avatar) {
                    $user->avatar = $googleUser->avatar;
                }
                
                $user->save();
            } else {
                // Buat user baru dengan role default 'Pengguna'
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar, // Simpan avatar dari Google
                    'password' => null, // Tidak perlu password untuk Google login
                    'role' => 'Pengguna', // Role default
                    'email_verified_at' => now(), // Otomatis terverifikasi karena via Google
                ]);
            }

            Auth::login($user);

            // Redirect berdasarkan role
            return $this->redirectBasedOnRole($user);

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }

    private function redirectBasedOnRole($user)
    {
        // Redirect berdasarkan role user
        switch ($user->role) {
            case 'Admin':
                return redirect()->intended('/admin/dashboard');
            case 'MUA':
                return redirect()->intended('/mua/dashboard');
            case 'Pengguna':
            default:
                return redirect()->intended('/dashboard');
        }
    }
}