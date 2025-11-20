@extends('layouts.app')
@section('title', 'Layanan MUA')

@section('content')
    <div class="w-full px-5 sm:px-6 lg:px-10">
        <div class="max-w-6xl mx-auto space-y-4 lg:space-y-6">

            {{-- ALERT BERHASIL (di luar kotak utama tapi tetap dekat) --}}
            @if(session('success'))
                <div x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false, 3500)" x-transition.opacity
                    class="flex items-start gap-3 px-4 py-3 rounded-2xl bg-emerald-50/90 border border-emerald-200/80 text-emerald-800 text-sm shadow-sm">
                    <div
                        class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-base">
                        ✔
                    </div>
                    <div class="flex-1">
                        {{ session('success') }}
                    </div>
                    <button @click="show=false" class="text-[11px] font-semibold uppercase tracking-wide">
                        Tutup
                    </button>
                </div>
            @endif

            {{-- KOTAK UTAMA --}}
            <div class="bg-white/95 rounded-3xl ring-1 ring-rose-50 shadow-sm p-6 sm:p-8 lg:p-9 space-y-6">

                {{-- HEADER + BUTTON --}}
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold tracking-[0.22em] text-rose-500 uppercase">MUA Panel</p>

                        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                            Layanan Kamu
                        </h1>

                        <div class="text-sm text-slate-600">
                            Kelola layanan untuk MUA:
                            <span class="font-semibold text-slate-900">
                                {{ $mua->nama_usaha ?? auth()->user()->name }}
                            </span>
                        </div>

                        <div class="h-[3px] w-16 bg-gradient-to-r from-rose-500/80 to-orange-300/80 rounded-full mt-2">
                        </div>
                    </div>

                    <a href="{{ route('panelmua.layanan.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-rose-600 text-white text-sm font-semibold shadow-sm
                                  hover:bg-rose-700 hover:shadow-md active:scale-95 transition-all duration-200">
                        <span class="text-lg leading-none">＋</span>
                        <span>Tambah Layanan</span>
                    </a>
                </div>

                {{-- FILTER KATEGORI (di dalam kotak) --}}
                @php $k = $kategori; @endphp
                <div
                    class="inline-flex items-center gap-1 rounded-2xl bg-slate-50/80 shadow-sm ring-1 ring-slate-200 px-1.5 py-1">
                    <a href="{{ route('panelmua.layanan.index') }}" class="px-4 py-1.5 rounded-xl text-xs sm:text-sm font-medium
                               {{ !$k ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                        Semua
                    </a>

                    <a href="{{ route('panelmua.layanan.index', ['k' => 'makeup']) }}"
                        class="px-4 py-1.5 rounded-xl text-xs sm:text-sm font-medium
                               {{ $k === 'makeup' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                        Makeup
                    </a>

                    <a href="{{ route('panelmua.layanan.index', ['k' => 'baju']) }}"
                        class="px-4 py-1.5 rounded-xl text-xs sm:text-sm font-medium
                               {{ $k === 'baju' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                        Baju Adat
                    </a>

                    <a href="{{ route('panelmua.layanan.index', ['k' => 'pelamin']) }}"
                        class="px-4 py-1.5 rounded-xl text-xs sm:text-sm font-medium
                               {{ $k === 'pelamin' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                        Pelamin
                    </a>
                </div>

                {{-- GRID LAYANAN + PAGINASI di dalam kotak --}}
                @if($items->count())
                    <div class="grid gap-5 lg:gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($items as $item)
                            <div
                                class="group bg-white rounded-3xl shadow-sm ring-1 ring-slate-100 overflow-hidden flex flex-col transition hover:-translate-y-1 hover:shadow-md hover:ring-rose-100">
                                {{-- FOTO --}}
                                <div class="relative h-40 sm:h-44 bg-slate-100">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover"
                                            alt="{{ $item->nama }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs sm:text-sm">
                                            Tidak ada foto
                                        </div>
                                    @endif

                                    @if($item->kategori)
                                        <span
                                            class="absolute top-3 right-3 px-2 py-0.5 text-[10px] font-semibold rounded-full bg-rose-600/90 text-white uppercase tracking-wide shadow-sm">
                                            {{ $item->kategori }}
                                        </span>
                                    @endif
                                </div>

                                {{-- ISI --}}
                                <div class="p-4 sm:p-5 flex-1 flex flex-col">
                                    <div class="flex items-start justify-between gap-2 mb-1.5">
                                        <h3 class="font-semibold text-slate-900 text-sm sm:text-[15px] line-clamp-2">
                                            {{ $item->nama }}
                                        </h3>
                                    </div>

                                    <p class="text-rose-600 font-semibold text-sm mb-1">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </p>

                                    <p class="text-xs text-slate-500 line-clamp-2 mb-3">
                                        {{ $item->deskripsi ?: 'Belum ada deskripsi.' }}
                                    </p>

                                    <div class="mt-auto pt-2 flex items-center justify-between text-xs">
                                        <a href="{{ route('panelmua.layanan.edit', $item->id) }}"
                                            class="px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 font-medium">
                                            Edit
                                        </a>

                                        <form action="{{ route('panelmua.layanan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 border-t border-slate-100 mt-4">
                        {{ $items->withQueryString()->links() }}
                    </div>
                @else
                    {{-- EMPTY STATE DI DALAM KOTAK --}}
                    <div
                        class="flex flex-col items-center justify-center text-center gap-3 py-10 rounded-2xl bg-slate-50/70 border border-dashed border-rose-100">
                        <div class="h-12 w-12 rounded-full bg-rose-50 flex items-center justify-center text-2xl text-rose-400">
                            ✨
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-semibold text-slate-800">Belum ada layanan yang ditambahkan</p>
                            <p class="text-xs text-slate-500 max-w-md">
                                Tambahkan layanan pertama kamu supaya pelanggan bisa melihat pilihan makeup, baju adat, atau
                                pelamin yang tersedia.
                            </p>
                        </div>
                        <a href="{{ route('panelmua.layanan.create') }}"
                            class="mt-1 inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-rose-600 text-white text-xs font-semibold shadow-sm hover:bg-rose-700">
                            + Tambah layanan pertama
                        </a>
                    </div>
                @endif

            </div> {{-- akhir kotak utama --}}
        </div>
    </div>
@endsection