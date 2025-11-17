@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  @php
    $card = 'bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm';
    $kpi = 'text-3xl font-extrabold tracking-tight';
  @endphp

  <div class="max-w-7xl mx-auto space-y-6">

    <div class="{{ $card }} p-5 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold text-slate-800">
          Halo, <span class="text-rose-600">{{ auth()->user()->name }}</span>
        </h2>
        <p class="text-slate-500 text-sm">Ringkasan aktivitas MUA kamu hari ini.</p>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('profilemua.edit') }}"
          class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50">
          Kelola Profil
        </a>
        <a href="{{ route('panelmua.layanan.create') }}"
          class="px-4 py-2 rounded-xl bg-rose-600 text-white hover:bg-rose-700">
          Tambah Layanan
        </a>
      </div>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
      <div class="{{ $card }} p-5">
        <p class="text-slate-500 text-sm">Total Baju Adat</p>
        <p class="{{ $kpi }} text-rose-600">{{ $totalBaju ?? 0 }}</p>
      </div>
      <div class="{{ $card }} p-5">
        <p class="text-slate-500 text-sm">Total Makeup</p>
        <p class="{{ $kpi }} text-amber-600">{{ $totalMakeup ?? 0 }}</p>
      </div>
      <div class="{{ $card }} p-5">
        <p class="text-slate-500 text-sm">Total Pelamin</p>
        <p class="{{ $kpi }} text-violet-600">{{ $totalPelamin ?? 0 }}</p>
      </div>
      <div class="{{ $card }} p-5">
        <p class="text-slate-500 text-sm">Pendapatan Bulan Ini</p>
        <p class="{{ $kpi }} text-emerald-600">Rp {{ number_format($revenueBulanIni ?? 0, 0, ',', '.') }}</p>
      </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
      <div class="lg:col-span-1 {{ $card }} p-5 space-y-4">
        <div class="flex items-center justify-between">
          <p class="text-slate-600 font-medium">Total Pesanan</p>
          <span class="text-xs px-2 py-0.5 rounded bg-slate-100 text-slate-600">Semua</span>
        </div>
        <p class="text-4xl font-extrabold text-slate-800">{{ $totalPesanan ?? 0 }}</p>

        <div class="grid grid-cols-3 gap-3 text-center">
          <div class="rounded-xl border border-slate-200 p-3">
            <p class="text-xs text-slate-500">Pending</p>
            <p class="text-lg font-bold text-amber-600">{{ $pending ?? 0 }}</p>
          </div>
          <div class="rounded-xl border border-slate-200 p-3">
            <p class="text-xs text-slate-500">Proses</p>
            <p class="text-lg font-bold text-blue-600">{{ $proses ?? 0 }}</p>
          </div>
          <div class="rounded-xl border border-slate-200 p-3">
            <p class="text-xs text-slate-500">Selesai</p>
            <p class="text-lg font-bold text-emerald-600">{{ $selesai ?? 0 }}</p>
          </div>
        </div>

        <div class="pt-2">
          <a href="#" class="inline-flex items-center gap-2 text-sm text-rose-600 hover:underline">
            Lihat semua pesanan
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </a>
        </div>
      </div>

      <div class="lg:col-span-2 {{ $card }} p-5">
        <div class="flex items-center justify-between mb-2">
          <p class="text-slate-700 font-medium">Pesanan 7 Hari Terakhir</p>
        </div>
        <canvas id="ordersChart" height="110"></canvas>
      </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
      <div class="lg:col-span-2 {{ $card }} p-5">
        <div class="flex items-center justify-between mb-3">
          <p class="text-slate-700 font-medium">Pesanan Terbaru</p>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="text-left text-slate-500">
              <tr>
                <th class="py-2">Kode</th>
                <th class="py-2">Pelanggan</th>
                <th class="py-2">Tanggal</th>
                <th class="py-2">Status</th>
                <th class="py-2 text-right">Total</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @forelse($pesananTerbaru as $p)
                <tr class="hover:bg-slate-50">
                  <td class="py-2 font-medium text-slate-700">#{{ $p->kode ?? $p->id }}</td>
                  <td class="py-2">{{ $p->pelanggan->nama ?? '-' }}</td>
                  <td class="py-2">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                  <td class="py-2">
                    @php
                      $badge = [
                        'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
                        'proses' => 'bg-blue-50 text-blue-700 ring-blue-200',
                        'selesai' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                      ][$p->status] ?? 'bg-slate-50 text-slate-700 ring-slate-200';
                    @endphp
                    <span class="px-2 py-0.5 rounded-lg text-xs ring-1 {{ $badge }}">{{ ucfirst($p->status) }}</span>
                  </td>
                  <td class="py-2 text-right">Rp {{ number_format($p->total_harga ?? 0, 0, ',', '.') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="py-6 text-center text-slate-500">
                    Belum ada pesanan.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="{{ $card }} p-5 space-y-3">
        <p class="text-slate-700 font-medium">Aksi Cepat</p>
        <a href="{{ route('panelmua.layanan.index') }}"
          class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50">
          Kelola Layanan
          <span class="text-slate-400">→</span>
        </a>
        <a href="{{ route('profilemua.edit') }}"
          class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50">
          Edit Profil MUA
          <span class="text-slate-400">→</span>
        </a>
        <a href="#"
          class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50">
          Lihat Ulasan
          <span class="text-slate-400">→</span>
        </a>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script>
    const ctx = document.getElementById('ordersChart');
    const labels = @json($labels ?? []);
    const dataSeries = @json($series ?? []);
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Jumlah Pesanan',
          data: dataSeries,
          borderWidth: 2,
          tension: .35
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { precision: 0, stepSize: 1 }
          }
        }
      }
    });
  </script>
@endsection