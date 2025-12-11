<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Update user profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name'    => 'nullable|string|max:100',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Update nama jika diisi
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        // ==== PROSES UPLOAD FOTO PROFIL ====
        if ($request->hasFile('profile')) {

            // 👉 PAKSA KE /public_html/adatku/uploads/profiles/{id}
            $folderPath = base_path('../public_html/adatku/uploads/profiles/' . $user->id);

            // Jika folder belum ada → buat otomatis
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // Hapus foto lama jika ada
            if (!empty($user->avatar)) {
                // path penuh ke file lama (di public_html/adatku/...)
                $oldFile = base_path('../public_html/adatku/' . $user->avatar);

                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }

            // Ambil file baru
            $file = $request->file('profile');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Pindahkan file ke folder upload di public_html/adatku/...
            $file->move($folderPath, $filename);

            // 👉 SIMPAN PATH **UNTUK URL**, BUKAN ABSOLUTE PATH
            // karena yang diakses browser mulai dari `/adatku/`
            $user->avatar = 'uploads/profiles/' . $user->id . '/' . $filename;
        }

        // Simpan user
        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function showProfile()
    {
        if (url()->previous()) {
            return redirect()->back();
        }

        return redirect()->route('home');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
}
