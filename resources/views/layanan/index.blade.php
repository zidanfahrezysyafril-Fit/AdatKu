@extends('layouts.app')
@section('title', 'Layanan MUA')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
            <div x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false, 3500)"
                class="mb-4 flex items-center justify-between px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
                <span>{{ session('success') }}</span>
                <button @click="show=false" class="text-xs font-semibold">Tutup</button>
            </div>
        @endif

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-rose-700">Layanan Kamu</h2>
                <p class="text-sm text-slate-500">
                    Kelola daftar layanan makeup, baju adat, dan pelamin untuk MUA:
                    <span class="font-semibold text-slate-700">{{ $mua->nama_usaha ?? auth()->user()->name }}</span>
                </p>
            </div>

            <a href="{{ route('panelmua.layanan.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-600 text-white text-sm font-medium hover:bg-rose-700">
                <span>+ Tambah Layanan</span>
            </a>
        </div>

        {{-- TAB FILTER --}}
        @php $k = $kategori; @endphp
        <div class="inline-flex items-center gap-1 rounded-xl bg-white shadow-sm ring-1 ring-slate-200 p-1 mb-6">
            <a href="{{ route('panelmua.layanan.index') }}" class="px-4 py-1.5 rounded-lg text-sm font-medium
               {{ !$k ? 'bg-rose-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Semua
            </a>

            <a href="{{ route('panelmua.layanan.index', ['k' => 'makeup']) }}" class="px-4 py-1.5 rounded-lg text-sm font-medium
               {{ $k === 'makeup' ? 'bg-rose-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Makeup
            </a>

            <a href="{{ route('panelmua.layanan.index', ['k' => 'baju']) }}" class="px-4 py-1.5 rounded-lg text-sm font-medium
               {{ $k === 'baju' ? 'bg-rose-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Baju Adat
            </a>

            <a href="{{ route('panelmua.layanan.index', ['k' => 'pelamin']) }}" class="px-4 py-1.5 rounded-lg text-sm font-medium
               {{ $k === 'pelamin' ? 'bg-rose-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Pelamin
            </a>
        </div>

        {{-- GRID LAYANAN --}}
        @if($items->count())
            <div class="grid gap-5 md:grid-cols-3">
                @foreach($items as $item)
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden flex flex-col">
                        <div class="h-40 bg-slate-100">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover"
                                    alt="{{ $item->nama }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                                    Tidak ada foto
                                </div>
                            @endif
                        </div>

                        <div class="p-4 flex-1 flex flex-col">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h3 class="font-semibold text-slate-800 line-clamp-2">{{ $item->nama }}</h3>
                                @if($item->kategori)
                                    <span class="px-2 py-0.5 text-[11px] rounded-full bg-rose-50 text-rose-600 uppercase">
                                        {{ $item->kategori }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-rose-600 font-semibold text-sm mb-1">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </p>

                            <p class="text-xs text-slate-500 line-clamp-2 mb-3">
                                {{ $item->deskripsi ?: 'Belum ada deskripsi.' }}
                            </p>

                            <div class="mt-auto pt-2 flex items-center justify-between text-xs">
                                <a href="{{ route('panelmua.layanan.edit', $item->id) }}"
                                    class="px-3 py-1 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-medium">
                                    Edit
                                </a>

                                <form action="{{ route('panelmua.layanan.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $items->withQueryString()->links() }}
            </div>
        @else
            <div class="mt-10 text-center text-slate-500 text-sm">
                Belum ada layanan yang ditambahkan.
                <br>
                <a href="{{ route('panelmua.layanan.create') }}" class="text-rose-600 font-medium hover:underline">
                    Tambah layanan pertama kamu
                </a>
            </div>
        @endif
    </div>
@endsection