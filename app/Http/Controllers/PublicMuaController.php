<?php

namespace App\Http\Controllers;

use App\Models\Mua;

class PublicMuaController extends Controller
{
    public function index()
    {
        $muas = Mua::whereNotNull('nama_usaha')
            ->orderBy('nama_usaha')
            ->get();

        return view('menudpn.mua', compact('muas'));
    }

    public function show(Mua $mua)
    {
        $mua->load('layanan');

        $layanan = $mua->layanan;

        return view('menudpn.detailmua', compact('mua', 'layanan'));
    }
}
