@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
    <main class="w-full px-4 sm:px-6 lg:px-10 py-6 sm:py-8">
        <div class="max-w-3xl mx-auto">

            {{-- Notif sukses (gold) --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-3 rounded-2xl bg-[#FFF8E0] border border-[#FACC6B] text-[#8A4B00] text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white/95 rounded-3xl ring-1 ring-[#FACC6B]/40 shadow-sm overflow-hidden">
                {{-- HEADER --}}
                <div
                    class="px-5 sm:px-7 py-5 bg-gradient-to-r from-[#fff7f9] via-[#fff8ef] to-[#fffaf3] border-b border-rose-50">
                    <p class="text-[10px] sm:text-[11px] font-semibold tracking-[0.22em] text-amber-500 uppercase">
                        MUA Panel
                    </p>
                    <h1 class="text-xl sm:text-2xl font-bold mt-1" style="color:#C98A00;">
                        Detail Pembayaran
                    </h1>
                </div>

                {{-- BODY --}}
                <div class="px-5 sm:px-7 py-5 sm:py-6 space-y-5">
                    <h2 class="text-sm sm:text-base font-semibold text-slate-800">
                        Pesanan: {{ $pembayaran->pesanan->layanan->nama ?? '-' }}
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm">
                        <div>
                            <p class="text-slate-500">Tanggal Booking</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($pembayaran->pesanan->tanggal_booking)->translatedFormat('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">Nama Pengguna</p>
                            <p class="font-semibold">
                                {{ $pembayaran->pesanan->pengguna->name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">Tanggal Bayar</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">Metode Pembayaran</p>
                            <p class="font-semibold">
                                {{ str_replace('_', ' ', $pembayaran->metode_bayar) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">Total</p>
                            <p class="font-semibold text-amber-600">
                                Rp {{ number_format($pembayaran->pesanan->total_harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">Alamat</p>
                            <p class="font-semibold">
                                {{ $pembayaran->pesanan->alamat }}
                            </p>
                        </div>
                    </div>

                    {{-- Bukti transfer --}}
                    <div class="mt-3">
                        <p class="text-slate-500 mb-2 text-xs sm:text-sm">Bukti Transfer</p>
                        @if ($pembayaran->bukti_transfer)
                            <img src="{{ asset($pembayaran->bukti_transfer) }}" alt="Bukti Transfer"
                                class="rounded-xl border border-slate-200 max-h-80 w-full object-contain">
                        @else
                            <p class="text-[11px] sm:text-xs text-slate-400">
                                Belum ada bukti transfer yang diunggah.
                            </p>
                        @endif
                    </div>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('panelmua.pembayaran.index') }}"
                            class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 text-xs sm:text-sm hover:bg-slate-50">
                            ← Kembali ke daftar pembayaran
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection