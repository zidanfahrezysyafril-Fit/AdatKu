@extends('layouts.app')

@section('content')
    <div class="px-8 py-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-rose-700 mb-4">Detail Pembayaran</h1>

        {{-- Notif sukses --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow border border-rose-100 p-6 space-y-4">
            <h2 class="text-lg font-semibold text-slate-800 mb-2">
                Pesanan: {{ $pembayaran->pesanan->layanan->nama ?? '-' }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
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
            <div class="mt-4">
                <p class="text-slate-500 mb-2">Bukti Transfer</p>
                @if ($pembayaran->bukti_transfer)
                    <img src="{{ asset('storage/' . $pembayaran->bukti_transfer) }}"
                         alt="Bukti Transfer"
                         class="rounded-xl border border-slate-200 max-h-80">
                @else
                    <p class="text-xs text-slate-400">Belum ada bukti transfer yang diunggah.</p>
                @endif
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('panelmua.pembayaran.index') }}"
                   class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 text-sm hover:bg-slate-50">
                    ← Kembali ke daftar pembayaran
                </a>
            </div>
        </div>
    </div>
@endsection
