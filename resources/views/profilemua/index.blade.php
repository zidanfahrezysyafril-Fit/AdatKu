@extends('layouts.app')
@section('title', 'Profil MUA')

@section('content')
    @php
        $pill = 'inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-lg ring-1 ring-slate-200 bg-slate-50';
        $label = 'text-sm font-medium text-slate-700';
        $value = 'text-slate-800';
    @endphp

    <div class="w-full px-6 lg:px-10">
        @if ($mua)
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition.opacity
                class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl mb-1 shadow-sm">
                <strong>Kamu sudah membuat profil MUA.</strong><br>
                Jika ada kesalahan data, silakan tekan tombol <b>Edit Profil</b> di bawah ini.
            </div>
        @else
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition.opacity
                class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-5 py-3 rounded-xl mb-1 shadow-sm">
                <strong>Kamu belum membuat profil MUA.</strong><br>
                Silakan tekan tombol <b>Buat Profil</b> untuk mengisi data MUA kamu.
            </div>
        @endif

        <div class="w-full bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm p-6 lg:p-8">

            <h2 class="text-2xl font-bold text-rose-700 mb-4">Profil MUA Anda</h2>

            @if(session('success'))
                <div class="mb-6 rounded-xl bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid md:grid-cols-12 gap-6 mb-6">
                <div class="md:col-span-3">
                    <figure class="w-40 h-52 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                        <img src="{{ ($mua && $mua->foto) ? asset('storage/' . $mua->foto) : 'https://placehold.co/320x416?text=Foto' }}"
                            class="w-full h-full object-cover" alt="Foto MUA">
                    </figure>
                </div>
                <div class="md:col-span-9">
                    <h3 class="text-3xl font-extrabold text-rose-700 leading-tight">
                        {{ $mua->nama_usaha ?? 'Belum diisi' }}
                    </h3>
                    <p class="mt-3 text-[15px] leading-7 text-slate-700">
                        {{ $mua->deskripsi ?? 'Belum ada deskripsi yang diisi.' }}
                    </p>
                </div>
            </div>

            <hr class="my-6 border-rose-100">
            <div class="grid md:grid-cols-2 gap-8">
                <section>
                    <h4 class="text-base font-semibold text-rose-700 mb-3">Informasi Kontak</h4>

                    <div class="space-y-2">
                        <div class="{{ $pill }}">
                            <span class="{{ $label }}">WA:</span>
                            <span class="{{ $value }}">{{ $mua->kontak_wa ?? '-' }}</span>
                        </div>
                        <div class="{{ $pill }}">
                            <span class="{{ $label }}">Alamat:</span>
                            <span class="{{ $value }}">{{ $mua->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </section>
                <section>
                    <h4 class="text-base font-semibold text-rose-700 mb-3">Sosial Media</h4>

                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="rounded-xl ring-1 ring-slate-200 bg-slate-50 px-4 py-3">
                            <div class="text-sm font-medium text-slate-700 mb-1">Instagram</div>
                            @if(!empty($mua?->instagram))
                                <a href="https://instagram.com/{{ ltrim($mua->instagram, '@') }}" target="_blank"
                                    class="text-rose-600 font-medium hover:underline">
                                    {{ '@' . ltrim($mua->instagram, '@') }}
                                </a>
                            @else
                                <p class="text-slate-500 italic">Belum diisi</p>
                            @endif
                        </div>
                        <div class="rounded-xl ring-1 ring-slate-200 bg-slate-50 px-4 py-3">
                            <div class="text-sm font-medium text-slate-700 mb-1">TikTok</div>
                            @if(!empty($mua?->tiktok))
                                <a href="https://www.tiktok.com/@{{ ltrim($mua->tiktok,'@') }}" target="_blank"
                                    class="text-rose-600 font-medium hover:underline">
                                    {{ '@' . ltrim($mua->tiktok, '@') }}
                                </a>
                            @else
                                <p class="text-slate-500 italic">Belum diisi</p>
                            @endif
                        </div>
                    </div>
                </section>

            </div>

            <div class="mt-8 flex items-center gap-3">
                @if(!isset($mua))
                    <a href="{{ route('profilemua.create') }}"
                        class="px-5 py-2 rounded-xl bg-rose-600 text-white hover:bg-rose-700">
                        Buat Profil
                    </a>
                @else
                    <a href="{{ route('profilemua.edit') }}"
                        class="px-5 py-2 rounded-xl bg-amber-500 text-white hover:bg-amber-600">
                        Edit Profil
                    </a>
                @endif
            </div>


            <p class="text-xs text-slate-500 mt-4">
                Data ini akan ditampilkan di halaman publik <span class="font-medium">Pilih MUA</span>.
            </p>
        </div>
    </div>
@endsection