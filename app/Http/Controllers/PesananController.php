<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PesananController extends Controller
{
    /* ===================== PENGGUNA ===================== */

    /**
     * Halaman "Pesanan Saya" untuk pengguna.
     */
    public function indexUser(): View
    {
        $pesanan = Pesanan::where('id_pengguna', Auth::id())
            ->with(['layanan', 'pengguna'])
            ->latest()
            ->get(); // collection

        return view('pengguna.pesanan.index', compact('pesanan'));
    }

    /**
     * Detail pesanan pengguna.
     * Saat ini diarahkan kembali ke index.
     */
    public function showUser(Pesanan $pesanan): RedirectResponse
    {
        if ($pesanan->id_pengguna !== Auth::id()) {
            abort(403);
        }

        $pesanan->load('layanan', 'pengguna');

        // sekarang masih cuma punya halaman list
        return redirect()->route('pengguna.pesanan.index');
    }

    /**
     * Pengguna membatalkan pesanan.
     * - 1 kartu = 1 group kode_checkout
     * - HANYA yang statusnya Belum_Lunas / pending yang di-set jadi Dibatalkan
     */
    public function destroyUser(Pesanan $pesanan): RedirectResponse
    {
        $userId = Auth::id();

        // Pastikan pesanan milik user yang login
        if ($pesanan->id_pengguna !== $userId) {
            abort(403);
        }

        $kodeCheckout = $pesanan->kode_checkout;

        if ($kodeCheckout) {
            // semua pesanan dengan kode_checkout yang sama milik user ini
            $group = Pesanan::where('id_pengguna', $userId)
                ->where('kode_checkout', $kodeCheckout)
                ->get();
        } else {
            // tidak punya kode_checkout → pesanan single
            $group = collect([$pesanan]);
        }

        // Ambil hanya yang masih bisa dibatalkan (support data lama)
        $bisaDibatalkan = $group->filter(function ($p) {
            $raw = $p->status_pembayaran ?? '';
            $status = strtolower(str_replace(' ', '_', $raw));

            // anggap bisa dibatalkan jika masih belum lunas / pending
            return in_array($status, ['belum_lunas', 'pending'], true);
        });

        if ($bisaDibatalkan->isEmpty()) {
            return back()->with(
                'error',
                'Tidak ada layanan yang bisa dibatalkan pada pesanan ini.'
            );
        }

        foreach ($bisaDibatalkan as $p) {
            $p->status_pembayaran = 'Dibatalkan';
            $p->save();
        }

        return redirect()
            ->route('pengguna.pesanan.index')
            ->with('success', 'Pesanan berhasil dibatalkan untuk ' . $bisaDibatalkan->count() . ' layanan.');
    }

    /**
     * Simpan pesanan baru dari pengguna (satu layanan).
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'layanan_id'      => ['required', 'exists:layanans,id'],
            'tanggal_booking' => ['required', 'date', 'after_or_equal:today'],
            'alamat'          => ['required', 'string', 'max:500'],
            'catatan'         => ['nullable', 'string'],
        ]);

        $layanan = Layanan::findOrFail($validated['layanan_id']);

        Pesanan::create([
            'id_pengguna'       => Auth::id(),
            'id_layanan'        => $layanan->id,
            'tanggal_booking'   => $validated['tanggal_booking'],
            'alamat'            => $validated['alamat'],
            'catatan'           => $validated['catatan'] ?? null,
            'total_harga'       => $layanan->harga,
            'status_pembayaran' => 'Belum_Lunas',
        ]);

        return redirect()
            ->route('pengguna.pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Form buat pesanan baru (satu layanan).
     */
    public function createUser(Layanan $layanan): View
    {
        return view('pengguna.pesanan.create', compact('layanan'));
    }

    /* ===================== PANEL MUA ===================== */

    /**
     * List pesanan di panel MUA (digroup per kode_checkout).
     */
    public function indexMua(): View|RedirectResponse
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

        // group per checkout
        $groupedPesanans = $pesanans->groupBy(function ($p) {
            return $p->kode_checkout ?: ('single-' . $p->id);
        });

        return view('pesanan.index', [
            'mua'             => $mua,
            'groupedPesanans' => $groupedPesanans,
        ]);
    }

    /**
     * MUA update status pembayaran.
     * - status 1 group checkout di-set sama semua
     *   biar tampilan panel MUA & pengguna selalu sinkron
     */
    public function updateStatusMua(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        $mua  = $user->mua;

        // kalau user belum punya profil MUA → tolak
        if (! $mua) {
            abort(403, 'Profil MUA tidak ditemukan.');
        }

        // cari pesanan yang bener-bener milik MUA ini
        $pesanan = Pesanan::where('id', $id)
            ->whereHas('layanan', function ($q) use ($mua) {
                $q->where('mua_id', $mua->id);
            })
            ->with('layanan')
            ->firstOrFail();

        // validasi status
        $data = $request->validate([
            'status_pembayaran' => 'required|in:Belum_Lunas,Lunas,Dibatalkan',
        ]);

        $kodeCheckout = $pesanan->kode_checkout;

        if ($kodeCheckout) {
            // update semua pesanan dalam 1 checkout untuk MUA ini
            Pesanan::where('kode_checkout', $kodeCheckout)
                ->whereHas('layanan', function ($q) use ($mua) {
                    $q->where('mua_id', $mua->id);
                })
                ->update(['status_pembayaran' => $data['status_pembayaran']]);
        } else {
            // pesanan single (tanpa kode_checkout)
            $pesanan->status_pembayaran = $data['status_pembayaran'];
            $pesanan->save();
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * MUA menghapus satu pesanan (bukan cancel status).
     */
    public function destroyMua(Pesanan $pesanan): RedirectResponse
    {
        $user = Auth::user();
        $mua  = $user->mua;

        $layanan = $pesanan->layanan;

        if (! $mua || ! $layanan || $layanan->mua_id !== $mua->id) {
            abort(403);
        }

        $pesanan->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }
}
