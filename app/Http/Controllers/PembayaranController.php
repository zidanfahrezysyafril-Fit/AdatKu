<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mua  = $user->mua;

        if (! $mua) {
            abort(403, 'Profil MUA tidak ditemukan.');
        }

        $pembayaran = Pembayaran::with([
            'pesanan.pengguna',
            'pesanan.layanan',
        ])
            ->whereHas('pesanan.layanan', function ($q) use ($mua) {
                $q->where('mua_id', $mua->id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('pembayaran.index', compact('pembayaran'));
    }

    public function create(Pesanan $pesanan)
    {
        $user = Auth::user();
        $mua  = $user->mua;

        if (! $mua || (int) optional($pesanan->layanan)->mua_id !== (int) $mua->id) {
            abort(403, 'Pesanan ini tidak terkait dengan MUA yang login.');
        }

        return view('pembayaran.create', compact('pesanan', 'mua'));
    }

    public function store(Request $request, Pesanan $pesanan)
    {
        $user = Auth::user();
        $mua  = $user->mua;

        if (! $mua || (int) optional($pesanan->layanan)->mua_id !== (int) $mua->id) {
            abort(403, 'Pesanan ini tidak terkait dengan MUA yang login.');
        }

        $request->validate([
            'tanggal_bayar'   => ['required', 'date'],
            'metode_bayar'    => ['required', 'in:Transfer_Bank,E_Wallet,COD'],
            'bukti_transfer'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $path = null;

        // ==== SIMPAN KE public/uploads/pembayaran ====
        if ($request->hasFile('bukti_transfer')) {

            $folderPath = public_path('uploads/pembayaran');

            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $file = $request->file('bukti_transfer');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($folderPath, $filename);

            // path yg disimpan di DB (relatif dari public)
            $path = 'uploads/pembayaran/' . $filename;
        }

        Pembayaran::create([
            'id_pesanan'     => $pesanan->id,
            'tanggal_bayar'  => $request->tanggal_bayar,
            'metode_bayar'   => $request->metode_bayar,
            'bukti_transfer' => $path,
        ]);

        return redirect()
            ->route('panelmua.pembayaran.index')
            ->with('success', 'Data pembayaran berhasil disimpan.');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $pesanan = $pembayaran->pesanan;

        return view('pembayaran.edit', compact('pembayaran', 'pesanan'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $user = Auth::user();
        $mua  = $user->mua;

        if (! $mua || (int) optional($pembayaran->pesanan->layanan)->mua_id !== (int) $mua->id) {
            abort(403, 'Pembayaran ini tidak terkait dengan MUA yang login.');
        }

        $request->validate([
            'tanggal_bayar'  => ['required', 'date'],
            'metode_bayar'   => ['required', 'in:Transfer_Bank,E_Wallet,COD'],
            'bukti_transfer' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $data = [
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_bayar'  => $request->metode_bayar,
        ];

        // ==== JIKA GANTI BUKTI TRANSFER ====
        if ($request->hasFile('bukti_transfer')) {

            // hapus file lama kalau ada
            if (!empty($pembayaran->bukti_transfer)) {
                $oldPath = public_path($pembayaran->bukti_transfer);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $folderPath = public_path('uploads/pembayaran');

            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $file = $request->file('bukti_transfer');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($folderPath, $filename);

            $data['bukti_transfer'] = 'uploads/pembayaran/' . $filename;
        }

        $pembayaran->update($data);

        return redirect()
            ->route('panelmua.pembayaran.index')
            ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function show(Pembayaran $pembayaran)
    {
        $user = Auth::user();
        $mua  = $user->mua;

        if (! $mua || (int) optional($pembayaran->pesanan->layanan)->mua_id !== (int) $mua->id) {
            abort(403, 'Pembayaran ini tidak terkait dengan MUA yang login.');
        }

        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Stream bukti transfer dari folder public/uploads/pembayaran
     */
    public function viewBukti(Pembayaran $pembayaran)
    {
        $user = Auth::user();
        $mua  = $user->mua;

        if (! $mua || (int) optional($pembayaran->pesanan->layanan)->mua_id !== (int) $mua->id) {
            abort(403, 'Pembayaran ini tidak terkait dengan MUA yang login.');
        }

        if (empty($pembayaran->bukti_transfer)) {
            abort(404);
        }

        $fullPath = public_path($pembayaran->bukti_transfer);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        // tampilkan langsung di browser
        return response()->file($fullPath);
    }
}
