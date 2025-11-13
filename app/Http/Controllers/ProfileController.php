<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Update user profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => 'nullable|string|max:100',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Jika ada input nama baru
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        // Jika ada file gambar profil yang diunggah
        if ($request->hasFile('profile')) {

            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan foto baru ke folder storage/app/public/profiles/{user_id}/
            $path = $request->file('profile')->store('profiles/' . $user->id, 'public');

            // Simpan path ke kolom avatar
            $user->avatar = $path;
        }

        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
    public function showProfile()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
}
