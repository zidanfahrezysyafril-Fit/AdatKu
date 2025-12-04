@extends('layouts.app')

@section('content')
  @php
    use Carbon\Carbon;
    $today = Carbon::now()->translatedFormat('d F Y');

    $totalPesanan  = $totalPesanan  ?? 0;
    $totalPending  = $totalPending  ?? 0;
    $totalLunas    = $totallunas    ?? 0;
    $pendapatanBulanIni = $pendapatanBulanIni ?? 0;
  @endphp

  <div class="min-h-[calc(100vh-4rem)] bg-transparent">
    <div class="max-w-6xl mx-auto px-4 md:px-8 py-6 space-y-6">

      {{-- HEADER / WELCOME --}}
      <div
        class="relative overflow-hidden rounded-3xl border border-rose-100 bg-gradient-to-r from-[#fff3f5] via-[#fff8ef] to-[#fff4fa]
               px-4 py-5 sm:px-6 sm:py-5 md:px-8 md:py-6
               flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-6">

        {{-- ornamen blur --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-rose-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-10 -bottom-10 h-32 w-32 rounded-full bg-amber-200/40 blur-3xl"></div>

        {{-- teks kiri --}}
        <div class="relative space-y-2">
          <p class="text-[10px] sm:text-xs uppercase tracking-[0.2em] adat-gold">
            MUA Panel
          </p>

          <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold adat-title leading-snug">
            Halo,
            <span class="adat-gold">
              {{ auth()->user()->name ?? 'MUA' }}
            </span>
          </h1>

          <p class="text-xs sm:text-sm adat-text mt-1.5">
            Senang melihatmu kembali. Berikut ringkasan aktivitas MUA kamu hari ini.
          </p>

          <p
            class="mt-3 inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-1 text-[11px] border border-rose-100 adat-text">
            <span class="text-lg">📅</span>
            <span>Hari ini, {{ $today }}</span>
          </p>
        </div>

        {{-- tombol kanan --}}
        <div class="relative flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 w-full md:w-auto">
          <a href="{{ route('profile.show') }}"
             class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 rounded-full border border-[#f5c86b]
                    bg-white/80 text-xs md:text-sm hover:bg-amber-50 transition adat-gold text-center">
            Kelola Profil
          </a>
          <a href="{{ route('panelmua.layanan.create') }}"
             class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 rounded-full border border-[#f5c86b]
                    bg-white/80 text-xs md:text-sm hover:bg-amber-50 transition adat-gold text-center">
            + Tambah Layanan
          </a>
        </div>
      </div>

      {{-- ROW 1: RINGKASAN PESANAN + PENDAPATAN --}}
      <div class="grid gap-6 lg:grid-cols-3">

        {{-- RINGKASAN PESANAN --}}
        <div
          class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-rose-50 px-4 sm:px-5 md:px-6 py-4 sm:py-5">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
            <div>
              <h2 class="text-sm sm:text-base font-semibold adat-gold">Ringkasan Pesanan</h2>
              <p class="text-xs adat-text mt-1">
                Gambaran cepat status pesanan yang masuk ke kamu.
              </p>
            </div>
            <a href="{{ route('panelmua.pesanan.index') }}"
               class="text-xs font-medium hover:underline adat-gold">
              Lihat semua pesanan &rarr;
            </a>
          </div>

          <div class="grid gap-4 sm:grid-cols-3">

            {{-- Total Pesanan --}}
            <div
              class="stat-card group relative flex flex-col justify-between rounded-2xl border border-rose-100
                     bg-rose-50/70 px-4 py-3 sm:px-4 sm:py-4 shadow-[0_10px_30px_rgba(244,114,182,0.08)]
                     hover:shadow-[0_14px_40px_rgba(244,114,182,0.16)] hover:-translate-y-0.5 transition">
              {{-- badge icon --}}
              <div class="absolute right-3 top-3">
                <div class="h-9 w-9 rounded-xl bg-white/80 border border-rose-100 flex items-center justify-center text-xl">
                  📦
                </div>
              </div>

              <div class="space-y-1.5 pr-12">
                <p class="text-[11px] font-semibold adat-title">Total Pesanan</p>
                <p class="text-2xl font-semibold adat-title">
                  {{ $totalPesanan }}
                </p>
                <p class="text-[11px] adat-text">
                  Semua pesanan dari berbagai status.
                </p>
              </div>

              {{-- progress bar dekor --}}
              <div class="mt-4 h-1.5 w-full rounded-full bg-white/60 overflow-hidden">
                <div class="h-full w-3/4 rounded-full bg-gradient-to-r from-rose-300 to-rose-400"></div>
              </div>
            </div>

            {{-- Pending --}}
            <div
              class="stat-card group relative flex flex-col justify-between rounded-2xl border border-amber-100
                     bg-amber-50/80 px-4 py-3 sm:px-4 sm:py-4 shadow-[0_10px_30px_rgba(251,191,36,0.08)]
                     hover:shadow-[0_14px_40px_rgba(251,191,36,0.18)] hover:-translate-y-0.5 transition">
              <div class="absolute right-3 top-3">
                <div class="h-9 w-9 rounded-xl bg-white/80 border border-amber-100 flex items-center justify-center text-xl">
                  ⏳
                </div>
              </div>

              <div class="space-y-1.5 pr-12">
                <p class="text-[11px] font-semibold adat-gold">Pending</p>
                <p class="text-2xl font-semibold adat-gold">
                  {{ $totalPending }}
                </p>
                <p class="text-[11px] adat-text">
                  Menunggu konfirmasi &amp; pembayaran dari pelanggan.
                </p>
              </div>

              <div class="mt-4 h-1.5 w-full rounded-full bg-white/60 overflow-hidden">
                <div class="h-full w-2/3 rounded-full bg-gradient-to-r from-amber-300 to-amber-400"></div>
              </div>
            </div>

            {{-- Lunas --}}
            <div
              class="stat-card group relative flex flex-col justify-between rounded-2xl border border-emerald-100
                     bg-emerald-50/80 px-4 py-3 sm:px-4 sm:py-4 shadow-[0_10px_30px_rgba(16,185,129,0.08)]
                     hover:shadow-[0_14px_40px_rgba(16,185,129,0.18)] hover:-translate-y-0.5 transition">
              <div class="absolute right-3 top-3">
                <div class="h-9 w-9 rounded-xl bg-white/80 border border-emerald-100 flex items-center justify-center text-xl">
                  ✅
                </div>
              </div>

              <div class="space-y-1.5 pr-12">
                <p class="text-[11px] font-semibold adat-jade">Lunas</p>
                <p class="text-2xl font-semibold adat-jade">
                  {{ $totalLunas }}
                </p>
                <p class="text-[11px] adat-text">
                  Pesanan yang sudah selesai dan terbayar.
                </p>
              </div>

              <div class="mt-4 h-1.5 w-full rounded-full bg-white/60 overflow-hidden">
                <div class="h-full w-4/5 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-500"></div>
              </div>
            </div>
          </div>
        </div>

        {{-- PENDAPATAN BULAN INI --}}
        <div class="space-y-4">
          <div
            class="bg-white rounded-2xl shadow-sm border border-rose-50 px-4 sm:px-5 md:px-6 py-4 sm:py-5 h-full flex flex-col">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
              <div>
                <p class="text-[11px] uppercase tracking-[0.16em] adat-gold">Pendapatan</p>
                <h2 class="text-sm sm:text-base font-semibold adat-title">
                  Bulan ini
                </h2>
              </div>
              <span
                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-[11px] border border-emerald-100 adat-jade">
                💰 <span>Stabil</span>
              </span>
            </div>

            <p class="text-2xl sm:text-3xl font-semibold adat-jade">
              Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
            </p>
            <p class="mt-2 text-[11px] adat-text">
              Total pendapatan dari pesanan yang sudah berstatus lunas bulan ini.
            </p>

            <div class="mt-4 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
              <div class="h-full w-2/3 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-500"></div>
            </div>
          </div>
        </div>
      </div>

      {{-- ROW 2: PESANAN TERBARU --}}
      <div class="bg-white rounded-2xl shadow-sm border border-rose-50 px-4 sm:px-5 md:px-6 py-4 sm:py-5 stat-card">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
          <h2 class="text-sm sm:text-base font-semibold adat-gold">Pesanan Terbaru</h2>
          @if(!($pesananTerbaru ?? collect())->isEmpty())
            <a href="{{ route('panelmua.pesanan.index') }}" class="text-xs font-medium hover:underline adat-gold">
              Lihat semua &rarr;
            </a>
          @endif
        </div>

        @if(($pesananTerbaru ?? collect())->isEmpty())
          {{-- STATE KOSONG – versi cantik --}}
          <div class="relative py-8 sm:py-10 px-3 sm:px-4 text-center overflow-hidden">
            {{-- ornamen blur halus --}}
            <div class="pointer-events-none absolute -right-10 -top-6 h-24 w-24 rounded-full bg-rose-200/40 blur-2xl"></div>
            <div class="pointer-events-none absolute -left-10 -bottom-6 h-24 w-24 rounded-full bg-amber-200/40 blur-2xl"></div>

            <div class="relative">
              <div class="text-4xl mb-3">💆‍♀️</div>
              <p class="text-sm font-semibold adat-title">
                Belum ada pesanan terbaru.
              </p>
              <p class="text-xs mt-2 adat-text">
                Saat ada pesanan baru, detailnya akan muncul di sini.
              </p>
            </div>
          </div>
        @else
          <div class="space-y-3">
            @foreach($pesananTerbaru as $pesanan)
              <div class="border border-slate-100 rounded-xl px-3 py-2.5 hover:bg-rose-50/40 transition">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                  <p class="text-xs adat-text">
                    {{ Carbon::parse($pesanan->tanggal_booking)->format('d M Y') }}
                  </p>
                  <span
                    class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-0.5 text-[11px] border border-slate-100 adat-text self-start sm:self-auto">
                    {{ ucfirst(str_replace('_', ' ', $pesanan->status_pembayaran ?? 'Pending')) }}
                  </span>
                </div>
                <p class="text-sm font-medium mt-1 adat-title">
                  {{ $pesanan->pengguna->name ?? 'Pengguna' }}
                </p>
                <div class="mt-1 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 text-xs">
                  <span class="adat-text">
                    {{ $pesanan->layanan_dashboard ?? ($pesanan->layanan->nama ?? '-') }}
                  </span>
                  <span class="font-semibold adat-jade">
                    Rp {{ number_format($pesanan->total_dashboard ?? $pesanan->total_harga, 0, ',', '.') }}
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
