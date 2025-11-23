@extends('layouts.app')
@section('title', 'Profil MUA')

@section('content')
    @php
        $pill = 'inline-flex items-center gap-2 text-xs sm:text-sm px-3 py-1.5 rounded-full ring-1 ring-amber-100 bg-amber-50/60 text-amber-700';
        $label = 'text-[11px] font-semibold tracking-wide text-slate-500 uppercase';
        $value = 'text-sm font-medium text-slate-800';
    @endphp

    <div class="w-full px-4 sm:px-6 lg:px-10 py-4 sm:py-6">
        <div class="max-w-6xl mx-auto space-y-4 lg:space-y-6">

            {{-- ALERT PROFIL (TEMA KUNING EMAS) --}}
            @if ($mua)
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition.opacity
                    class="flex items-start gap-3 px-4 sm:px-5 py-3 rounded-2xl shadow-sm bg-[#FFF8E0] border border-[#FACC6B] text-[#8A4B00]">
                    <div
                        class="mt-0.5 h-8 w-8 flex items-center justify-center rounded-full bg-[#FFF1BF] text-[#D97706] text-lg">
                        ✓
                    </div>
                    <div class="text-sm leading-relaxed">
                        <p class="font-semibold text-[#9A5A00]">Profil MUA kamu sudah aktif ✨</p>
                        <p>Kamu bisa memperbarui kapan saja lewat tombol <b>Edit Profil</b> di bagian bawah.</p>
                    </div>
                </div>
            @else
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition.opacity
                    class="flex items-start gap-3 px-4 sm:px-5 py-3 rounded-2xl shadow-sm bg-[#FFF8E0] border border-[#FACC6B] text-[#8A4B00]">
                    <div
                        class="mt-0.5 h-8 w-8 flex items-center justify-center rounded-full bg-[#FFF1BF] text-[#D97706] text-lg">
                        !
                    </div>
                    <div class="text-sm leading-relaxed">
                        <p class="font-semibold text-[#9A5A00]">Kamu belum punya profil MUA</p>
                        <p>Buat dulu supaya bisa tampil di halaman <b>Pilih MUA</b> dan mudah ditemukan pelanggan.</p>
                    </div>
                </div>
            @endif

            {{-- KARTU PROFIL UTAMA --}}
            <div class="relative bg-white/95 rounded-3xl ring-1 ring-rose-100 shadow-sm overflow-hidden">

                {{-- ornamen lembut di pinggir kartu --}}
                <div class="pointer-events-none absolute -left-16 top-10 h-40 w-40 rounded-full bg-amber-100/40 blur-3xl">
                </div>
                <div
                    class="pointer-events-none absolute -right-10 -bottom-6 h-40 w-40 rounded-full bg-rose-100/50 blur-3xl">
                </div>

                {{-- HEADER --}}
                <div
                    class="relative px-5 sm:px-8 pt-6 pb-5 border-b border-rose-100 bg-gradient-to-r from-[#fff7f9] via-[#fff8ef] to-[#fffaf3]">
                    <div class="flex flex-wrap items-start justify-between gap-3">

                        <div class="space-y-1.5 max-w-xl">
                            <p class="text-[11px] font-semibold tracking-[0.18em] adat-gold uppercase">
                                MUA Panel
                            </p>
                            <h1 class="text-3xl sm:text-4xl font-bold" style="color:#C98A00;">
                                Profil MUA Anda
                            </h1>

                            <p class="text-xs sm:text-sm adat-text">
                                Kelola identitas brand MUA agar lebih mudah dipercaya pelanggan dan tampil menonjol di
                                pencarian.
                            </p>
                        </div>

                        <div class="flex flex-col items-end gap-2">
                            @if ($mua)
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-medium text-emerald-700 ring-1 ring-emerald-100">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Profil aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-[11px] font-medium text-amber-700 ring-1 ring-amber-100">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Belum ada profil
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="relative px-5 sm:px-8 py-6 sm:py-8 space-y-8">

                    {{-- FOTO + DESKRIPSI --}}
                    <div class="grid gap-6 lg:gap-8 items-start md:grid-cols-[minmax(0,260px)_minmax(0,1fr)]">

                        {{-- FOTO --}}
                        <div class="flex flex-col items-center md:items-start gap-4">
                            <div class="relative">
                                <figure
                                    class="w-36 h-48 sm:w-40 sm:h-52 md:w-44 md:h-56 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-sm">
                                    <img src="{{ ($mua && $mua->foto) ? asset('storage/' . $mua->foto) : 'https://placehold.co/320x416?text=Foto' }}"
                                        class="w-full h-full object-cover" alt="Foto MUA">
                                </figure>

                                {{-- frame tipis putih --}}
                                <div
                                    class="pointer-events-none absolute -inset-2 rounded-3xl border border-white/70 shadow-[0_0_0_1px_rgba(248,250,252,0.7)]">
                                </div>
                            </div>

                            <p class="text-xs text-slate-500 max-w-xs text-center md:text-left">
                                Foto ini akan muncul di kartu pencarian pelanggan.
                            </p>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="space-y-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3
                                    class="text-xl sm:text-2xl lg:text-3xl font-extrabold adat-gold leading-tight break-words">
                                    {{ $mua->nama_usaha ?? 'Belum diisi' }}
                                </h3>

                                @if ($mua && $mua->kota)
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1 text-[11px] font-medium text-rose-600 ring-1 ring-rose-100">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                                        {{ $mua->kota }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-[13px] sm:text-[15px] leading-relaxed adat-text">
                                {{ $mua->deskripsi ?? 'Belum ada deskripsi. Ceritakan style makeup andalanmu, pengalaman, paket favorit, dan kelebihanmu agar calon pelanggan lebih yakin.' }}
                            </p>

                            {{-- STATUS KHUSUS --}}
                            @if ($mua && ($mua->kontak_wa || $mua->instagram || $mua->tiktok))
                                <div class="flex flex-wrap gap-2 pt-2">
                                    @if ($mua->kontak_wa)
                                        <span class="{{ $pill }}">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            Siap menerima pesanan
                                        </span>
                                    @endif

                                    @if ($mua->instagram)
                                        <span class="{{ $pill }}">
                                            IG aktif
                                        </span>
                                    @endif

                                    @if ($mua->tiktok)
                                        <span class="{{ $pill }}">
                                            Konten TikTok tersedia
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- DETAIL KONTAK + SOSMED --}}
                    <div class="grid gap-6 lg:gap-8 md:grid-cols-2">

                        {{-- KONTAK --}}
                        <section class="space-y-3">
                            <h4 class="text-sm font-semibold flex items-center gap-2 adat-gold">
                                <span
                                    class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">
                                    ☎
                                </span>
                                Informasi Kontak
                            </h4>

                            <div class="space-y-3">
                                <div
                                    class="flex flex-col gap-1 rounded-2xl border border-slate-100 bg-slate-50/80 px-4 py-3">
                                    <span class="{{ $label }}">WhatsApp</span>
                                    <span class="{{ $value }}">{{ $mua->kontak_wa ?? '-' }}</span>
                                </div>

                                <div
                                    class="flex flex-col gap-1 rounded-2xl border border-slate-100 bg-slate-50/80 px-4 py-3">
                                    <span class="{{ $label }}">Alamat</span>
                                    <span class="{{ $value }}">{{ $mua->alamat ?? '-' }}</span>
                                </div>
                            </div>
                        </section>

                        {{-- SOSIAL MEDIA --}}
                        <section class="space-y-3">
                            <h4 class="text-sm font-semibold flex items-center gap-2 adat-gold">
                                <span
                                    class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">
                                    ✦
                                </span>
                                Sosial Media
                            </h4>

                            <div class="grid sm:grid-cols-2 gap-3">

                                {{-- Instagram --}}
                                <div class="rounded-2xl border border-slate-100 bg-slate-50/80 px-4 py-3 space-y-1.5">
                                    <div class="{{ $label }}">Instagram</div>
                                    @if (!empty($mua?->instagram))
                                        <a href="https://instagram.com/{{ ltrim($mua->instagram, '@') }}" target="_blank"
                                            class="inline-flex items-center gap-1 text-rose-600 font-medium text-sm hover:underline break-all">
                                            {{ '@' . ltrim($mua->instagram, '@') }}
                                            <span class="text-xs">↗</span>
                                        </a>
                                    @else
                                        <p class="text-xs text-slate-500 italic">Belum diisi</p>
                                    @endif
                                </div>

                                {{-- TikTok --}}
                                <div class="rounded-2xl border border-slate-100 bg-slate-50/80 px-4 py-3 space-y-1.5">
                                    <div class="{{ $label }}">TikTok</div>
                                    @if (!empty($mua?->tiktok))
                                        <a href="https://www.tiktok.com/@{{ ltrim($mua->tiktok,'@') }}" target="_blank"
                                            class="inline-flex items-center gap-1 text-rose-600 font-medium text-sm hover:underline break-all">
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
                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-t border-slate-100 pt-4">

                        <div>
                            @if (!$mua)
                                <a href="{{ route('profilemua.create') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl font-semibold text-white 
                                                  shadow-md hover:brightness-110 active:brightness-95 transition text-sm"
                                    style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
                                    Buat Profil
                                </a>
                            @else
                                <a href="{{ route('profilemua.edit') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl font-semibold text-white
                                                  shadow-md hover:brightness-110 active:brightness-95 transition text-sm"
                                    style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
                                    Edit Profil
                                </a>
                            @endif
                        </div>

                        <p class="text-[11px] sm:text-xs adat-text max-w-md text-right">
                            Data ini akan muncul di halaman publik <span class="font-medium">Pilih MUA</span>.
                            Pastikan informasi kontak & sosial media selalu kamu perbarui.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection