@extends('layouts.app')

@section('content')
<div class="px-8 py-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-rose-700 mb-4">Edit Pembayaran</h1>

    <div class="bg-white rounded-2xl shadow border border-rose-100 p-6 space-y-4">

        <div class="text-sm mb-4">
            <p class="font-semibold text-slate-800">
                Pesanan: {{ $pesanan->layanan->nama ?? '-' }}
            </p>
            <p class="text-slate-500 text-xs">
                Booking: {{ \Carbon\Carbon::parse($pesanan->tanggal_booking)->translatedFormat('d M Y') }}
                • Total: <span class="font-semibold text-amber-600">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </span>
            </p>
        </div>

        <form action="{{ route('panelmua.pembayaran.update', $pembayaran->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Tanggal Bayar
                </label>
                <input type="date" name="tanggal_bayar"
                       value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar) }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300">
                @error('tanggal_bayar')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Metode Pembayaran
                </label>
                <select name="metode_bayar"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300">
                    <option value="Transfer_Bank" @selected(old('metode_bayar', $pembayaran->metode_bayar) === 'Transfer_Bank')>
                        Transfer Bank
                    </option>
                    <option value="E_Wallet" @selected(old('metode_bayar', $pembayaran->metode_bayar) === 'E_Wallet')>
                        E-Wallet
                    </option>
                    <option value="COD" @selected(old('metode_bayar', $pembayaran->metode_bayar) === 'COD')>
                        COD
                    </option>
                </select>
                @error('metode_bayar')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Bukti Transfer (opsional)
                </label>

                @if ($pembayaran->bukti_transfer)
                    <div class="mb-2">
                        <p class="text-xs text-slate-500 mb-1">Bukti sekarang:</p>
                        <img src="{{ asset('storage/'.$pembayaran->bukti_transfer) }}"
                             class="max-h-48 rounded-lg border">
                    </div>
                @endif

                <input type="file" name="bukti_transfer"
                       class="w-full text-sm">
                <p class="text-[11px] text-slate-400 mt-1">
                    Biarkan kosong kalau tidak ingin mengganti.
                </p>

                @error('bukti_transfer')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 mt-4">
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-rose-600 text-white text-sm hover:bg-rose-700">
                    Simpan Perubahan
                </button>

                <a href="{{ route('panelmua.pembayaran.index') }}"
                   class="px-4 py-2 rounded-lg border text-sm text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection