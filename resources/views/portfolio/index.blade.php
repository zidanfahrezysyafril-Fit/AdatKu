@extends('layouts.app')
@section('title', 'Dokumentasi Kerja - MUA')

@section('content')
    <div class="w-full px-4 sm:px-6 lg:px-10 pt-5 pb-8">

        {{-- PAPER WRAPPER --}}
        <div
            class="max-w-6xl mx-auto bg-[#fffdf8]/95 border border-amber-100/80 rounded-[32px] shadow-[0_20px_70px_rgba(15,23,42,0.08)] px-4 sm:px-7 lg:px-9 py-6 sm:py-7 space-y-6">

            {{-- Flash message --}}
            @if (session('success') || session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition.opacity
                    class="mb-2 flex items-start gap-3 px-4 py-3 rounded-2xl border text-sm shadow-sm
                                @if (session('success')) bg-emerald-50 border-emerald-200 text-emerald-800
                                @else bg-red-50 border-red-200 text-red-700 @endif">
                    <div class="font-semibold">
                        {{ session('success') ?? session('error') }}
                    </div>
                    <button @click="show = false" class="ml-auto text-xs font-semibold uppercase tracking-wide">
                        Tutup
                    </button>
                </div>
            @endif

            {{-- HEADER HALAMAN --}}
            <div
                class="bg-gradient-to-r from-amber-50 via-rose-50 to-amber-50 rounded-3xl border border-amber-100/60 shadow-sm px-5 sm:px-7 py-5 flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1 space-y-1.5">
                    <p class="text-[11px] font-semibold tracking-[0.25em] uppercase text-amber-500">
                        Mua Panel • Dokumentasi
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">
                        Dokumentasi Kerja MUA
                    </h1>
                    <p class="text-sm text-slate-600 max-w-2xl">
                        Upload foto-foto hasil makeup, busana adat, dan pelaminan terbaikmu agar calon pelanggan
                        bisa melihat portofolio kerja kamu ✨
                    </p>
                </div>

                <div
                    class="inline-flex items-center gap-2 rounded-2xl bg-white/90 border border-amber-100 px-4 py-2 text-xs sm:text-sm text-amber-700 shadow-sm">
                    <span class="text-lg">📸</span>
                    <div class="leading-tight">
                        <p class="font-semibold">{{ $portfolios->count() }} dokumentasi</p>
                        <p class="text-[11px] text-slate-500">Tampilkan hasil terbaikmu</p>
                    </div>
                </div>
            </div>

            {{-- KOTAK UPLOAD --}}
            <div class="bg-white/98 rounded-3xl shadow-sm ring-1 ring-amber-100/80 p-5 sm:p-6 space-y-5">
                <div class="flex items-center gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Tambah Foto Dokumentasi</h2>
                        <p class="text-xs text-slate-500">
                            Kamu bisa memilih lebih dari satu foto dalam sekali upload.
                        </p>
                    </div>
                </div>

                <form action="{{ route('mua.portfolio.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">
                            Pilih Foto Dokumentasi
                        </label>

                        {{-- DROPZONE --}}
                        <label
                            class="flex flex-col items-center justify-center gap-2 w-full rounded-2xl border-2 border-dashed border-amber-200 bg-amber-50/40 px-4 py-6 cursor-pointer hover:border-amber-400 hover:bg-amber-50 transition">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-2xl">📁</span>
                                <span class="text-sm font-semibold text-slate-800">
                                    Klik untuk memilih foto
                                </span>
                            </div>

                            <input id="fotoInput" type="file" name="foto[]" accept="image/*" multiple class="hidden">
                        </label>

                        @error('foto')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        @error('foto.*')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PREVIEW FOTO SEBELUM UPLOAD --}}
                    <div id="previewWrapper" class="space-y-2 hidden">
                        <p class="text-xs font-semibold text-slate-700">
                            Preview foto yang akan di-upload
                        </p>
                        <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-3"></div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                        <p class="text-[11px] text-slate-500">
                            Gunakan foto yang jelas dan berkualitas baik agar portofolio kamu terlihat profesional.
                        </p>

                        {{-- TOMBOL UPLOAD GOLD TANPA GRADIENT --}}
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full text-sm font-semibold
                                       text-white bg-[#D4A017]
                                       shadow-[0_10px_25px_rgba(212,160,23,0.45)]
                                       hover:brightness-110 hover:shadow-[0_14px_35px_rgba(212,160,23,0.55)]
                                       active:translate-y-[1px] transition">
                            <span>Upload Foto</span>
                            <span class="text-base leading-none">↑</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- GALERI FOTO --}}
            <div class="bg-white/98 rounded-3xl shadow-sm ring-1 ring-amber-100/80 p-5 sm:p-6 space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-semibold text-slate-900">Galeri Dokumentasi</h2>
                        <span
                            class="text-xs px-3 py-0.5 rounded-full bg-amber-50 text-amber-700 ring-1 ring-amber-100 font-semibold">
                            {{ $portfolios->count() }} foto
                        </span>
                    </div>

                    @if (!$portfolios->isEmpty())
                        <p class="text-[11px] text-slate-500">
                            Hover di foto untuk menghapus jika ada yang kurang sesuai.
                        </p>
                    @endif
                </div>

                @if ($portfolios->isEmpty())
                    <div
                        class="border border-dashed border-amber-200 rounded-2xl bg-amber-50/40 px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada foto dokumentasi yang diupload.
                        <span class="font-semibold text-amber-700"> Yuk mulai upload hasil kerja terbaikmu! ✨</span>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($portfolios as $item)
                            <div
                                class="group relative bg-slate-900/5 rounded-3xl shadow-sm overflow-hidden ring-1 ring-amber-100/60 hover:ring-amber-300 transition">
                                <img src="{{ asset($item->foto_path) }}"
                                    class="w-full h-40 md:h-44 object-cover group-hover:scale-105 transition-transform duration-300"
                                    alt="Dokumentasi MUA">

                                {{-- badge tanggal kecil --}}
                                @if ($item->created_at)
                                    <span
                                        class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-black/45 backdrop-blur text-[10px] text-amber-50 font-medium">
                                        {{ $item->created_at->format('d M Y') }}
                                    </span>
                                @endif

                                {{-- overlay tombol hapus --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent
                                                       opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end">
                                    <form action="{{ route('mua.portfolio.destroy', $item) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-xs sm:text-[13px] font-medium text-white text-center py-2.5
                                                               bg-red-500/95 hover:bg-red-500 border-t border-white/10">
                                            Hapus Foto Ini
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div> {{-- /paper wrapper --}}
    </div>

    {{-- SCRIPT PREVIEW FOTO (bisa hapus sebelum upload) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('fotoInput');
            const previewWrapper = document.getElementById('previewWrapper');
            const previewContainer = document.getElementById('previewContainer');

            if (!input) return;

            // render ulang preview berdasarkan input.files
            function renderPreview() {
                const files = Array.from(input.files || []);
                previewContainer.innerHTML = '';

                if (!files.length) {
                    previewWrapper.classList.add('hidden');
                    return;
                }

                previewWrapper.classList.remove('hidden');

                files.forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const sizeKB = (file.size / 1024).toFixed(1);

                        const card = document.createElement('div');
                        card.className =
                            'relative bg-amber-50/60 border border-amber-100 rounded-2xl overflow-hidden shadow-sm';

                        card.innerHTML = `
                                <button type="button"
                                    data-index="${index}"
                                    class="absolute top-1.5 right-1.5 z-10 px-2 py-0.5 rounded-full
                                           bg-red-500/95 hover:bg-red-600 text-[10px] text-white shadow-sm">
                                    ✕
                                </button>

                                <div class="w-full h-24 bg-slate-100 overflow-hidden">
                                    <img src="${e.target.result}" class="w-full h-full object-cover" />
                                </div>
                                <div class="px-2.5 py-2">
                                    <p class="text-[11px] font-semibold text-slate-800 line-clamp-1"
                                       title="${file.name}">
                                       ${file.name}
                                    </p>
                                    <p class="text-[10px] text-slate-500">${sizeKB} KB</p>
                                </div>
                            `;

                        // masukkan card ke container
                        previewContainer.appendChild(card);

                        // pasang listener hapus untuk tombol ✕ di card ini
                        const btn = card.querySelector('button[data-index]');
                        btn.addEventListener('click', function () {
                            removeFileAt(index);
                        });
                    };

                    reader.readAsDataURL(file);
                });
            }

            // hapus satu file dari input.files
            function removeFileAt(removeIndex) {
                const dataTransfer = new DataTransfer();
                const currentFiles = Array.from(input.files || []);

                currentFiles.forEach((file, index) => {
                    if (index !== removeIndex) {
                        dataTransfer.items.add(file);
                    }
                });

                input.files = dataTransfer.files;
                renderPreview();
            }

            // setiap kali pilih file, render preview
            input.addEventListener('change', renderPreview);
        });
    </script>
@endsection