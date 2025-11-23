@extends('layouts.app')

@section('title', 'Daftar Pembayaran')

@section('content')
    <main class="w-full px-4 sm:px-6 lg:px-10 py-6 sm:py-8">
        <div class="max-w-6xl mx-auto">

            {{-- FLASH MESSAGE --}}
            @if (session('success') || session('error'))
                <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)" x-transition.opacity
                     class="mb-5 flex items-start gap-3 px-4 py-3 rounded-2xl border text-sm shadow-sm
                         @if(session('success')) bg-emerald-50 border-emerald-200 text-emerald-800
                         @else bg-red-50 border-red-200 text-red-700 @endif">
                    <div class="font-semibold">
                        {{ session('success') ?? session('error') }}
                    </div>
                    <button @click="show=false" class="ml-auto text-xs font-semibold uppercase tracking-wide">Tutup</button>
                </div>
            @endif

            {{-- KOTAK UTAMA --}}
            <div class="bg-white/95 rounded-3xl ring-1 ring-rose-50 shadow-sm overflow-hidden">

                {{-- HEADER --}}
                <div
                    class="px-5 sm:px-8 py-5 sm:py-6 bg-gradient-to-r from-[#fff5f7] via-[#fff9fb] to-[#fffdfd] border-b border-rose-50">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <p class="text-[10px] sm:text-[11px] font-semibold tracking-[0.22em] text-rose-500 uppercase">
                                MUA Panel
                            </p>
                            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-900 mt-1">
                                Daftar Pembayaran
                            </h2>
                        </div>
                        <span class="text-[11px] sm:text-xs text-slate-500">
                            Total data: {{ $pembayaran->count() }}
                        </span>
                    </div>
                    <div class="h-[3px] w-14 sm:w-16 bg-gradient-to-r from-rose-500/80 to-orange-300/80 rounded-full mt-3"></div>
                </div>

                @if ($pembayaran->isEmpty())
                    {{-- EMPTY STATE --}}
                    <div class="px-6 sm:px-8 py-10 text-center text-sm text-slate-500">
                        Belum ada data pembayaran yang tercatat.
                    </div>
                @else
                    {{-- ========= TABEL (≥ SM) ========= --}}
                    <div class="hidden sm:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-rose-50/70 text-slate-600 text-[13px]">
                                <tr class="border-b border-rose-100">
                                    <th class="px-5 py-3 text-left">#</th>
                                    <th class="px-5 py-3 text-left">Tgl Bayar</th>
                                    <th class="px-5 py-3 text-left">Pesanan</th>
                                    <th class="px-5 py-3 text-left">Pengguna</th>
                                    <th class="px-5 py-3 text-left">Layanan</th>
                                    <th class="px-5 py-3 text-left">Metode</th>
                                    <th class="px-5 py-3 text-right">Total</th>
                                    <th class="px-5 py-3 text-center">Bukti</th>
                                    <th class="px-5 py-3 text-center">Status</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                                </thead>

                                <tbody class="divide-y divide-rose-50 text-[13.5px]">
                                @foreach ($pembayaran as $index => $bayar)
                                    @php
                                        $pesanan   = $bayar->pesanan;
                                        $userPesan = $pesanan?->pengguna;
                                        $layanan   = $pesanan?->layanan;
                                    @endphp

                                    <tr class="hover:bg-rose-50/50 transition-colors">
                                        <td class="px-5 py-4 align-top text-slate-500">
                                            {{ $index + 1 }}
                                        </td>

                                        <td class="px-5 py-4 align-top whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}
                                        </td>

                                        <td class="px-5 py-4 align-top leading-tight">
                                            <div>
                                                <span class="text-xs text-slate-500">ID:</span>
                                                <span class="font-medium text-slate-700">{{ $pesanan->id ?? '-' }}</span>
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                Booking:
                                                {{ $pesanan ? \Carbon\Carbon::parse($pesanan->tanggal_booking)->format('d M Y') : '-' }}
                                            </div>
                                        </td>

                                        <td class="px-5 py-4 align-top leading-tight">
                                            <div class="font-medium text-slate-800">
                                                {{ $userPesan->name ?? '-' }}
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                {{ $userPesan->email ?? '' }}
                                            </div>
                                        </td>

                                        <td class="px-5 py-4 align-top">
                                            {{ $layanan->nama ?? '-' }}
                                        </td>

                                        <td class="px-5 py-4 align-top">
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                                @if ($bayar->metode_bayar === 'COD')
                                                    bg-amber-50 text-amber-700
                                                @elseif ($bayar->metode_bayar === 'E_Wallet')
                                                    bg-sky-50 text-sky-700
                                                @else
                                                    bg-emerald-50 text-emerald-700
                                                @endif">
                                                {{ str_replace('_', ' ', $bayar->metode_bayar) }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4 align-top text-right font-semibold text-amber-600 whitespace-nowrap">
                                            @if ($pesanan)
                                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="px-5 py-4 align-top text-center">
                                            @if ($bayar->bukti_transfer)
                                                <a href="{{ asset('storage/' . $bayar->bukti_transfer) }}" target="_blank"
                                                   class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-slate-100 text-slate-700 hover:bg-slate-200">
                                                    Lihat Bukti
                                                </a>
                                            @else
                                                <span class="text-xs text-slate-400">Tidak ada</span>
                                            @endif
                                        </td>

                                        <td class="px-5 py-4 align-top text-center">
                                            @if ($pesanan)
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                                    @if ($pesanan->status_pembayaran === 'Lunas')
                                                        bg-emerald-50 text-emerald-700
                                                    @elseif ($pesanan->status_pembayaran === 'Belum_Lunas')
                                                        bg-red-50 text-red-600
                                                    @else
                                                        bg-slate-100 text-slate-600
                                                    @endif">
                                                    {{ str_replace('_', ' ', $pesanan->status_pembayaran) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-slate-400">-</span>
                                            @endif
                                        </td>

                                        <td class="px-5 py-4 align-top text-center">
                                            <div class="inline-flex gap-2">
                                                <a href="{{ route('panelmua.pembayaran.show', $bayar->id) }}"
                                                   class="px-3 py-1.5 rounded-full text-xs bg-slate-50 text-slate-700 hover:bg-slate-100">
                                                    Detail
                                                </a>

                                                <a href="{{ route('panelmua.pembayaran.edit', $bayar->id) }}"
                                                   class="px-3 py-1.5 rounded-full text-xs bg-amber-50 text-amber-700 hover:bg-amber-100">
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ========= CARD LIST (MOBILE < SM) ========= --}}
                    <div class="sm:hidden px-4 py-4 space-y-3">
                        @foreach ($pembayaran as $index => $bayar)
                            @php
                                $pesanan   = $bayar->pesanan;
                                $userPesan = $pesanan?->pengguna;
                                $layanan   = $pesanan?->layanan;
                            @endphp

                            <div class="border border-rose-100 rounded-2xl bg-white/90 p-4 space-y-3 shadow-sm">
                                {{-- Top: No / Tgl bayar --}}
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[11px] text-slate-400">#{{ $index + 1 }}</span>
                                    <span class="text-xs text-slate-600">
                                        {{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}
                                    </span>
                                </div>

                                {{-- User + layanan --}}
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $userPesan->name ?? '-' }}
                                    </p>
                                    <p class="text-[11px] text-slate-500">
                                        {{ $layanan->nama ?? '-' }}
                                    </p>
                                </div>

                                {{-- Metode + Total --}}
                                <div class="flex items-center justify-between text-xs">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold
                                        @if ($bayar->metode_bayar === 'COD')
                                            bg-amber-50 text-amber-700
                                        @elseif ($bayar->metode_bayar === 'E_Wallet')
                                            bg-sky-50 text-sky-700
                                        @else
                                            bg-emerald-50 text-emerald-700
                                        @endif">
                                        {{ str_replace('_', ' ', $bayar->metode_bayar) }}
                                    </span>
                                    <span class="text-sm font-semibold text-amber-600">
                                        @if ($pesanan)
                                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>

                                {{-- Status --}}
                                <div class="text-xs">
                                    <span class="text-slate-500">Status: </span>
                                    @if ($pesanan)
                                        <span class="font-semibold
                                            @if ($pesanan->status_pembayaran === 'Lunas') text-emerald-600
                                            @elseif ($pesanan->status_pembayaran === 'Belum_Lunas') text-red-600
                                            @else text-slate-600 @endif">
                                            {{ str_replace('_', ' ', $pesanan->status_pembayaran) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </div>

                                {{-- Bukti --}}
                                <div class="text-xs">
                                    <span class="text-slate-500">Bukti: </span>
                                    @if ($bayar->bukti_transfer)
                                        <a href="{{ asset('storage/' . $bayar->bukti_transfer) }}" target="_blank"
                                           class="font-semibold text-rose-600 hover:underline">
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-slate-400">Tidak ada</span>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="pt-2 flex flex-wrap gap-2">
                                    <a href="{{ route('panelmua.pembayaran.show', $bayar->id) }}"
                                       class="flex-1 min-w-[120px] inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-[11px] bg-slate-50 text-slate-700 hover:bg-slate-100">
                                        Detail
                                    </a>

                                    <a href="{{ route('panelmua.pembayaran.edit', $bayar->id) }}"
                                       class="flex-1 min-w-[120px] inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-[11px] bg-amber-50 text-amber-700 hover:bg-amber-100">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </main>
@endsection
