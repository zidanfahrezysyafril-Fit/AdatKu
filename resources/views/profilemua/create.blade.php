@extends('layouts.app')
@section('title', 'Buat Profil MUA')

@section('content')
    @php
        $inp = 'w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 placeholder:text-slate-400';
        $lab = 'block text-sm font-medium text-slate-700 mb-1.5';
        $sec = 'bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm';
    @endphp

    <div class="max-w-6xl mx-auto">
        <div class="{{ $sec }}">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-3xl font-bold" style="color:#c98a00;">Buat Profil MUA</h2>
            </div>

            {{-- Alert (auto-hide) --}}
            @if(session('success') || session('info'))
                <div x-data="{ show: true }" x-init="setTimeout(()=>show=false,3000)" x-show="show" x-transition
                    class="mx-6 mt-4 mb-0 rounded-xl border px-4 py-3
                                       {{ session('success') ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-amber-50 border-amber-200 text-amber-700' }}">
                    {{ session('success') ?? session('info') }}
                </div>
            @endif

            <form action="{{ route('profilemua.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-8">
                @csrf

                {{-- GRID ATAS: MEDIA (kiri) + INFO UTAMA (kanan) --}}
                <div class="grid gap-8 md:grid-cols-12">
                    {{-- MEDIA --}}
                    <section class="md:col-span-4 {{ $sec }} p-5">
                        <h3 class="text-base font-semibold text-slate-800 mb-4">Foto Profil</h3>

                        <div class="flex items-start gap-4">
                            <div class="w-32 h-40 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                <img id="preview" src="https://placehold.co/320x400?text=Foto"
                                    class="w-full h-full object-cover" alt="Foto">
                            </div>

                            <div class="flex-1">
                                <label class="{{ $lab }}">Unggah Foto</label>
                                <input type="file" name="foto" accept="image/*" onchange="previewImg(event)"
                                    class="block w-full rounded-xl border border-slate-300 file:mr-3 file:px-3 file:py-2 file:rounded-lg file:border-0 file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                                @error('foto') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
                                <p class="text-xs text-slate-500 mt-1">Format JPG/PNG, maks 2MB.</p>
                            </div>
                        </div>
                    </section>

                    {{-- INFORMASI UTAMA --}}
                    <section class="md:col-span-8 {{ $sec }} p-5">
                        <h3 class="text-base font-semibold text-slate-800 mb-4">Informasi Utama</h3>

                        <div class="grid gap-5">
                            <div>
                                <label class="{{ $lab }}">Nama MUA</label>
                                <input type="text" name="nama_usaha" value="{{ old('nama_usaha') }}" class="{{ $inp }}">
                                @error('nama_usaha') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="{{ $lab }}">Kontak WA</label>
                                    <input type="text" name="kontak_wa" value="{{ old('kontak_wa') }}" class="{{ $inp }}">
                                    @error('kontak_wa') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="{{ $lab }}">Alamat / Domisili</label>
                                    <input type="text" name="alamat" value="{{ old('alamat') }}" class="{{ $inp }}">
                                </div>
                            </div>

                            <div>
                                <label class="{{ $lab }}">Deskripsi singkat</label>
                                <textarea name="deskripsi" rows="5" class="{{ $inp }}">{{ old('deskripsi') }}</textarea>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- SOSIAL MEDIA --}}
                <section class="{{ $sec }} p-5">
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

                {{-- Sticky action bar --}}
                <div class="sticky bottom-0 inset-x-0">
                    <div class="bg-white/85 backdrop-blur border-t border-slate-200">
                        <div class="max-w-6xl mx-auto px-6 py-3 flex justify-end gap-3">

                            {{-- TOMBOL BATAL WARNA EMAS --}}
                            <a href="{{ route('mua.panel') }}"
                               class="px-4 py-2 rounded-xl border border-[#c98a00] bg-white text-[#c98a00] text-sm font-semibold
                                      hover:bg-[#fff9e6] hover:border-[#b27a00] hover:text-[#b27a00] transition">
                                Batal
                            </a>

                            {{-- TOMBOL SIMPAN PROFIL WARNA EMAS --}}
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl 
               bg-[#c98a00] text-white font-semibold text-sm shadow-md
               hover:bg-[#b27a00] active:bg-[#9a6d00] transition 
               focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#eab308] focus-visible:ring-offset-2">
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

        <footer class="mt-10 text-xs text-slate-500 text-center pb-8">
            © {{ date('Y') }} AdatKu — MUA Panel
        </footer>
    </div>

    {{-- Preview foto --}}
    <script>
        function previewImg(e) {
            const f = e.target.files?.[0]; if (!f) return;
            const r = new FileReader();
            r.onload = () => document.getElementById('preview').src = r.result;
            r.readAsDataURL(f);
        }
    </script>
@endsection
