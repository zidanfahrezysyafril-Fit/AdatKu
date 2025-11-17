<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ambil semua pesanan milik user yang login
        $pesanan = Pesanan::with(['mua', 'layanan'])
            ->where('id_pengguna', $user->id)
            ->latest()
            ->get();

        return view('pesanan.index', compact('pesanan'));
    }
}
