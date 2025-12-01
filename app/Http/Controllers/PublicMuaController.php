<?php

namespace App\Http\Controllers;

use App\Models\Mua;
use App\Models\Keranjang;
use App\Models\KeranjangActive;
use Illuminate\Support\Facades\Auth;

class PublicMuaController extends Controller
{
    /**
     * Halaman daftar semua MUA (public).
     */
    public function index()
    {
        $muas = Mua::whereNotNull('nama_usaha')
            ->orderBy('nama_usaha')
            ->get();

        return view('menudpn.mua', compact('muas'));
    }

    /**
     * Halaman detail satu MUA
     */
    public function show(Mua $mua)
    {
        // Ambil layanan + galeri dokumentasi milik MUA ini
        $mua->load(['layanan', 'portfolios']);
        $layanan = $mua->layanan;

        // Default kalau belum login / belum ada keranjang
        $cartItems = collect();
        $cartCount = 0;
        $cartTotal = 0;

        // Kalau user sudah login, ambil keranjang-nya
        if (Auth::check()) {
            $userId = Auth::id();

            // Cek MUA aktif di keranjang (kalau kamu pakai KeranjangActive)
            $active = KeranjangActive::where('id_pengguna', $userId)
                ->where('id_mua', $mua->id)
                ->first();

            // Ambil item keranjang milik user
            $query = Keranjang::with('layanan')
                ->where('id_pengguna', $userId);

            // Kalau ada MUA aktif -> filter berdasarkan MUA itu
            if ($active) {
                $query->whereHas('layanan', function ($q) use ($active) {
                    $q->where('mua_id', $active->id_mua);
                });
            } else {
                // Kalau belum ada record aktif, paksa filter ke MUA yang sedang dibuka
                $query->whereHas('layanan', function ($q) use ($mua) {
                    $q->where('mua_id', $mua->id);
                });
            }

            $cartItems = $query->get();

            // Hitung total item & total harga
            $cartCount = $cartItems->sum('jumlah');
            $cartTotal = $cartItems->sum(function ($item) {
                return (optional($item->layanan)->harga ?? 0) * $item->jumlah;
            });
        }

        // Kirim data ke Blade
        return view('menudpn.detailmua', compact(
            'mua',
            'layanan',
            'cartItems',
            'cartCount',
            'cartTotal'
        ));
    }
}
