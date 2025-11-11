<?php

namespace App\Http\Controllers;

use App\Models\Mua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;



class MuaController extends Controller
{
    /**
     * Tampilkan profil MUA milik user login
     */
    public function index()
    {
        $mua = Mua::where('user_id', auth::id())->first(); // bisa null jika belum buat profil
        return view('profilemua.index', compact('mua'));
    }

    /**
     * Tampilkan form create profil MUA
     */
    public function create()
    {
        return view('profilemua.create');
    }

    /**
     * Simpan profil MUA baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:100',
            'kontak_wa' => 'required|string|max:20|unique:muas,kontak_wa',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_usaha', 'kontak_wa', 'alamat', 'deskripsi', 'instagram', 'tiktok',]);
        $data['user_id'] = auth::id();

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
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
        return view('profilemua.edit', compact('mua'));
    }

    /**
     * Update profil MUA
     */
    public function update(Request $request, $id)
    {
        $mua = Mua::findOrFail($id);

        if ($mua->user_id !== Auth::id()) {
            abort(403);
        }

        // === BLOK VALIDASI (yang baru) ===
        $data = $request->validate([
            'nama_usaha' => ['required', 'string', 'max:100'],
            'kontak_wa'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('muas', 'kontak_wa')
                    ->ignore($mua->id, 'id')
                    ->whereNull('deleted_at'),
            ],
            'alamat'     => ['nullable', 'string'],
            'deskripsi'  => ['nullable', 'string'],
            'instagram'  => ['nullable', 'string', 'max:100'],
            'tiktok'     => ['nullable', 'string', 'max:100'],
            'foto'       => ['nullable', 'image', 'max:2048'],
        ]);


        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            if ($mua->foto && Storage::disk('public')->exists($mua->foto)) {
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
        if ($mua->foto && Storage::disk('public')->exists($mua->foto)) {
            Storage::disk('public')->delete($mua->foto);
        }

        $mua->delete();

        if ($mua) {
        } else {
            $data['user_id'] = auth::id();   // pertama kali buat
            $mua = Mua::create($data);
        }

        return back()->with('success', 'Profil MUA berhasil disimpan.');
    }
}