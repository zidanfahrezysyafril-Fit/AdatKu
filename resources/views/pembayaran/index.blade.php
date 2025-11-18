@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex">
        {{-- MAIN CONTENT --}}
        <main class="flex-1 bg-[#fff9f7]">
            {{-- BODY --}}
            <section class="px-8 py-8">

                {{-- Flash message --}}
                @if (session('success'))
                    <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow border border-rose-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-rose-50 flex items-center justify-between">
                        <h2 class="text-base font-semibold text-rose-700">Daftar Pembayaran</h2>
                        <p class="text-xs text-slate-400">
                            Total data: {{ $pembayaran->count() }}
                        </p>
                    </div>

                    @if ($pembayaran->isEmpty())
                        <div class="px-6 py-10 text-center text-sm text-slate-500">
                            Belum ada data pembayaran yang tercatat.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-rose-50 text-slate-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left">#</th>
                                        <th class="px-4 py-3 text-left">Tgl Bayar</th>
                                        <th class="px-4 py-3 text-left">Pesanan</th>
                                        <th class="px-4 py-3 text-left">Pengguna</th>
                                        <th class="px-4 py-3 text-left">Layanan</th>
                                        <th class="px-4 py-3 text-left">Metode</th>
                                        <th class="px-4 py-3 text-right">Total</th>
                                        <th class="px-4 py-3 text-center">Bukti</th>
                                        <th class="px-4 py-3 text-center">Status Pesanan</th>
                                        <th class="px-4 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-rose-50">
                                    @foreach ($pembayaran as $index => $bayar)
                                        @php
                                            $pesanan = $bayar->pesanan;
                                            $userPesan = $pesanan?->pengguna;
                                            $layanan = $pesanan?->layanan;
                                        @endphp

                                        <tr class="hover:bg-rose-50/60">
                                            {{-- # --}}
                                            <td class="px-4 py-3 align-top text-slate-500">
                                                {{ $index + 1 }}
                                            </td>

                                            {{-- Tgl Bayar --}}
                                            <td class="px-4 py-3 align-top">
                                                {{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}
                                            </td>

                                            {{-- Pesanan --}}
                                            <td class="px-4 py-3 align-top">
                                                <span class="text-xs text-slate-500">ID:</span>
                                                <span class="font-medium text-slate-700">
                                                    {{ $pesanan->id ?? '-' }}
                                                </span><br>
                                                <span class="text-xs text-slate-500">
                                                    Booking:
                                                    {{ $pesanan ? \Carbon\Carbon::parse($pesanan->tanggal_booking)->format('d M Y') : '-' }}
                                                </span>
                                            </td>

                                            {{-- Pengguna --}}
                                            <td class="px-4 py-3 align-top">
                                                <div class="font-medium text-slate-800">
                                                    {{ $userPesan->name ?? '-' }}
                                                </div>
                                                <div class="text-xs text-slate-500">
                                                    {{ $userPesan->email ?? '' }}
                                                </div>
                                            </td>

                                            {{-- Layanan --}}
                                            <td class="px-4 py-3 align-top">
                                                {{ $layanan->nama ?? '-' }}
                                            </td>

                                            {{-- Metode --}}
                                            <td class="px-4 py-3 align-top">
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

                                            {{-- Total --}}
                                            <td class="px-4 py-3 align-top text-right font-semibold text-amber-600">
                                                @if ($pesanan)
                                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            {{-- Bukti --}}
                                            <td class="px-4 py-3 align-top text-center">
                                                @if ($bayar->bukti_transfer)
                                                    <a href="{{ asset('storage/' . $bayar->bukti_transfer) }}" target="_blank" class="inline-flex items-center px-3 py-1 rounded-full text-xs
                                                                              bg-slate-100 text-slate-700 hover:bg-slate-200">
                                                        Lihat Bukti
                                                    </a>
                                                @else
                                                    <span class="text-xs text-slate-400">Tidak ada</span>
                                                @endif
                                            </td>

                                            {{-- Status Pesanan --}}
                                            <td class="px-4 py-3 align-top text-center">
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

                                            {{-- Aksi --}}
                                            <td class="px-4 py-3 align-top text-center">
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
                    @endif
                </div>
            </section>
        </main>
    </div>
@endsection