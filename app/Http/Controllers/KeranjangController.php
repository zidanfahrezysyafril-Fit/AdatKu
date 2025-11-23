<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\KeranjangActive;
use App\Models\Layanan;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil MUA aktif
        $active = KeranjangActive::where('id_pengguna', $user->id)->first();

        // Ambil item keranjang yang sesuai MUA aktif
        $keranjangs = Keranjang::with(['layanan.mua'])
            ->where('id_pengguna', $user->id)
            ->when($active, function ($q) use ($active) {
                $q->whereHas('layanan', function ($q2) use ($active) {
                    $q2->where('mua_id', $active->id_mua);
                });
            })
            ->get();

        return view('keranjang.index', compact('keranjangs', 'active'));
    }

    public function add(Request $request)
    {
        // ===== VALIDASI =====
        $validated = $request->validate([
            'layanan_id' => ['required', 'exists:layanans,id'],
            'jumlah'     => ['required', 'integer', 'min:1'],
        ], [
            'layanan_id.required' => 'Layanan tidak boleh kosong.',
            'layanan_id.exists'   => 'Layanan tidak ditemukan.',
            'jumlah.required'     => 'Jumlah wajib diisi.',
            'jumlah.integer'      => 'Jumlah harus angka.',
            'jumlah.min'          => 'Jumlah minimal 1.',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // ⛔ INI YANG BIKIN KAMU KE-BLOCK KEMARIN:
        // if (!in_array($user->role, ['admin'])) { abort(403, 'Akses khusus pengguna.'); }

        // ✅ YANG BENAR: HANYA IZINKAN ROLE "pengguna"
        if (strtolower((string) $user->role) !== 'pengguna') {
            abort(403, 'Akses khusus pengguna.');
        }

        // ===== AMBIL DATA LAYANAN & MUA =====
        $layanan = Layanan::select('id', 'mua_id', 'harga', 'nama')
            ->with('mua:id,nama_usaha')
            ->findOrFail($validated['layanan_id']);

        // ===== UPDATE MUA AKTIF KERANJANG =====
        KeranjangActive::updateOrCreate(
            ['id_pengguna' => $user->id],
            ['id_mua' => $layanan->mua_id]
        );

        // ===== UPDATE / TAMBAH ITEM DIPILIH =====
        $item = Keranjang::firstOrNew([
            'id_pengguna' => $user->id,
            'id_layanan'  => $layanan->id,
        ]);

        $item->jumlah = ($item->exists ? $item->jumlah : 0) + (int) $validated['jumlah'];
        $item->save();

        // ===== FEEDBACK =====
        return back()->with('success', "{$layanan->nama} ditambahkan ke keranjang ✔");
    }
    public function checkout(Request $request)
    {
        $user = Auth::user();

        $active = KeranjangActive::where('id_pengguna', $user->id)->first();
        if (! $active) {
            return back()->with('error', 'Keranjangmu masih kosong.');
        }

        $items = Keranjang::with('layanan')
            ->where('id_pengguna', $user->id)
            ->whereHas('layanan', function ($q) use ($active) {
                $q->where('mua_id', $active->id_mua);
            })
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjangmu masih kosong.');
        }

        // 🔸 TANGGAL & ALAMAT
        $tanggalBooking = $request->input('tanggal_booking', now()->toDateString());
        $alamat = $request->input('alamat', '- (akan diisi saat konfirmasi dengan MUA)');

        // 🔸 KODE CHECKOUT (SAMA UNTUK SEMUA ITEM DI CHECKOUT INI)
        $kodeCheckout = 'ADK-' . now()->format('YmdHis') . '-' . $user->id;

        DB::transaction(function () use ($items, $user, $tanggalBooking, $alamat, $active, $kodeCheckout) {
            foreach ($items as $item) {
                $layanan = $item->layanan;
                if (! $layanan) {
                    continue;
                }

                Pesanan::create([
                    'id_pengguna'     => $user->id,
                    'id_layanan'      => $layanan->id,
                    'id_mua'          => $layanan->mua_id,
                    'kode_checkout'   => $kodeCheckout,                  // ✅ kunci pengelompok
                    'jumlah'          => $item->jumlah ?? 1,
                    'total_harga'     => ($layanan->harga ?? 0) * ($item->jumlah ?? 1),
                    'tanggal_booking' => $tanggalBooking,
                    'status'          => 'pending',
                    'status_pembayaran' => 'Belum_Lunas',                 // kalau pakai kolom ini
                    'alamat'          => $alamat,
                ]);
            }

            // kosongkan keranjang + active MUA
            Keranjang::where('id_pengguna', $user->id)
                ->whereHas('layanan', function ($q) use ($active) {
                    $q->where('mua_id', $active->id_mua);
                })
                ->delete();

            KeranjangActive::where('id_pengguna', $user->id)->delete();
        });

        return redirect()
            ->route('pengguna.pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat dari keranjang.');
    }
}
