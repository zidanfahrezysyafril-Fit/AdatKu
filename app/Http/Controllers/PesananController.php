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
        $pesanan = Pesanan::where('id_pengguna', Auth::id())
            ->with(['layanan', 'pengguna']) // sekalian load relasi biar ga N+1
            ->latest()
            ->get(); // <-- ini COLLECTION

        return view('pengguna.pesanan.index', compact('pesanan'));
    }


    public function showUser(Pesanan $pesanan)
    {
        if ($pesanan->id_pengguna !== Auth::id()) {
            abort(403);
        }

        // Kalau mau, bisa sekalian load relasi (opsional)
        $pesanan->load('layanan', 'pengguna');

        // Balikkan saja ke halaman daftar pesanan
        return redirect()->route('pengguna.pesanan.show');
    }


    public function destroyUser(Pesanan $pesanan)
    {
        $userId = Auth::id();

        // Pastikan ini pesanan milik user yang login
        if ($pesanan->id_pengguna !== $userId) {
            abort(403);
        }

        // Ambil kode_checkout dari pesanan yang diklik
        $kodeCheckout = $pesanan->kode_checkout;

        if ($kodeCheckout) {
            // 🔸 Ambil SEMUA pesanan dalam 1 checkout (1 kartu)
            $group = Pesanan::where('id_pengguna', $userId)
                ->where('kode_checkout', $kodeCheckout)
                ->get();
        } else {
            // 🔸 Fallback: kalau belum ada kode_checkout, batalin satuan saja
            $group = collect([$pesanan]);
        }

        // Cek: ada yang sudah Lunas / Dibatalkan?
        $nonCancelable = $group->filter(function ($p) {
            return $p->status_pembayaran !== 'Belum_Lunas';
        });

        if ($nonCancelable->isNotEmpty()) {
            return back()->with(
                'error',
                'Ada layanan di pesanan ini yang sudah dibayar / dibatalkan, jadi tidak bisa dibatalkan.'
            );
        }

        // Set SEMUA dalam grup jadi Dibatalkan
        foreach ($group as $p) {
            $p->status_pembayaran = 'Dibatalkan';
            $p->save();
        }

        return redirect()
            ->route('pengguna.pesanan.index')
            ->with('success', 'Pesanan berhasil dibatalkan untuk ' . $group->count() . ' layanan.');
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

        // 🔹 Group per checkout (1 checkout = 1 baris)
        $groupedPesanans = $pesanans->groupBy(function ($p) {
            return $p->kode_checkout ?: ('single-' . $p->id);
        });

        return view('pesanan.index', [
            'mua'             => $mua,
            'groupedPesanans' => $groupedPesanans,
        ]);
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
            ->route('pengguna.pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat.');
    }
    public function createUser(Layanan $layanan)
    {
        return view('pengguna.pesanan.create', compact('layanan'));
    }
}
