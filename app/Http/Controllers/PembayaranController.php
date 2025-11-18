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
        $mua = auth::user()->mua;

        $pembayaran = \App\Models\Pembayaran::with([
            'pesanan.pengguna',
            'pesanan.layanan',
        ])->whereHas('pesanan.layanan', function ($q) use ($mua) {
            $q->where('mua_id', $mua->id);
        })->orderByDesc('created_at')->get();

        return view('pembayaran.index', compact('pembayaran'));
    }
    public function create(Pesanan $pesanan)
    {

        $mua = Auth::user()->mua;

        if (! $mua || $pesanan->layanan->mua_id !== $mua->id) {
            abort(403);
        }
        if ($pesanan->pembayaran) {
            return redirect()
                ->route('pembayaran.show', $pesanan->pembayaran->id);
        }

        return view('pembayaran.create', compact('pesanan', 'mua'));
    }

    public function edit(Pembayaran $pembayaran)
    {
        $pesanan = $pembayaran->pesanan;

        return view('pembayaran.edit', compact('pembayaran', 'pesanan'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'tanggal_bayar' => ['required', 'date'],
            'metode_bayar'  => ['required', 'in:Transfer_Bank,E_Wallet,COD'],
            'bukti_transfer' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_bayar'  => $request->metode_bayar,
        ];
        if ($request->hasFile('bukti_transfer')) {
            if ($pembayaran->bukti_transfer && Storage::disk('public')->exists($pembayaran->bukti_transfer)) {
                Storage::disk('public')->delete($pembayaran->bukti_transfer);
            }

            $path = $request->file('bukti_transfer')
                ->store('pembayaran', 'public');

            $data['bukti_transfer'] = $path;
        }

        $pembayaran->update($data);

        return redirect()
            ->route('panelmua.pembayaran.index')
            ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    // simpan pembayaran
    public function store(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'tanggal_bayar' => 'required|date',
            'metode_bayar'  => 'required|in:Transfer_Bank,E_Wallet,COD',
            'bukti_transfer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('pembayaran', 'public');
        }

        Pembayaran::create([
            'id_pesanan'    => $pesanan->id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_bayar'  => $request->metode_bayar,
            'bukti_transfer' => $path,
        ]);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil disimpan.');
    }

    // opsional: lihat detail pembayaran
    public function show(Pembayaran $pembayaran)
    {
        $mua = Auth::user()->mua;

        if (! $mua || $pembayaran->pesanan->layanan->mua_id !== $mua->id) {
            abort(403);
        }

        return view('pembayaran.show', compact('pembayaran'));
    }
}
