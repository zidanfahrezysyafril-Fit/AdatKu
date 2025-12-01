<?php

namespace App\Http\Controllers;

use App\Models\MuaPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MuaPortfolioController extends Controller
{
    /**
     * List galeri foto MUA yang sedang login + form upload.
     */
    public function index()
    {
        // Asumsi: User punya relasi ->mua
        $mua = Auth::user()->mua;

        if (! $mua) {
            abort(403, 'Akun ini belum terdaftar sebagai MUA.');
        }

        $portfolios = $mua->portfolios()->latest()->get();

        return view('portfolio.index', compact('mua', 'portfolios'));
    }

    /**
     * Simpan foto dokumentasi (bisa multiple).
     */
    public function store(Request $request)
    {
        $mua = Auth::user()->mua;

        if (! $mua) {
            abort(403, 'Akun ini belum terdaftar sebagai MUA.');
        }

        // validasi: minimal 1 file
        $request->validate([
            'foto'   => 'required',
            'foto.*' => 'image|max:4096', // max 4MB per file
        ], [
            'foto.required'   => 'Pilih minimal satu foto.',
            'foto.*.image'    => 'File harus berupa gambar.',
            'foto.*.max'      => 'Ukuran maksimal setiap foto 4MB.',
        ]);

        // kalau cuma 1 file tanpa multiple, Laravel akan bungkus jadi array juga
        foreach ((array) $request->file('foto') as $file) {
            if (! $file) continue;

            $path = $file->store('portfolio_mua', 'public');

            $mua->portfolios()->create([
                'foto_path' => $path,
            ]);
        }

        return back()->with('success', 'Foto dokumentasi berhasil ditambahkan!');
    }

    /**
     * Hapus 1 foto dokumentasi.
     */
    public function destroy(MuaPortfolio $portfolio)
    {
        $mua = Auth::user()->mua;

        if (! $mua || $portfolio->mua_id !== $mua->id) {
            abort(403, 'Kamu tidak berhak menghapus foto ini.');
        }

        // hapus file dari storage
        if ($portfolio->foto_path && Storage::disk('public')->exists($portfolio->foto_path)) {
            Storage::disk('public')->delete($portfolio->foto_path);
        }

        $portfolio->delete();

        return back()->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}
