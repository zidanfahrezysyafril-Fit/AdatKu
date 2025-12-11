@extends('layouts.app')

@section('title', 'Edit Pembayaran')

@section('content')
    <main class="w-full px-4 sm:px-6 lg:px-10 py-6 sm:py-8">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white/95 rounded-3xl ring-1 ring-[#FACC6B]/40 shadow-sm overflow-hidden">
                {{-- HEADER --}}
                <div
                    class="px-5 sm:px-7 py-5 bg-gradient-to-r from-[#fff7f9] via-[#fff8ef] to-[#fffaf3] border-b border-rose-50">
                    <p class="text-[10px] sm:text-[11px] font-semibold tracking-[0.22em] text-amber-500 uppercase">
                        MUA Panel
                    </p>
                    <h1 class="text-xl sm:text-2xl font-bold mt-1" style="color:#C98A00;">
                        Edit Pembayaran
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Perbarui detail pembayaran pesanan ini.
                    </p>
                </div>

                {{-- BODY --}}
                <div class="px-5 sm:px-7 py-5 sm:py-6 space-y-5">
                    {{-- Info pesanan --}}
                    <div class="text-xs sm:text-sm mb-2">
                        <p class="font-semibold text-slate-800">
                            Pesanan: {{ $pesanan->layanan->nama ?? '-' }}
                        </p>
                        <p class="text-slate-500 text-[11px] sm:text-xs mt-1">
                            Booking:
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_booking)->translatedFormat('d M Y') }}
                            • Total:
                            <span class="font-semibold text-amber-600">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </span>
                        </p>
                    </div>

                    <form action="{{ route('panelmua.pembayaran.update', $pembayaran->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        {{-- Tanggal Bayar --}}
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">
                                Tanggal Bayar
                            </label>
                            <input type="date" name="tanggal_bayar"
                                value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar) }}" class="w-full border border-amber-200/70 rounded-xl px-3 py-2 text-sm bg-[#FFFBF3]
                                              focus:outline-none focus:ring-2 focus:ring-[#FACC6B] focus:border-[#DA9A00]">
                            @error('tanggal_bayar')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">
                                Metode Pembayaran
                            </label>
                            <select name="metode_bayar"
                                class="w-full border border-amber-200/70 rounded-xl px-3 py-2 text-sm bg-white
                                               focus:outline-none focus:ring-2 focus:ring-[#FACC6B] focus:border-[#DA9A00]">
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

                        {{-- Bukti Transfer --}}
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">
                                Bukti Transfer (opsional)
                            </label>

                            @if ($pembayaran->bukti_transfer)
                                <div class="mb-2">
                                    <p class="text-[11px] text-slate-500 mb-1">Bukti sekarang:</p>
                                    <img src="{{ asset('uploads/' . $pembayaran->bukti_transfer) }}"
                                        class="max-h-48 rounded-xl border border-slate-200">
                                </div>
                            @endif

                            <input type="file" name="bukti_transfer" class="w-full text-xs sm:text-sm">
                            <p class="text-[11px] text-slate-400 mt-1">
                                Biarkan kosong kalau tidak ingin mengganti.
                            </p>

                            @error('bukti_transfer')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- BUTTONS --}}
                        <div class="flex flex-wrap gap-3 mt-4 justify-end">
                            <a href="{{ route('panelmua.pembayaran.index') }}"
                                class="px-4 py-2 rounded-2xl border text-xs sm:text-sm text-slate-600 hover:bg-slate-50">
                                Batal
                            </a>

                            <button type="submit"
                                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-semibold text-[#7A4600] shadow-sm hover:brightness-110 active:brightness-95 transition
                                               focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-300 focus-visible:ring-offset-2"
                                style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection