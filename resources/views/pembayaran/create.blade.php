@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
    <main class="w-full px-4 sm:px-6 lg:px-10 py-6 sm:py-8">
        <div class="max-w-xl mx-auto">

            <div class="bg-white/95 rounded-3xl ring-1 ring-[#FACC6B]/40 shadow-sm overflow-hidden">
                {{-- HEADER --}}
                <div
                    class="px-5 sm:px-7 py-5 bg-gradient-to-r from-[#fff7f9] via-[#fff8ef] to-[#fffaf3] border-b border-rose-50">
                    <p class="text-[10px] sm:text-[11px] font-semibold tracking-[0.22em] text-amber-500 uppercase">
                        MUA Panel
                    </p>
                    <h1 class="text-xl sm:text-2xl font-bold mt-1" style="color:#C98A00;">
                        Konfirmasi Pembayaran Pesanan
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Cek detail pesanan sebelum menyimpan data pembayaran.
                    </p>
                    <div class="h-[3px] w-14 sm:w-16 bg-gradient-to-r from-amber-300/90 via-amber-400/90 to-rose-300/80 rounded-full mt-3">
                    </div>
                </div>

                {{-- BODY --}}
                <div class="px-5 sm:px-7 py-5 sm:py-6 space-y-5">
                    {{-- Info pesanan --}}
                    <div class="rounded-2xl border border-[#FACC6B]/40 bg-[#FFF8E8] px-4 py-3 text-sm">
                        <p class="text-slate-500 text-[11px] sm:text-xs">Layanan</p>
                        <p class="font-semibold text-slate-800 text-sm sm:text-base">
                            {{ $pesanan->layanan->nama ?? '-' }}
                        </p>

                        <p class="text-[11px] sm:text-xs text-slate-500 mt-1">
                            Tanggal Booking:
                            <span class="font-medium text-slate-700">
                                {{ \Carbon\Carbon::parse($pesanan->tanggal_booking)->format('d M Y') }}
                            </span>
                        </p>

                        <p class="text-[11px] sm:text-xs text-slate-500 mt-1">
                            Total:
                            <span class="font-bold text-amber-600 text-sm sm:text-base">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </span>
                        </p>
                    </div>

                    <form action="{{ route('panelmua.pembayaran.store', $pesanan->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        {{-- Tanggal Bayar --}}
                        <div>
                            <label class="block text-xs sm:text-sm font-medium mb-1 text-slate-700">
                                Tanggal Bayar
                            </label>
                            <input type="date" name="tanggal_bayar"
                                value="{{ old('tanggal_bayar', now()->toDateString()) }}" class="w-full rounded-xl border border-amber-200/70 px-3 py-2 text-sm bg-[#FFFBF3]
                                              focus:ring-2 focus:ring-[#FACC6B] focus:border-[#DA9A00] outline-none">
                            @error('tanggal_bayar')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div>
                            <label class="block text-xs sm:text-sm font-medium mb-1 text-slate-700">
                                Metode Pembayaran
                            </label>
                            <select name="metode_bayar"
                                class="w-full rounded-xl border border-amber-200/70 px-3 py-2 text-sm bg-white
                                               focus:ring-2 focus:ring-[#FACC6B] focus:border-[#DA9A00] outline-none">
                                <option value="">-- Pilih Metode --</option>
                                <option value="Transfer_Bank" {{ old('metode_bayar') == 'Transfer_Bank' ? 'selected' : '' }}>
                                    Transfer Bank
                                </option>
                                <option value="E_Wallet" {{ old('metode_bayar') == 'E_Wallet' ? 'selected' : '' }}>
                                    E-Wallet
                                </option>
                                <option value="COD" {{ old('metode_bayar') == 'COD' ? 'selected' : '' }}>
                                    COD
                                </option>
                            </select>
                            @error('metode_bayar')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-[11px] text-slate-500 mt-1">
                                Bukti transfer boleh dikosongkan jika metode COD.
                            </p>
                        </div>

                        {{-- Bukti Transfer --}}
                        <div>
                            <label class="block text-xs sm:text-sm font-medium mb-1 text-slate-700">
                                Bukti Transfer (jpg / png, max 2MB)
                            </label>
                            <input type="file" name="bukti_transfer" class="block w-full text-xs sm:text-sm text-slate-700
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0
                                              file:text-xs sm:file:text-sm file:font-semibold
                                              file:bg-amber-50 file:text-amber-700
                                              hover:file:bg-amber-100">
                            @error('bukti_transfer')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex flex-wrap items-center justify-end gap-3 pt-2">
                            <a href="{{ route('panelmua.pesanan.index') }}"
                                class="px-4 py-2 rounded-2xl text-xs sm:text-sm border border-slate-200 text-slate-600 hover:bg-slate-50">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-5 sm:px-6 py-2.5 rounded-2xl text-xs sm:text-sm font-semibold text-[#7A4600]
                                               shadow-md hover:brightness-110 active:brightness-95 transition
                                               focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-300 focus-visible:ring-offset-2"
                                style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
                                Simpan Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
