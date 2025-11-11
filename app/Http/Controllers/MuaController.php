<?php

namespace App\Http\Controllers;

use App\Models\Mua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class MuaController extends Controller
{
    /**
     * Tampilkan profil MUA milik user login
     */
    public function index()
    {
        $mua = Mua::where('user_id', auth::id())->first(); // bisa null jika belum buat profil
        return view('mua.index', compact('mua'));
    }

    /**
     * Tampilkan form create profil MUA
     */
    public function create()
    {
        return view('mua.create');
    }

    /**
     * Simpan profil MUA baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:100',
            'kontak_wa' => 'required|string|max:20|unique:muas,kontak_wa',
            'nomor_rekening' => 'nullable|string|max:20|unique:muas,nomor_rekening',
            'profile_mua' => 'nullable|string',
            'foto' => 'nullable|image|max:2048', // max 2MB
        ]);

        $data = $request->only(['nama_usaha', 'kontak_wa', 'nomor_rekening', 'profile_mua']);
        $data['user_id'] = auth::id();

        // Upload foto jika ada
        if($request->hasFile('foto')){
            $data['foto'] = $request->file('foto')->store('muas', 'public');
        }

        Mua::create($data);

        return redirect()->route('panelmua.index')->with('success', 'Profil MUA berhasil dibuat!');
    }

    /**
     * Tampilkan form edit profil MUA
     */
    public function edit($id)
    {
        $mua = Mua::findOrFail($id);
        return view('mua.create', compact('mua'));
    }

    /**
     * Update profil MUA
     */
    public function update(Request $request, $id)
    {
        $mua = Mua::findOrFail($id);

        $request->validate([
            'nama_usaha' => 'required|string|max:100',
            'kontak_wa' => 'required|string|max:20|unique:muas,kontak_wa,' . $mua->id,
            'nomor_rekening' => 'nullable|string|max:20|unique:muas,nomor_rekening,' . $mua->id,
            'profile_mua' => 'nullable|string',
            'foto' => 'nullable|image|max:2048', // max 2MB
        ]);

        $data = $request->only(['nama_usaha', 'kontak_wa', 'nomor_rekening', 'profile_mua']);

        // Upload foto jika ada
        if($request->hasFile('foto')){
            // Hapus foto lama jika ada
            if($mua->foto && Storage::disk('public')->exists($mua->foto)){
                Storage::disk('public')->delete($mua->foto);
            }

            $data['foto'] = $request->file('foto')->store('muas', 'public');
        }

        $mua->update($data);

        return redirect()->route('panelmua.index')->with('success', 'Profil MUA berhasil diperbarui!');
    }

    /**
     * Hapus profil MUA
     */
    public function destroy($id)
    {
        $mua = Mua::findOrFail($id);

        // Hapus foto jika ada
        if($mua->foto && Storage::disk('public')->exists($mua->foto)){
            Storage::disk('public')->delete($mua->foto);
        }

        $mua->delete();

        return redirect()->route('panelmua.index')->with('success', 'Profil MUA berhasil dihapus!');
    }
}
