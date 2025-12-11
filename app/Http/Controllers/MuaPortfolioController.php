<?php

namespace App\Http\Controllers;

use App\Models\MuaPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MuaPortfolioController extends Controller
{
    /**
     * List galeri foto MUA yang sedang login + form upload.
     */
    public function index()
    {
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

        // Validasi: minimal 1 file
        $request->validate([
            'foto'   => 'required',
            'foto.*' => 'image|max:4096', // max 4MB per file
        ], [
            'foto.required' => 'Pilih minimal satu foto.',
            'foto.*.image'  => 'File harus berupa gambar.',
            'foto.*.max'    => 'Ukuran maksimal setiap foto 4MB.',
        ]);

        // Folder tujuan: public/uploads/portfolio_mua
        $basePath = public_path('uploads/portfolio_mua');

        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }

        // Laravel akan jadikan array walau cuma 1 file
        foreach ((array) $request->file('foto') as $file) {
            if (! $file) {
                continue;
            }

            // Nama file unik, disisipkan id MUA biar gampang tracking
            $filename = $mua->id . '-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Pindahkan ke folder public/uploads/portfolio_mua
            $file->move($basePath, $filename);

            // Path yang disimpan di DB (relatif dari folder public)
            $relativePath = 'uploads/portfolio_mua/' . $filename;

            $mua->portfolios()->create([
                'foto_path' => $relativePath,
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

        // Hapus file dari folder public/uploads/portfolio_mua
        if (!empty($portfolio->foto_path)) {
            $fullPath = public_path($portfolio->foto_path);

            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $portfolio->delete();

        return back()->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}
