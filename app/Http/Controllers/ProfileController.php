<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // /profile -> tampil "Profil Saya"
    public function showProfile()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    // /profile/edit -> form edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // PUT /profile -> simpan perubahan
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:100',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
<<<<<<< HEAD
        $mua = auth::mua();
        $mua->update(['name' => $request->name]);
        if ($request->hasFile('profile')) {
        
            if ($mua->file) {
                Storage::delete($mua->file->path);
                $mua->file->delete();
            }
            $file = $request->file('profile');
            $extension = $file->getClientOriginalExtension();
            $filename = $mua->id . '_' . time() . '.' . $extension;
            $folder = 'profiles/' . $mua->id;
            $path = $file->storeAs($folder, $filename);
            $mua->file()->create([
                'alias' => 'foto-profil',
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);
=======

        $user = Auth::user();

        if ($request->filled('name')) {
            $user->name = $request->name;
>>>>>>> d1e294adf4292a74ba209b94f048c4b5d640057f
        }

        if ($request->hasFile('profile')) {
            // hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // simpan avatar baru di storage/app/public/profiles/{user_id}/...
            $path = $request->file('profile')->store('profiles/' . $user->id, 'public');
            $user->avatar = $path; // pastikan kolom 'avatar' ada di tabel users
        }

        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Profile berhasil diperbarui');
    }
}
