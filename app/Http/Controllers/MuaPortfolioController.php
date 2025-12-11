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

        // ====== FOLDER TUJUAN DI HOSTING ======
        // /home/ourj2192/public_html/adatku/uploads/portfolio_mua/{mua_id}
        $folderPath = base_path('../public_html/adatku/uploads/portfolio_mua/' . $mua->id);

        if (! is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Laravel bisa kirim 1 file atau banyak → samakan jadi array
        $files = $request->file('foto');
        if (! is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if (! $file) {
                continue;
            }

            // Nama file unik
            $filename = 'portfolio-' . $mua->id . '-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Pindahkan ke /public_html/adatku/uploads/portfolio_mua/{mua_id}
            $file->move($folderPath, $filename);

            // Path RELATIF dari root web (/adatku/)
            // supaya di Blade cukup pakai: asset($item->foto_path)
            $relativePath = 'uploads/portfolio_mua/' . $mua->id . '/' . $filename;

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

        // Hapus file dari /public_html/adatku/uploads/...
        if (! empty($portfolio->foto_path)) {
            // foto_path berisi: uploads/portfolio_mua/{mua_id}/nama-file.jpg
            $fullPath = base_path('../public_html/adatku/' . $portfolio->foto_path);

            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $portfolio->delete();

        return back()->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}
