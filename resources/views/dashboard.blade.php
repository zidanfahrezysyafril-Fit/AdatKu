@extends('layouts.app')

@section('content')
  <div class="h-[calc(100vh-7rem)] bg-[#fff9f7] overflow-hidden">
    <div class="h-full px-6 md:px-10 py-6 space-y-6 overflow-hidden">


      {{-- HEADER / WELCOME --}}
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <p class="text-xs uppercase tracking-[0.15em] text-rose-400 mb-1">
            MUA Panel
          </p>
          <h1 class="text-2xl md:text-3xl font-semibold text-rose-700">
            Halo, <span class="text-rose-500">{{ auth()->user()->name ?? 'MUA' }}</span>
          </h1>
          <p class="text-sm text-slate-500 mt-2">
            Ringkasan singkat aktivitas MUA kamu hari ini.
          </p>
        </div>

        <div class="flex items-center gap-3">
          <a href="{{ route('profile.show') }}"
            class="px-4 py-2 rounded-full border border-rose-200 text-sm text-rose-600 hover:bg-rose-50">
            Kelola Profil
          </a>
          <a href="{{ route('panelmua.layanan.create') }}"
            class="px-4 py-2 rounded-full bg-rose-600 text-sm text-white hover:bg-rose-700">
            Tambah Layanan
          </a>
        </div>
      </div>

      {{-- Kartu Ringkasan Pesanan --}}
      <div class="bg-white rounded-2xl shadow border border-rose-100 p-6 mt-6">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-base font-semibold text-rose-700">Ringkasan Pesanan</h2>
          <a href="{{ route('panelmua.pesanan.index') }}" class="text-xs text-rose-500 hover:text-rose-600">
            Lihat semua pesanan →
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          {{-- Total pesanan --}}
          <div class="rounded-xl border border-rose-50 bg-rose-50/40 px-4 py-3">
            <p class="text-xs text-slate-500 mb-1">Total Pesanan</p>
            <p class="text-2xl font-semibold text-rose-700"></p>
          </div>

          {{-- Pending / Belum Lunas --}}
          <div class="rounded-xl border border-amber-100 bg-amber-50/40 px-4 py-3">
            <p class="text-xs text-amber-600 mb-1">Pending</p>
            <p class="text-2xl font-semibold text-amber-700"></p>
          </div>

          {{-- Lunas --}}
          <div class="rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3">
            <p class="text-xs text-emerald-600 mb-1">Lunas</p>
            <p class="text-2xl font-semibold text-emerald-700"></p>
          </div>
        </div>
      </div>

      {{-- Pendapatan bulan ini --}}
      <div class="bg-white rounded-2xl shadow-sm border border-rose-50 px-5 py-4 flex flex-col justify-between">
        <p class="text-xs text-slate-400 mb-1">Pendapatan Bulan Ini</p>
        <p class="text-2xl font-semibold text-emerald-600">
          Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}
        </p>
      </div>
    </div>

    {{-- ROW 2: RINGKASAN PESANAN + INFO SINGKAT --}}
    <div class="grid gap-6 lg:grid-cols-3">
      <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-rose-50 px-6 py-5">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h2 class="text-base font-semibold text-rose-700">Ringkasan Pesanan</h2>
            <p class="text-xs text-slate-500 mt-1">
              Total pesanan yang sudah masuk.
            </p>
          </div>
          <a href="{{ route('panelmua.pesanan.index') }}" class="text-xs text-rose-500 hover:text-rose-600">
            Lihat semua pesanan &rarr;
          </a>
        </div>

        <div class="grid gap-4 md:grid-cols-4">
          <div class="rounded-xl border border-slate-100 px-4 py-4">
            <p class="text-xs text-slate-400 mb-1">Total Pesanan</p>
            <p class="text-2xl font-semibold text-slate-800">
              {{ $totalPesanan ?? 0 }}
            </p>
          </div>
          <div class="rounded-xl border border-yellow-50 bg-yellow-50/60 px-4 py-4">
            <p class="text-xs text-slate-500 mb-1">Pending</p>
            <p class="text-xl font-semibold text-amber-600">
              {{ $totalPending ?? 0 }}
            </p>
          </div>
          <div class="rounded-xl border border-sky-50 bg-sky-50/70 px-4 py-4">
            <p class="text-xs text-slate-500 mb-1">Proses</p>
            <p class="text-xl font-semibold text-sky-600">
              {{ $totalProses ?? 0 }}
            </p>
          </div>
          <div class="rounded-xl border border-emerald-50 bg-emerald-50/70 px-4 py-4">
            <p class="text-xs text-slate-500 mb-1">lunas</p>
            <p class="text-xl font-semibold text-emerald-600">
              {{ $totallunas ?? 0 }}
            </p>
          </div>
        </div>
      </div>

      {{-- Pesanan Terbaru (versi ringkas, tanpa chart) --}}
      <div class="bg-white rounded-2xl shadow-sm border border-rose-50 px-6 py-5">
        <h2 class="text-base font-semibold text-rose-700 mb-3">Pesanan Terbaru</h2>

        @if(($pesananTerbaru ?? collect())->isEmpty())
          <p class="text-xs text-slate-500">
            Belum ada pesanan terbaru.
          </p>
        @else
          <div class="space-y-3">
            @foreach($pesananTerbaru as $pesanan)
              <div class="border border-slate-100 rounded-xl px-3 py-2.5">
                <p class="text-xs text-slate-400">
                  {{ \Carbon\Carbon::parse($pesanan->tanggal_booking)->format('d M Y') }}
                </p>
                <p class="text-sm font-medium text-slate-800">
                  {{ $pesanan->pengguna->name ?? 'Pengguna' }}
                </p>
                <p class="text-xs text-slate-500 flex justify-between mt-1">
                  <span>{{ $pesanan->layanan->nama ?? '-' }}</span>
                  <span class="font-semibold text-amber-600">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                  </span>
                </p>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

  </div>
  </div>
@endsection