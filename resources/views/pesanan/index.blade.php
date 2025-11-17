@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold text-rose-700 mb-6">Pesanan Saya</h1>

        @if ($pesanan->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm p-6 text-center text-slate-500">
                Kamu belum memiliki pesanan.
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left text-slate-500">
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">MUA</th>
                            <th class="py-2">Layanan</th>
                            <th class="py-2">Status</th>
                            <th class="py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan as $p)
                            <tr class="border-b last:border-0">
                                <td class="py-2">
                                    {{ $p->created_at->format('d M Y') }}
                                </td>
                                <td class="py-2">
                                    {{ $p->mua->nama_usaha ?? '-' }}
                                </td>
                                <td class="py-2">
                                    {{ $p->layanan->nama ?? '-' }}
                                </td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded-full text-xs
                                                @if($p->status === 'pending') bg-amber-100 text-amber-700
                                                @elseif($p->status === 'selesai') bg-emerald-100 text-emerald-700
                                                @else bg-slate-100 text-slate-700 @endif">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="py-2 text-right font-semibold">
                                    Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection