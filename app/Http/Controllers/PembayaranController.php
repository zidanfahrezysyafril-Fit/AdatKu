<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('pembayaran', 'public');
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
            'bukti_transfer' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_bayar'  => $request->metode_bayar,
        ];

        if ($request->hasFile('bukti_transfer')) {
            if (
                $pembayaran->bukti_transfer &&
                Storage::disk('public')->exists($pembayaran->bukti_transfer)
            ) {
                Storage::disk('public')->delete($pembayaran->bukti_transfer);
            }

            $path = $request->file('bukti_transfer')->store('pembayaran', 'public');

            $data['bukti_transfer'] = $path;
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
     * 🔹 BARU DITAMBAHKAN
     * Stream bukti transfer lewat Laravel supaya tidak 403 dari /storage/...
     */
    public function viewBukti(Pembayaran $pembayaran)
    {
        $user = Auth::user();
        $mua  = $user->mua;

        // keamanan
        if (! $mua || (int) optional($pembayaran->pesanan->layanan)->mua_id !== (int) $mua->id) {
            abort(403, 'Pembayaran ini tidak terkait dengan MUA yang login.');
        }

        // cek file bukti
        if (! $pembayaran->bukti_transfer || ! Storage::disk('public')->exists($pembayaran->bukti_transfer)) {
            abort(404);
        }

        $path = $pembayaran->bukti_transfer;

        // AMBIL FILE & MIME TYPE YANG BENAR (TANPA NAMED ARGUMENT)
        $file = Storage::disk('public')->get($path);
        $mime = Storage::disk('public')->mimeType($path);

        return response($file, 200)->header('Content-Type', $mime);
    }
}
