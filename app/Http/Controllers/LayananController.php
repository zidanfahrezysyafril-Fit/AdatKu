<?php
namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Mua;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function create()
    {
        $mua = Mua::all();
        return view('mua.create_layanan', compact('mua'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_Mua' => 'required',
            'Nama_Layanan' => 'required',
            'Kategori' => 'required',
            'Harga' => 'required|numeric',
            'Deskripsi' => 'nullable',
        ]);

        Layanan::create([
            'Id_Mua' => $request->Id_Mua,
            'Id_Pengguna' => 1,
            'Nama_Layanan' => $request->Nama_Layanan,
            'Kategori' => $request->Kategori,
            'Deskripsi' => $request->Deskripsi,
            'Ukuran_Status' => 'Tersedia',
            'Harga' => $request->Harga,
        ]);

        return redirect()->route('mua.index')->with('success', 'Layanan berhasil ditambahkan.');
    }
}
