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
    /**
     * Halaman keranjang.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // MUA aktif yang sedang dipilih user
        $active = KeranjangActive::where('id_pengguna', $user->id)->first();

        // Item keranjang hanya milik MUA aktif
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

    /**
     * Tambah layanan ke keranjang.
     */
    public function add(Request $request)
    {
        // =============== VALIDASI INPUT ===============
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

        // =============== BATAS AKSES ===============
        // Hanya ROLE: pengguna yang boleh tambah ke keranjang
        if (strtolower((string) $user->role) !== 'pengguna') {
            abort(403, 'Akses khusus pengguna.');
        }

        // =============== AMBIL DATA LAYANAN ===============
        $layanan = Layanan::select('id', 'mua_id', 'harga', 'nama')
            ->with('mua:id,nama_usaha')
            ->findOrFail($validated['layanan_id']);

        // =============== SET MUA AKTIF ===============
        KeranjangActive::updateOrCreate(
            ['id_pengguna' => $user->id],
            ['id_mua' => $layanan->mua_id]
        );

        // =============== MASUKKAN / UPDATE KERANJANG ===============
        $item = Keranjang::firstOrNew([
            'id_pengguna' => $user->id,
            'id_layanan'  => $layanan->id,
        ]);

        // tambah jumlah
        $item->jumlah = ($item->exists ? $item->jumlah : 0) + (int) $validated['jumlah'];
        $item->save();

        // =============== FEEDBACK ===============
        return back()->with('success', "{$layanan->nama} ditambahkan ke keranjang ✔");
    }

    /**
     * Checkout keranjang → menjadi pesanan.
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil MUA aktif
        $active = KeranjangActive::where('id_pengguna', $user->id)->first();

        if (!$active) {
            return back()->with('error', 'Keranjangmu masih kosong.');
        }

        // Semua item keranjang yg sesuai MUA aktif
        $items = Keranjang::with('layanan')
            ->where('id_pengguna', $user->id)
            ->whereHas('layanan', function ($q) use ($active) {
                $q->where('mua_id', $active->id_mua);
            })
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjangmu masih kosong.');
        }

        // ===== DATA TAMBAHAN CHECKOUT =====
        $tanggalBooking = $request->input('tanggal_booking', now()->toDateString());
        $alamat         = $request->input('alamat', '- (akan diisi saat konfirmasi dengan MUA)');

        // Kode unik untuk mengelompokkan pesanan
        $kodeCheckout = 'ADK-' . now()->format('YmdHis') . '-' . $user->id;

        // ===== SIMPAN PESANAN & KOSONGKAN KERANJANG =====
        DB::transaction(function () use ($items, $user, $tanggalBooking, $alamat, $active, $kodeCheckout) {

            foreach ($items as $item) {
                $layanan = $item->layanan;

                if (!$layanan) continue;

                Pesanan::create([
                    'id_pengguna'       => $user->id,
                    'id_layanan'        => $layanan->id,
                    'id_mua'            => $layanan->mua_id,
                    'kode_checkout'     => $kodeCheckout, // kode grup pesanan
                    'jumlah'            => $item->jumlah,
                    'total_harga'       => ($layanan->harga ?? 0) * ($item->jumlah ?? 1),
                    'tanggal_booking'   => $tanggalBooking,
                    'status'            => 'pending',
                    'status_pembayaran' => 'Belum_Lunas',
                    'alamat'            => $alamat,
                ]);
            }

            // kosongkan keranjang untuk MUA ini
            Keranjang::where('id_pengguna', $user->id)
                ->whereHas('layanan', function ($q) use ($active) {
                    $q->where('mua_id', $active->id_mua);
                })
                ->delete();

            // hapus status MUA aktif
            KeranjangActive::where('id_pengguna', $user->id)->delete();
        });

        return redirect()
            ->route('pengguna.pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat dari keranjang.');
    }
}
