@extends('layouts.app')

@section('content')
  @php
    use Carbon\Carbon;
    $today = Carbon::now()->translatedFormat('d F Y');
  @endphp

  <div class="min-h-[calc(100vh-4rem)] bg-transparent">
    <div class="max-w-6xl mx-auto px-4 md:px-8 py-6 space-y-6">

      {{-- HEADER / WELCOME --}}
      <div class="relative overflow-hidden rounded-3xl border border-rose-100 bg-gradient-to-r from-[#fff3f5] via-[#fff8ef] to-[#fff4fa]
                 px-4 py-5 sm:px-6 sm:py-5 md:px-8 md:py-6
                 flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-6">

        {{-- ornamen blur --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-rose-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-10 -bottom-10 h-32 w-32 rounded-full bg-amber-200/40 blur-3xl">
        </div>

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
          <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 rounded-full border border-[#f5c86b]
                      bg-white/80 text-xs md:text-sm hover:bg-amber-50 transition adat-gold text-center">
            Kelola Profil
          </a>
          <a href="{{ route('panelmua.layanan.create') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 rounded-full border border-[#f5c86b]
                      bg-white/80 text-xs md:text-sm hover:bg-amber-50 transition adat-gold text-center">
            + Tambah Layanan
          </a>
        </div>
      </div>

      {{-- ROW 1: RINGKASAN PESANAN + PENDAPATAN --}}
      <div class="grid gap-6 lg:grid-cols-3">

        {{-- RINGKASAN PESANAN --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-rose-50 px-4 sm:px-5 md:px-6 py-4 sm:py-5">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
            <div>
              <h2 class="text-sm sm:text-base font-semibold adat-gold">Ringkasan Pesanan</h2>
              <p class="text-xs adat-text mt-1">
                Gambaran cepat status pesanan yang masuk ke kamu.
              </p>
            </div>
            <a href="{{ route('panelmua.pesanan.index') }}" class="text-xs font-medium hover:underline adat-gold">
              Lihat semua pesanan &rarr;
            </a>
          </div>

          <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Pesanan --}}
            <div class="stat-card bg-rose-50/70">
              <p class="text-[11px] adat-title mb-1">Total Pesanan</p>
              <p class="text-2xl font-semibold adat-title">{{ $totalPesanan ?? 0 }}</p>
              <p class="text-[11px] adat-text mt-1">Semua status pesanan</p>
              <span class="text-2xl block mt-2">📦</span>
            </div>

            {{-- Pending --}}
            <div class="stat-card bg-amber-50/70">
              <p class="text-[11px] adat-gold mb-1">Pending</p>
              <p class="text-2xl font-semibold adat-gold">{{ $totalPending ?? 0 }}</p>
              <p class="text-[11px] adat-text mt-1">Menunggu konfirmasi / pembayaran</p>
              <span class="text-2xl block mt-2">⏳</span>
            </div>

            {{-- Proses --}}
            <div class="stat-card bg-sky-50/70">
              <p class="text-[11px] mb-1" style="color:#4a83aa;">Proses</p>
              <p class="text-2xl font-semibold" style="color:#4a83aa;">{{ $totalProses ?? 0 }}</p>
              <p class="text-[11px] adat-text mt-1">Sedang dikerjakan / hari-H</p>
              <span class="text-2xl block mt-2">🎨</span>
            </div>

            {{-- Lunas --}}
            <div class="stat-card bg-emerald-50/70">
              <p class="text-[11px] adat-jade mb-1">Lunas</p>
              <p class="text-2xl font-semibold adat-jade">{{ $totallunas ?? 0 }}</p>
              <p class="text-[11px] adat-text mt-1">Pesanan selesai & terbayar</p>
              <span class="text-2xl block mt-2">✅</span>
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
                <h2 class="text-sm sm:text-base font-semibold adat-title">Bulan Ini</h2>
              </div>
              <span
                class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[11px] border border-emerald-100 adat-jade">
                💰 Stabil
              </span>
            </div>

            <p class="text-2xl sm:text-3xl font-semibold adat-jade">
              Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}
            </p>
            <p class="mt-2 text-[11px] adat-text">
              Total pendapatan dari pesanan yang sudah lunas bulan ini.
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
            <div class="pointer-events-none absolute -left-10 -bottom-6 h-24 w-24 rounded-full bg-amber-200/40 blur-2xl">
            </div>

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
                    {{ ucfirst($pesanan->status ?? 'pending') }}
                  </span>
                </div>
                <p class="text-sm font-medium mt-1 adat-title">
                  {{ $pesanan->pengguna->name ?? 'Pengguna' }}
                </p>
                <div class="mt-1 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 text-xs">
                  <span class="adat-text">{{ $pesanan->layanan->nama ?? '-' }}</span>
                  <span class="font-semibold adat-jade">
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