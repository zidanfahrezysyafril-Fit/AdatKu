<?php
namespace App\Http\Controllers;

use App\Models\Mua;
use Illuminate\Http\Request;

class MuaController extends Controller
{
    public function index()
    {
        $mua = Mua::with('layanan')->get();
        return view('mua.index', compact('mua'));
    }

    public function create()
    {
        return view('mua.create_mua');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama_Usaha' => 'required',
            'Kontak_WA' => 'required',
            'Rekening_Bank' => 'required',
            'Profile_MUA' => 'nullable',
        ]);

        Mua::create([
            'Id_Pengguna' => 1, 
            'Nama_Usaha' => $request->Nama_Usaha,
            'Kontak_WA' => $request->Kontak_WA,
            'Rekening_Bank' => $request->Rekening_Bank,
            'Profile_MUA' => $request->Profile_MUA,
        ]);

        return redirect()->route('mua.index')->with('success', 'Data MUA berhasil ditambahkan.');
    }
}
