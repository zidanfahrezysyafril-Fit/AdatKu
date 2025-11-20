@extends('layouts.app')
@section('title', 'Profil MUA')

@section('content')
    @php
        $pill = 'inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-full ring-1 ring-slate-200 bg-slate-50';
        $label = 'text-xs font-semibold tracking-wide text-slate-500 uppercase';
        $value = 'text-sm font-medium text-slate-800';
    @endphp

    <div class="w-full px-4 sm:px-6 lg:px-10 space-y-4 lg:space-y-6">

        {{-- INFO BANNER --}}
        @if ($mua)
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition.opacity
                class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 sm:px-5 py-3 rounded-2xl shadow-sm">
                <div
                    class="mt-0.5 h-8 w-8 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-lg">
                    ✔
                </div>
                <div class="text-sm leading-relaxed">
                    <p class="font-semibold">Profil MUA kamu sudah aktif ✨</p>
                    <p>Kalau ada data yang kurang tepat, kamu bisa perbarui kapan saja lewat tombol <b>Edit Profil</b> di bawah.
                    </p>
                </div>
            </div>
        @else
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition.opacity
                class="flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 px-4 sm:px-5 py-3 rounded-2xl shadow-sm">
                <div class="mt-0.5 h-8 w-8 flex items-center justify-center rounded-full bg-amber-100 text-amber-600 text-lg">
                    !
                </div>
                <div class="text-sm leading-relaxed">
                    <p class="font-semibold">Kamu belum punya profil MUA</p>
                    <p>Buat profil dulu ya supaya bisa tampil di halaman <b>Pilih MUA</b> dan dilihat calon pelanggan.</p>
                </div>
            </div>
        @endif

        {{-- KARTU UTAMA --}}
        <div class="w-full bg-white/90 backdrop-blur rounded-3xl ring-1 ring-rose-50 shadow-sm overflow-hidden">

            {{-- HEADER KARTU --}}
            <div
                class="relative px-6 sm:px-8 pt-6 pb-5 border-b border-rose-50 bg-gradient-to-r from-[#fff5f8] via-[#fff9fb] to-[#fffdf7]">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold tracking-[0.18em] text-rose-400 uppercase">MUA Panel</p>
                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">
                            Profil MUA Anda
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Kelola identitas brand MUA kamu agar lebih mudah dipercaya pelanggan.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @if ($mua)
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-100">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Profil aktif
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-100">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Belum ada profil
                            </span>
                        @endif
                    </div>
                </div>

                @if(session('success'))
                    <div class="mt-4 rounded-2xl bg-emerald-50 text-emerald-800 ring-1 ring-emerald-100 px-4 py-2.5 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            {{-- BODY --}}
            <div class="px-6 sm:px-8 py-6 sm:py-8 space-y-8">

                {{-- FOTO + NAMA --}}
                <div class="grid md:grid-cols-[minmax(0,260px)_minmax(0,1fr)] gap-6 lg:gap-8 items-start">
                    {{-- FOTO --}}
                    <div class="flex flex-col items-center md:items-start gap-4">
                        <div class="relative">
                            <figure
                                class="w-40 h-52 sm:w-44 sm:h-56 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-sm">
                                <img src="{{ ($mua && $mua->foto) ? asset('storage/' . $mua->foto) : 'https://placehold.co/320x416?text=Foto' }}"
                                    class="w-full h-full object-cover" alt="Foto MUA">
                            </figure>
                            <div
                                class="pointer-events-none absolute -inset-2 rounded-3xl border border-white/60 shadow-[0_0_0_1px_rgba(248,250,252,0.7)]">
                            </div>
                        </div>

                        <p class="text-xs text-slate-500 text-center md:text-left max-w-xs">
                            Foto ini akan muncul di kartu MUA kamu di halaman pencarian pelanggan.
                        </p>
                    </div>

                    {{-- NAMA + DESKRIPSI --}}
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-rose-700 leading-tight">
                                {{ $mua->nama_usaha ?? 'Belum diisi' }}
                            </h3>
                            @if($mua && $mua->kota)
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1 text-xs font-medium text-rose-600 ring-1 ring-rose-100">
                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                                    {{ $mua->kota }}
                                </span>
                            @endif
                        </div>

                        <p class="text-[15px] leading-relaxed text-slate-700">
                            {{ $mua->deskripsi ?? 'Belum ada deskripsi yang diisi. Ceritakan kelebihan, style makeup, dan pengalamanmu agar calon pelanggan lebih percaya.' }}
                        </p>

                        @if($mua && ($mua->kontak_wa || $mua->instagram || $mua->tiktok))
                            <div class="flex flex-wrap gap-2 pt-2">
                                @if($mua->kontak_wa)
                                    <span class="{{ $pill }}">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        <span class="text-xs font-semibold text-slate-600">Siap menerima pesanan</span>
                                    </span>
                                @endif
                                @if($mua->instagram)
                                    <span class="{{ $pill }}">
                                        <span class="text-xs font-semibold text-slate-600">IG aktif</span>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- INFORMASI DETAIL --}}
                <div class="grid md:grid-cols-2 gap-6 lg:gap-8">

                    {{-- KONTAK --}}
                    <section class="space-y-3">
                        <h4 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                            <span
                                class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">☎</span>
                            Informasi Kontak
                        </h4>

                        <div class="space-y-3">
                            <div class="flex flex-col gap-1 rounded-2xl border border-slate-100 bg-slate-50/80 px-4 py-3">
                                <span class="{{ $label }}">WhatsApp</span>
                                <span class="{{ $value }}">{{ $mua->kontak_wa ?? '-' }}</span>
                            </div>

                            <div class="flex flex-col gap-1 rounded-2xl border border-slate-100 bg-slate-50/80 px-4 py-3">
                                <span class="{{ $label }}">Alamat</span>
                                <span class="{{ $value }}">{{ $mua->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </section>

                    {{-- SOSMED --}}
                    <section class="space-y-3">
                        <h4 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                            <span
                                class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">✦</span>
                            Sosial Media
                        </h4>

                        <div class="grid sm:grid-cols-2 gap-3">
                            {{-- Instagram --}}
                            <div class="rounded-2xl border border-slate-100 bg-slate-50/80 px-4 py-3 space-y-1.5">
                                <div class="flex items-center justify-between gap-2">
                                    <div>
                                        <div class="text-xs font-semibold tracking-wide text-slate-500 uppercase">Instagram
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($mua?->instagram))
                                    <a href="https://instagram.com/{{ ltrim($mua->instagram, '@') }}" target="_blank"
                                        class="inline-flex items-center gap-1 text-rose-600 font-medium text-sm hover:underline">
                                        {{ '@' . ltrim($mua->instagram, '@') }}
                                        <span class="text-xs">↗</span>
                                    </a>
                                @else
                                    <p class="text-xs text-slate-500 italic">Belum diisi</p>
                                @endif
                            </div>

                            {{-- TikTok --}}
                            <div class="rounded-2xl border border-slate-100 bg-slate-50/80 px-4 py-3 space-y-1.5">
                                <div class="flex items-center justify-between gap-2">
                                    <div>
                                        <div class="text-xs font-semibold tracking-wide text-slate-500 uppercase">TikTok
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($mua?->tiktok))
                                    <a href="https://www.tiktok.com/@{{ ltrim($mua->tiktok,'@') }}" target="_blank"
                                        class="inline-flex items-center gap-1 text-rose-600 font-medium text-sm hover:underline">
                                        {{ '@' . ltrim($mua->tiktok, '@') }}
                                        <span class="text-xs">↗</span>
                                    </a>
                                @else
                                    <p class="text-xs text-slate-500 italic">Belum diisi</p>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>

                {{-- ACTION AREA --}}
                <div class="flex flex-wrap items-center justify-between gap-3 pt-2 border-t border-slate-100 pt-4">
                    <div class="flex items-center gap-3">
                        @if(!isset($mua))
                            <a href="{{ route('profilemua.create') }}"
                                class="inline-flex items-center justify-center px-5 py-2.5 rounded-2xl bg-rose-600 text-white text-sm font-semibold shadow-sm hover:bg-rose-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 focus-visible:ring-offset-2">
                                Buat Profil
                            </a>
                        @else
                            <a href="{{ route('profilemua.edit') }}"
                                class="inline-flex items-center justify-center px-5 py-2.5 rounded-2xl bg-amber-500 text-white text-sm font-semibold shadow-sm hover:bg-amber-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2">
                                Edit Profil
                            </a>
                        @endif
                    </div>

                    <p class="text-[11px] sm:text-xs text-slate-500 text-right max-w-md">
                        Data ini akan ditampilkan di halaman publik <span class="font-medium">Pilih MUA</span>.
                        Pastikan informasi kontak dan sosial media selalu kamu update.
                    </p>
                </div>

            </div>
        </div>
    </div>
@endsection