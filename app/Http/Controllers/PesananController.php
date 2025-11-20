<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function indexUser()
    {
        $pesanans = Pesanan::where('id_pengguna', auth::id())
            ->with('layanan')
            ->latest()
            ->get();

        return view('pengguna.pesanan.index', compact('pesanans'));
    }

    public function showUser(Pesanan $pesanan)
    {
        if ($pesanan->id_pengguna !== auth::id()) {
            abort(403);
        }

        $pesanan->load('layanan', 'pengguna');

        return view('pengguna.pesanan.show', compact('pesanan'));
    }

    public function destroyUser(Pesanan $pesanan)
    {
        if ($pesanan->id_pengguna !== Auth::id()) {
            abort(403);
        }
        if ($pesanan->status_pembayaran !== 'Belum_Lunas') {
            return back()->with('error', 'Pesanan yang sudah dibayar / dibatalkan tidak bisa dibatalkan lagi.');
        }
        $pesanan->status_pembayaran = 'Dibatalkan';
        $pesanan->save();
        return redirect()->route('pengguna.pesanan.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
    public function indexMua()
    {
        $user = Auth::user();
        $mua  = $user->mua;

        if (! $mua) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Profil MUA kamu belum dibuat.');
        }

        $pesanans = Pesanan::with(['pengguna', 'layanan'])
            ->whereHas('layanan', function ($q) use ($mua) {
                $q->where('mua_id', $mua->id);
            })
            ->latest()
            ->get();

        return view('pesanan.index', compact('pesanans', 'mua'));
    }
    public function updateStatusMua(Request $request, Pesanan $pesanan)
    {
        $user = Auth::user();
        $mua  = $user->mua;
        if (! $mua || $pesanan->layanan->mua_id !== $mua->id) {
            abort(403);
        }

        $request->validate([
            'status_pembayaran' => 'required|in:Belum_Lunas,Lunas,Dibatalkan',
        ]);

        $pesanan->status_pembayaran = $request->status_pembayaran;
        $pesanan->save();

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
    public function destroyMua(Pesanan $pesanan)
    {
        $user = Auth::user();
        $mua  = $user->mua;

        if (! $mua || $pesanan->layanan->mua_id !== $mua->id) {
            abort(403);
        }

        $pesanan->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }
    public function storeUser(Request $request)
    {
        // 1) VALIDASI TERMASUK layanan_id
        $validated = $request->validate([
            'layanan_id'      => ['required', 'exists:layanans,id'],
            'tanggal_booking' => ['required', 'date', 'after_or_equal:today'],
            'alamat'          => ['required', 'string', 'max:500'],
            'catatan'         => ['nullable', 'string'],
        ]);

        // 2) AMBIL DATA LAYANAN DARI DATABASE
        $layanan = Layanan::findOrFail($validated['layanan_id']);

        // 3) SIMPAN PESANAN
        $pesanan = Pesanan::create([
            'id_pengguna'       => Auth::id(),              // id user yang login
            'id_layanan'        => $layanan->id,
            'tanggal_booking'   => $validated['tanggal_booking'],
            'alamat'            => $validated['alamat'],
            'catatan'           => $validated['catatan'] ?? null,
            'total_harga'       => $layanan->harga,
            'status_pembayaran' => 'Belum_Lunas',
        ]);

        // 4) ARAHKAN KE HALAMAN DETAIL PESANAN
        return redirect()
            ->route('pengguna.show', $pesanan->id)
            ->with('success', 'Pesanan berhasil dibuat.');
    }
    public function createUser(Layanan $layanan)
    {
        return view('pengguna.pesanan.create', compact('layanan'));
    }
}
