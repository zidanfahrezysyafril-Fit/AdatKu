<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mua;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $mua = auth::mua();
        return view('profile', compact('mua'));
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $mua = auth::mua();
        $mua->update(['name' => $request->name]);
        if ($request->hasFile('profile')) {
            // hapus file lama
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
        }
        return back()->with('success', 'Profile berhasil diperbarui');
    }
}
