@extends('layouts.app')

@section('content')
    <main class="w-full px-5 sm:px-6 lg:px-10 py-8">

        {{-- FLASH SUCCESS --}}
        @if (session('success'))
            <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,3500)" x-transition.opacity
                class="mb-5 flex items-start gap-3 px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm shadow-sm">
                <div class="font-semibold">
                    {{ session('success') }}
                </div>
                <button @click="show=false" class="ml-auto text-xs font-semibold uppercase tracking-wide">Tutup</button>
            </div>
        @endif

        @if ($groupedPesanans->isEmpty())
            <div
                class="bg-white/95 rounded-3xl ring-1 ring-rose-50 shadow-sm px-6 sm:px-8 py-10 text-center text-sm text-slate-500">
                Belum ada pesanan untuk MUA ini.
            </div>
        @else
            {{-- KOTAK UTAMA --}}
            <div class="bg-white/95 rounded-3xl ring-1 ring-rose-50 shadow-sm overflow-hidden">

                {{-- HEADER --}}
                <div
                    class="px-6 sm:px-8 py-6 bg-gradient-to-r from-[#fff5f7] via-[#fff9fb] to-[#fffdfd] border-b border-rose-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-semibold tracking-[0.22em] text-rose-500 uppercase">MUA Panel</p>
                            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Pesanan Masuk</h1>
                        </div>
                        <span class="text-xs text-slate-500">
                            Total pesanan: {{ $groupedPesanans->count() }}
                        </span>
                    </div>
                    <div class="h-[3px] w-16 bg-gradient-to-r from-rose-500/80 to-orange-300/80 rounded-full mt-3"></div>
                </div>

                {{-- TABEL --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-rose-50/80 text-rose-700 text-[13px]">
                            <tr class="border-b border-rose-100">
                                <th class="px-5 py-3 text-left">#</th>
                                <th class="px-5 py-3 text-left">Tanggal Booking</th>
                                <th class="px-5 py-3 text-left">Pengguna</th>
                                <th class="px-5 py-3 text-left">Layanan</th>
                                <th class="px-5 py-3 text-left">Total</th>
                                <th class="px-5 py-3 text-left">Status Pembayaran</th>
                                <th class="px-5 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-rose-50 text-[13.5px]">
                            @foreach ($groupedPesanans as $group)
                                @php
                                    $first = $group->first(); // baris wakil

                                    // list nama layanan dalam 1 checkout
                                    $layananList = $group->map(function ($p) {
                                        return optional($p->layanan)->nama;
                                    })->filter()->values();

                                    // tampilkan semua nama layanan, dipisah koma
                                    $namaDisplay = $layananList->isNotEmpty()
                                        ? $layananList->implode(', ')
                                        : '-';

                                    // total harga semua layanan di checkout itu
                                    $totalGroup = $group->sum('total_harga');

                                    $status = $first->status_pembayaran;
                                @endphp

                                <tr class="hover:bg-rose-50/60 transition-colors">
                                    {{-- # pakai loop iteration, tanpa + --}}
                                    <td class="px-5 py-4 align-top text-slate-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Tanggal Booking (pakai pesanan pertama di grup) --}}
                                    <td class="px-5 py-4 align-top">
                                        {{ \Carbon\Carbon::parse($first->tanggal_booking)->translatedFormat('d M Y') }}
                                    </td>

                                    {{-- Pengguna --}}
                                    <td class="px-5 py-4 align-top">
                                        <div class="font-medium text-slate-900">
                                            {{ $first->pengguna->name ?? '—' }}
                                        </div>
                                        <div class="text-[11px] text-slate-500">
                                            {{ $first->alamat }}
                                        </div>
                                    </td>

                                    {{-- Layanan (semua nama dalam checkout ini) --}}
                                    <td class="px-5 py-4 align-top">
                                        {{ $namaDisplay }}
                                    </td>

                                    {{-- Total (semua layanan di checkout ini) --}}
                                    <td class="px-5 py-4 align-top font-semibold text-slate-900">
                                        Rp {{ number_format($totalGroup, 0, ',', '.') }}
                                    </td>

                                    {{-- Status Pembayaran (pakai status pesanan pertama) --}}
                                    <td class="px-5 py-4 align-top">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold
                                            @if ($status === 'Belum_Lunas')
                                                bg-yellow-50 text-yellow-700
                                            @elseif ($status === 'Lunas')
                                                bg-emerald-50 text-emerald-700
                                            @else
                                                bg-rose-50 text-rose-700
                                            @endif">
                                            {{ str_replace('_', ' ', $status) }}
                                        </span>
                                    </td>

                                    {{-- Aksi (pakai id pesanan pertama di grup) --}}
                                    <td class="px-5 py-4 align-top">
                                        <div class="flex flex-col gap-2">

                                            @if ($status === 'Lunas')
                                                <a href="{{ route('panelmua.pembayaran.create', $first->id) }}"
                                                   class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-[11px] font-medium
                                                          bg-emerald-50 text-emerald-600 hover:bg-emerald-100">
                                                    Input Pembayaran
                                                </a>
                                            @endif

                                            {{-- Update status --}}
                                            <form action="{{ route('panelmua.pesanan.updateStatus', $first->id) }}"
                                                  method="POST"
                                                  class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')

                                                <select name="status_pembayaran"
                                                        class="border border-slate-200 rounded-xl px-2 py-1 text-[11px] text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                                                    <option value="Belum_Lunas" @selected($status === 'Belum_Lunas')>
                                                        Belum Lunas
                                                    </option>
                                                    <option value="Lunas" @selected($status === 'Lunas')>
                                                        Lunas
                                                    </option>
                                                    <option value="Dibatalkan" @selected($status === 'Dibatalkan')>
                                                        Dibatalkan
                                                    </option>
                                                </select>

                                                <button type="submit"
                                                        class="px-3 py-1.5 text-[11px] rounded-xl bg-rose-600 text-white hover:bg-rose-700 font-semibold">
                                                    Update
                                                </button>
                                            </form>

                                            {{-- Hapus --}}
                                            <form action="{{ route('panelmua.pesanan.destroy', $first->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1.5 text-[11px] rounded-xl bg-red-50 text-red-600 hover:bg-red-100">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        @endif
    </main>
@endsection
