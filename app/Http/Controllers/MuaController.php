<?php

namespace App\Http\Controllers;

use App\Models\Mua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MuaController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $mua = Mua::where('user_id', Auth::id())->first();
        return view('mua.index', compact('mua'));
=======
        $mua = Mua::where('user_id', auth::id())->first(); // bisa null jika belum buat profil
        return view('profilemua.index', compact('mua'));
>>>>>>> 73b16e9b9ff43d8aff68f9f4c904bd1b0efbcfc8
    }

    public function create()
    {
        return view('profilemua.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:100',
            'kontak_wa' => 'required|string|max:20|unique:muas,kontak_wa',
<<<<<<< HEAD
            'nomor_rekening' => 'nullable|string|max:20|unique:muas,nomor_rekening',
            'profile_mua' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_usaha', 'kontak_wa', 'nomor_rekening', 'profile_mua']);
        $data['user_id'] = Auth::id();
=======
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_usaha', 'kontak_wa', 'alamat', 'deskripsi', 'instagram', 'tiktok',]);
        $data['user_id'] = auth::id();
>>>>>>> 73b16e9b9ff43d8aff68f9f4c904bd1b0efbcfc8

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('muas', 'public');
        }

        Mua::create($data);

        return redirect()->route('panelmua.index')->with('success', 'Profil MUA berhasil dibuat!');
    }

    public function edit($id)
    {
        $mua = Mua::findOrFail($id);
        return view('profilemua.create', compact('mua'));
    }

    public function update(Request $request, $id)
    {
        $mua = Mua::findOrFail($id);

        $request->validate([
            'nama_usaha' => 'required|string|max:100',
<<<<<<< HEAD
            'kontak_wa' => 'required|string|max:20|unique:muas,kontak_wa,' . $mua->id,
            'nomor_rekening' => 'nullable|string|max:20|unique:muas,nomor_rekening,' . $mua->id,
            'profile_mua' => 'nullable|string',
=======
            'kontak_wa' => 'required|string|max:20|unique:muas,kontak_wa,',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
>>>>>>> 73b16e9b9ff43d8aff68f9f4c904bd1b0efbcfc8
            'foto' => 'nullable|image|max:2048',
        ]);
        $data = $request->only(['nama_usaha', 'kontak_wa', 'alamat', 'deskripsi', 'instagram', 'tiktok',]);

        if ($request->hasFile('foto')) {
            if ($mua->foto && Storage::disk('public')->exists($mua->foto)) {
                Storage::disk('public')->delete($mua->foto);
            }
            $data['foto'] = $request->file('foto')->store('muas', 'public');
        }

        $mua->update($data);

        return redirect()->route('panelmua.index')->with('success', 'Profil MUA berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $mua = Mua::findOrFail($id);

        if ($mua->foto && Storage::disk('public')->exists($mua->foto)) {
            Storage::disk('public')->delete($mua->foto);
        }

        $mua->delete();

        return redirect()->route('panelmua.index')->with('success', 'Profil MUA berhasil dihapus!');
    }
}
