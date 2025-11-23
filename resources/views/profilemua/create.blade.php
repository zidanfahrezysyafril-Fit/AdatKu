@extends('layouts.app')
@section('title', 'Buat Profil MUA')

@section('content')
    @php
        // INPUT: normal abu, pas focus baru muncul border emas gradasi
        $inp = 'w-full rounded-xl px-3 py-2.5 placeholder:text-slate-400 border border-slate-300
                focus:outline-none focus:border-[3px] focus:border-transparent
                focus:[background-image:linear-gradient(white,white),linear-gradient(90deg,#FFE07D,#C98A00)]
                focus:[background-origin:border-box] focus:[background-clip:padding-box,border-box]
                focus:ring-0';

        $lab = 'block text-sm font-medium text-slate-700 mb-1.5';
        $sec = 'bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm';
    @endphp

    <div class="w-full px-4 sm:px-6 lg:px-8 py-5 sm:py-6">
        <div class="max-w-6xl mx-auto">

            <div class="{{ $sec }}">
                <div class="px-5 sm:px-6 py-4 border-b border-slate-100">
                    <h2 class="text-2xl sm:text-3xl font-bold" style="color:#c98a00;">Buat Profil MUA</h2>
                </div>

                {{-- Alert (auto-hide) --}}
                @if (session('success') || session('info'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                         class="mx-5 sm:mx-6 mt-4 mb-0 rounded-xl border px-4 py-3 text-sm
                             {{ session('success') ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-amber-50 border-amber-200 text-amber-700' }}">
                        {{ session('success') ?? session('info') }}
                    </div>
                @endif

                <form action="{{ route('profilemua.store') }}" method="POST" enctype="multipart/form-data"
                      class="p-5 sm:p-6 lg:p-8 space-y-8">
                    @csrf

                    {{-- GRID ATAS: MEDIA + INFO UTAMA --}}
                    <div class="grid gap-6 lg:gap-8 md:grid-cols-12">

                        {{-- MEDIA --}}
                        <section class="md:col-span-5 lg:col-span-4 {{ $sec }} p-4 sm:p-5">
                            <h3 class="text-base font-semibold text-slate-800 mb-4">Foto Profil</h3>

                            <div class="flex flex-col sm:flex-row items-start gap-4">
                                <div
                                    class="w-28 h-36 sm:w-32 sm:h-40 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 mx-auto sm:mx-0">
                                    <img id="preview" src="https://placehold.co/320x400?text=Foto"
                                         class="w-full h-full object-cover" alt="Foto">
                                </div>

                                <div class="flex-1 w-full">
                                    <label class="{{ $lab }}">Unggah Foto</label>
                                    <input type="file" name="foto" accept="image/*" onchange="previewImg(event)"
                                        class="block w-full rounded-xl border border-slate-300 text-xs sm:text-sm
                                               file:mr-3 file:px-3 file:py-2 file:rounded-lg file:border-0
                                               file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                                    @error('foto')
                                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-slate-500 mt-1">Format JPG/PNG, maks 2MB.</p>
                                </div>
                            </div>
                        </section>

                        {{-- INFORMASI UTAMA --}}
                        <section class="md:col-span-7 lg:col-span-8 {{ $sec }} p-4 sm:p-5">
                            <h3 class="text-base font-semibold text-slate-800 mb-4">Informasi Utama</h3>

                            <div class="grid gap-5">
                                <div>
                                    <label class="{{ $lab }}">Nama MUA</label>
                                    <input type="text" name="nama_usaha" value="{{ old('nama_usaha') }}"
                                           class="{{ $inp }}" placeholder="Masukkan nama MUA kamu">
                                </div>

                                <div class="grid md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="{{ $lab }}">Kontak WA</label>
                                        <input type="text" name="kontak_wa" value="{{ old('kontak_wa') }}"
                                               class="{{ $inp }}" placeholder="+62 812 3456 7890">
                                    </div>
                                    <div>
                                        <label class="{{ $lab }}">Alamat / Domisili</label>
                                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                                               class="{{ $inp }}" placeholder="Masukkan alamat / domisili kamu">
                                    </div>
                                </div>

                                <div>
                                    <label class="{{ $lab }}">Deskripsi singkat</label>
                                    <textarea name="deskripsi" rows="5" class="{{ $inp }} resize-y"
                                              placeholder="Ceritakan secara singkat tentang jasa MUA kamu...">{{ old('deskripsi') }}</textarea>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- SOSIAL MEDIA --}}
                    <section class="{{ $sec }} p-4 sm:p-5">
                        <h3 class="text-base font-semibold text-slate-800 mb-4">Sosial Media</h3>

                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="{{ $lab }}">Instagram</label>
                                <input type="text" name="instagram" value="{{ old('instagram') }}" class="{{ $inp }}"
                                       placeholder="@username">
                            </div>
                            <div>
                                <label class="{{ $lab }}">TikTok</label>
                                <input type="text" name="tiktok" value="{{ old('tiktok') }}" class="{{ $inp }}"
                                       placeholder="@username">
                            </div>
                        </div>
                    </section>

                    {{-- STICKY ACTION BAR (TOMBOL) --}}
                    <div class="sticky bottom-0 inset-x-0">
                        <div class="bg-white/90 backdrop-blur border-t border-slate-200">
                            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">

                                {{-- TOMBOL BATAL --}}
                                <a href="{{ route('mua.panel') }}"
                                   class="inline-flex items-center justify-center px-5 py-2.5 rounded-2xl font-semibold text-white
                                          shadow-sm hover:brightness-110 active:brightness-95 transition text-sm"
                                   style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
                                    Batal
                                </a>

                                {{-- TOMBOL SIMPAN PROFIL --}}
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl font-semibold text-white
                                           shadow-md hover:brightness-110 active:brightness-95 transition text-sm
                                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#eab308] focus-visible:ring-offset-2"
                                    style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
                                    Simpan Profil
                                </button>

                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <p class="text-xs text-slate-500 mt-4 text-center">
                Data dari menu ini akan tampil di halaman Profil MUA.
            </p>

            <footer class="mt-8 sm:mt-10 text-xs text-slate-500 text-center pb-8">
                © {{ date('Y') }} AdatKu — MUA Panel
            </footer>
        </div>
    </div>

    {{-- Preview foto --}}
    <script>
        function previewImg(e) {
            const f = e.target.files?.[0];
            if (!f) return;
            const r = new FileReader();
            r.onload = () => document.getElementById('preview').src = r.result;
            r.readAsDataURL(f);
        }
    </script>
@endsection
