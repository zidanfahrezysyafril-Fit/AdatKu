@extends('layouts.app')

@section('content')
<div class="px-8 py-6">
    <h1 class="text-2xl font-bold text-rose-700 mb-6">Pesanan Masuk</h1>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($pesanans->isEmpty())
        <p class="text-slate-500 text-sm">Belum ada pesanan untuk MUA ini.</p>
    @else
        <div class="bg-white rounded-2xl shadow border border-rose-100 overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-rose-50 text-rose-700">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Tanggal Booking</th>
                        <th class="px-4 py-3 text-left">Pengguna</th>
                        <th class="px-4 py-3 text-left">Layanan</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-left">Status Pembayaran</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rose-50">
                    @foreach ($pesanans as $index => $pesanan)
                        <tr>
                            <td class="px-4 py-3 align-top">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-4 py-3 align-top">
                                {{ \Carbon\Carbon::parse($pesanan->tanggal_booking)->translatedFormat('d M Y') }}
                            </td>

                            <td class="px-4 py-3 align-top">
                                {{ $pesanan->pengguna->name ?? '—' }}
                                <div class="text-[11px] text-slate-500">
                                    {{ $pesanan->alamat }}
                                </div>
                            </td>

                            <td class="px-4 py-3 align-top">
                                {{ $pesanan->layanan->nama ?? '-' }}
                            </td>

                            <td class="px-4 py-3 align-top font-semibold">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 align-top">
                                @php
                                    $status = $pesanan->status_pembayaran;
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px]
                                    @if ($status === 'Belum_Lunas')
                                        bg-yellow-50 text-yellow-700
                                    @elseif ($status === 'Lunas')
                                        bg-emerald-50 text-emerald-700
                                    @else
                                        bg-rose-50 text-rose-700
                                    @endif
                                ">
                                    {{ str_replace('_', ' ', $status) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 align-top">
                                <div class="flex flex-col gap-2">

                                    <form action="{{ route('panelmua.pesanan.updateStatus', $pesanan->id) }}"
                                          method="POST"
                                          class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status_pembayaran"
                                                class="border rounded-lg px-2 py-1 text-xs text-slate-700">
                                            <option value="Belum_Lunas"
                                                @selected($pesanan->status_pembayaran === 'Belum_Lunas')>
                                                Belum Lunas
                                            </option>
                                            <option value="Lunas"
                                                @selected($pesanan->status_pembayaran === 'Lunas')>
                                                Lunas
                                            </option>
                                            <option value="Dibatalkan"
                                                @selected($pesanan->status_pembayaran === 'Dibatalkan')>
                                                Dibatalkan
                                            </option>
                                        </select>

                                        <button type="submit"
                                                class="px-3 py-1 text-[11px] rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                                            Update
                                        </button>
                                    </form>

                                    <form action="{{ route('panelmua.pesanan.destroy', $pesanan->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-[11px] rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
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
    @endif
</div>
@endsection
