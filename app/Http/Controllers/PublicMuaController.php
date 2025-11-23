<?php

namespace App\Http\Controllers;

use App\Models\Mua;
use App\Models\Keranjang;
use App\Models\KeranjangActive;
use Illuminate\Support\Facades\Auth;

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
        // ambil layanan milik MUA ini
        $mua->load('layanan');
        $layanan = $mua->layanan;

        // default kalau belum login / belum ada keranjang
        $cartItems = collect();
        $cartCount = 0;
        $cartTotal = 0;

        // kalau user sudah login, ambil keranjang-nya
        if (Auth::check()) {
            $userId = Auth::id();

            // cek MUA aktif di keranjang (Kalau kamu pake KeranjangActive)
            $active = KeranjangActive::where('id_pengguna', $userId)
                ->where('id_mua', $mua->id)
                ->first();

            // ambil item keranjang milik user
            $query = Keranjang::with('layanan')
                ->where('id_pengguna', $userId);

            // kalau ada MUA aktif -> filter berdasarkan MUA itu
            if ($active) {
                $query->whereHas('layanan', function ($q) use ($active) {
                    $q->where('mua_id', $active->id_mua);
                });
            } else {
                // kalau belum ada record aktif, paksa filter ke MUA yang sedang dibuka
                $query->whereHas('layanan', function ($q) use ($mua) {
                    $q->where('mua_id', $mua->id);
                });
            }

            $cartItems = $query->get();

            // hitung total item & total harga
            $cartCount = $cartItems->sum('jumlah');
            $cartTotal = $cartItems->sum(function ($item) {
                return (optional($item->layanan)->harga ?? 0) * $item->jumlah;
            });
        }

        // kirim juga cartItems, cartCount, cartTotal ke blade
        return view('menudpn.detailmua', compact(
            'mua',
            'layanan',
            'cartItems',
            'cartCount',
            'cartTotal'
        ));
    }
}
