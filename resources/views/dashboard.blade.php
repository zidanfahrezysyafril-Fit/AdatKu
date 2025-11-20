@extends('layouts.app')

@section('content')
  @php
    $today = \Carbon\Carbon::now()->translatedFormat('d F Y');
  @endphp

  <div class="min-h-[calc(100vh-4rem)] bg-[#fff9f7]">
    <div class="max-w-6xl mx-auto px-4 md:px-8 py-6 space-y-6">

      {{-- HEADER / WELCOME --}}
      <div
        class="relative overflow-hidden rounded-3xl border border-rose-100 bg-gradient-to-r from-rose-50 via-amber-50/40 to-rose-50 px-6 py-5 md:px-8 md:py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        {{-- Ornamen blur --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-rose-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-10 -bottom-10 h-32 w-32 rounded-full bg-amber-200/40 blur-3xl">
        </div>

        <div class="relative">
          <p class="text-[10px] md:text-xs uppercase tracking-[0.2em] text-rose-400 mb-1">
            MUA Panel
          </p>
          <h1 class="text-2xl md:text-3xl font-semibold text-rose-700">
            Halo,
            <span class="text-rose-500">
              {{ auth()->user()->name ?? 'MUA' }}
            </span>
          </h1>
          <p class="text-xs md:text-sm text-slate-500 mt-2">
            Senang melihatmu kembali. Berikut ringkasan aktivitas MUA kamu hari ini.
          </p>

          <p
            class="mt-3 inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-1 text-[11px] text-slate-500 border border-rose-100">
            <span class="text-lg">📅</span>
            <span>Hari ini, {{ $today }}</span>
          </p>
        </div>

        <div class="relative flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
          <a href="{{ route('profile.show') }}"
            class="inline-flex items-center justify-center px-4 py-2 rounded-full border border-rose-200 bg-white/70 text-xs md:text-sm text-rose-600 hover:bg-rose-50 transition">
            Kelola Profil
          </a>
          <a href="{{ route('panelmua.layanan.create') }}"
            class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-rose-600 text-xs md:text-sm text-white shadow-sm hover:bg-rose-700 transition">
            + Tambah Layanan
          </a>
        </div>
      </div>

      {{-- ROW 1: RINGKASAN PESANAN + PENDAPATAN --}}
      <div class="grid gap-6 lg:grid-cols-3">
        {{-- Ringkasan Pesanan --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-rose-50 px-6 py-5">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h2 class="text-base font-semibold text-rose-700">Ringkasan Pesanan</h2>
              <p class="text-xs text-slate-500 mt-1">
                Gambaran cepat status pesanan yang masuk ke kamu.
              </p>
            </div>
            <a href="{{ route('panelmua.pesanan.index') }}" class="text-xs font-medium text-rose-500 hover:text-rose-600">
              Lihat semua pesanan &rarr;
            </a>
          </div>

          <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            {{-- Total Pesanan --}}
            <div
              class="group rounded-xl border border-rose-50 bg-rose-50/70 px-4 py-3 flex items-center justify-between gap-3 hover:shadow-md hover:-translate-y-0.5 transition">
              <div>
                <p class="text-[11px] text-rose-500 mb-1">Total Pesanan</p>
                <p class="text-2xl font-semibold text-rose-700">
                  {{ $totalPesanan ?? 0 }}
                </p>
                <p class="text-[11px] text-slate-400 mt-1">
                  Semua status pesanan
                </p>
              </div>
              <span class="text-2xl">📦</span>
            </div>

            {{-- Pending --}}
            <div
              class="group rounded-xl border border-amber-100 bg-amber-50/70 px-4 py-3 flex items-center justify-between gap-3 hover:shadow-md hover:-translate-y-0.5 transition">
              <div>
                <p class="text-[11px] text-amber-600 mb-1">Pending</p>
                <p class="text-2xl font-semibold text-amber-700">
                  {{ $totalPending ?? 0 }}
                </p>
                <p class="text-[11px] text-slate-400 mt-1">
                  Menunggu konfirmasi / pembayaran
                </p>
              </div>
              <span class="text-2xl">⏳</span>
            </div>

            {{-- Proses --}}
            <div
              class="group rounded-xl border border-sky-100 bg-sky-50/70 px-4 py-3 flex items-center justify-between gap-3 hover:shadow-md hover:-translate-y-0.5 transition">
              <div>
                <p class="text-[11px] text-sky-600 mb-1">Proses</p>
                <p class="text-2xl font-semibold text-sky-600">
                  {{ $totalProses ?? 0 }}
                </p>
                <p class="text-[11px] text-slate-400 mt-1">
                  Sedang dikerjakan / hari-H
                </p>
              </div>
              <span class="text-2xl">🎨</span>
            </div>

            {{-- Lunas --}}
            <div
              class="group rounded-xl border border-emerald-100 bg-emerald-50/70 px-4 py-3 flex items-center justify-between gap-3 hover:shadow-md hover:-translate-y-0.5 transition">
              <div>
                <p class="text-[11px] text-emerald-600 mb-1">Lunas</p>
                <p class="text-2xl font-semibold text-emerald-600">
                  {{ $totallunas ?? 0 }}
                </p>
                <p class="text-[11px] text-slate-400 mt-1">
                  Pesanan selesai & terbayar
                </p>
              </div>
              <span class="text-2xl">✅</span>
            </div>
          </div>
        </div>

        {{-- Pendapatan Bulan Ini --}}
        <div class="space-y-4">
          <div class="bg-white rounded-2xl shadow-sm border border-rose-50 px-6 py-5 h-full flex flex-col">
            <div class="flex items-center justify-between mb-3">
              <div>
                <p class="text-[11px] uppercase tracking-[0.16em] text-emerald-500">Pendapatan</p>
                <h2 class="text-base font-semibold text-slate-800">Bulan Ini</h2>
              </div>
              <span
                class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[11px] text-emerald-600 border border-emerald-100">
                💰 Stabil
              </span>
            </div>

            <p class="text-3xl font-semibold text-emerald-600">
              Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}
            </p>
            <p class="mt-2 text-[11px] text-slate-400">
              Total pendapatan dari pesanan yang sudah lunas bulan ini.
            </p>

            <div class="mt-4 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
              <div class="h-full w-2/3 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-500"></div>
            </div>
          </div>
        </div>
      </div>

      {{-- ROW 2: PESANAN TERBARU --}}
      <div class="bg-white rounded-2xl shadow-sm border border-rose-50 px-6 py-5">
        <div class="flex items-center justify-between mb-3">
          <h2 class="text-base font-semibold text-rose-700">Pesanan Terbaru</h2>
          @if(!($pesananTerbaru ?? collect())->isEmpty())
            <a href="{{ route('panelmua.pesanan.index') }}" class="text-xs font-medium text-rose-500 hover:text-rose-600">
              Lihat semua &rarr;
            </a>
          @endif
        </div>

        @if(($pesananTerbaru ?? collect())->isEmpty())
          <div class="flex flex-col items-center justify-center gap-1 py-8 text-center">
            <div class="text-3xl mb-2">💆‍♀️</div>
            <p class="text-sm font-medium text-slate-700">
              Belum ada pesanan terbaru.
            </p>
            <p class="text-xs text-slate-400 mt-1">
              Saat ada pesanan baru, detailnya akan muncul di sini.
            </p>
          </div>
        @else
          <div class="space-y-3">
            @foreach($pesananTerbaru as $pesanan)
              <div class="border border-slate-100 rounded-xl px-3 py-2.5 hover:bg-rose-50/40 transition">
                <div class="flex items-center justify-between">
                  <p class="text-xs text-slate-400">
                    {{ \Carbon\Carbon::parse($pesanan->tanggal_booking)->format('d M Y') }}
                  </p>
                  <span
                    class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-0.5 text-[11px] text-slate-500 border border-slate-100">
                    {{ ucfirst($pesanan->status ?? 'pending') }}
                  </span>
                </div>
                <p class="text-sm font-medium text-slate-800 mt-1">
                  {{ $pesanan->pengguna->name ?? 'Pengguna' }}
                </p>
                <div class="mt-1 flex items-center justify-between text-xs text-slate-500">
                  <span>{{ $pesanan->layanan->nama ?? '-' }}</span>
                  <span class="font-semibold text-emerald-600">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                  </span>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

    </div>
  </div>
@endsection