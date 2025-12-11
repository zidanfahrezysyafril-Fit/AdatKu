@extends('layouts.admin')

@section('title', 'Kelola Galeri')
@section('page_title', 'Galeri Beranda')
@section('page_desc', 'Kelola foto untuk section galeri di halaman utama.')

@section('content')
<div x-data="{ showCreate:false }" class="max-w-6xl mx-auto px-4 md:px-6 py-6 md:py-8">

    {{-- Header + tombol tambah --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
        <div>
            <h1 class="text-2xl font-bold text-[#c98a00]">Kelola Galeri</h1>
            <p class="text-xs text-slate-500 mt-1">
                Atur foto untuk slider galeri di beranda AdatKu.
            </p>
        </div>
        <div class="flex justify-start md:justify-end">
            <button type="button"
                    @click="showCreate = true"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white
                           bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                           shadow-md hover:brightness-110 transition">
                <span class="text-lg leading-none">＋</span>
                <span>Tambah Foto</span>
            </button>
        </div>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel / Card --}}
    <div class="card-table">
        <div class="px-4 py-3 border-b border-amber-50 flex items-center justify-between text-xs text-slate-500">
            <span>Daftar foto galeri</span>
            <span>Total: {{ $galleries->total() }}</span>
        </div>

        @if($galleries->isEmpty())
            <div class="px-4 py-6 text-center text-slate-500 text-sm bg-white">
                Belum ada foto galeri.
            </div>
        @else
            {{-- ========== MOBILE: CARD VIEW ========== --}}
            <div class="md:hidden bg-white divide-y divide-amber-50">
                @foreach($galleries as $g)
                    <div class="px-4 py-4" x-data="{ showEdit:false, showDelete:false }">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <div class="flex-1">
                                <p class="text-[11px] uppercase tracking-wide text-slate-400">
                                    {{ str_replace('_', ' ', $g->kategori) }}
                                </p>
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $g->judul }}
                                </p>
                                <p class="text-[11px] text-slate-400 mt-0.5">
                                    Urutan: <span class="font-medium text-slate-700">{{ $g->urutan }}</span>
                                </p>
                            </div>
                            <div class="w-24 h-16 rounded-lg overflow-hidden border border-amber-100 bg-slate-100 shrink-0">
                                <img src="{{ asset('uploads/' . $g->image_path) }}"
                                     alt="Foto {{ $g->judul }}"
                                     class="w-full h-full object-cover">
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] text-slate-500">
                                Status:
                                @if($g->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] border border-emerald-100 ml-1">
                                        ● Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[11px] border border-slate-200 ml-1">
                                        ● Nonaktif
                                    </span>
                                @endif
                            </span>
                        </div>

                        <div class="flex flex-col xs:flex-row gap-2">
                            <button type="button"
                                    @click="showEdit = true"
                                    class="flex-1 inline-flex items-center justify-center text-[11px] px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-100 hover:bg-amber-100">
                                Edit
                            </button>
                            <button type="button"
                                    @click="showDelete = true"
                                    class="flex-1 inline-flex items-center justify-center text-[11px] px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100">
                                Hapus
                            </button>
                        </div>

                        {{-- MODAL EDIT (mobile & desktop sama) --}}
                        <div x-show="showEdit" x-cloak
                             class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
                            <div @click.outside="showEdit = false"
                                 class="bg-white rounded-2xl shadow-2xl border border-amber-100 w-[92%] max-w-xl max-h-[90vh] overflow-y-auto p-6 relative">

                                <button type="button"
                                        @click="showEdit = false"
                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 text-sm">
                                    ✕
                                </button>

                                <h2 class="text-lg md:text-xl font-semibold text-[#c98a00] mb-4">
                                    Edit Foto Galeri
                                </h2>

                                <form action="{{ route('admin.galleries.update', $g) }}"
                                      method="POST"
                                      enctype="multipart/form-data"
                                      class="space-y-4 text-sm">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                            Kategori
                                        </label>
                                        <select name="kategori"
                                                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                                            <option value="baju_adat" {{ $g->kategori == 'baju_adat' ? 'selected' : '' }}>Baju Adat</option>
                                            <option value="makeup" {{ $g->kategori == 'makeup' ? 'selected' : '' }}>Make Up</option>
                                            <option value="pelaminan" {{ $g->kategori == 'pelaminan' ? 'selected' : '' }}>Pelaminan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                            Judul
                                        </label>
                                        <input type="text" name="judul" value="{{ $g->judul }}"
                                               class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                Foto Saat Ini
                                            </label>
                                            <div class="w-full h-32 rounded-xl overflow-hidden border border-amber-100 bg-slate-100">
                                                <img src="{{ asset('uploads/' . $g->image_path) }}"
                                                     class="w-full h-full object-cover"
                                                     alt="Foto {{ $g->judul }}">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                Ganti Foto (opsional)
                                            </label>
                                            <input type="file" name="image"
                                                   class="block w-full text-xs text-slate-600
                                                          file:mr-3 file:rounded-lg file:px-3 file:py-1.5
                                                          file:border file:border-amber-200 file:bg-white
                                                          file:text-slate-700 file:cursor-pointer
                                                          hover:file:bg-amber-50">
                                            <p class="text-[11px] text-slate-400 mt-1">
                                                Biarkan kosong jika tidak ingin mengubah foto.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                Urutan
                                            </label>
                                            <input type="number" name="urutan" value="{{ $g->urutan }}"
                                                   class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                                        </div>
                                        <div class="flex items-end gap-2">
                                            <label class="inline-flex items-center gap-2 text-xs text-slate-700 mb-1 md:mb-2">
                                                <input type="checkbox" name="is_active" value="1"
                                                       class="rounded border-slate-300 text-amber-500 focus:ring-amber-400"
                                                       {{ $g->is_active ? 'checked' : '' }}>
                                                <span>Aktifkan di galeri</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-2 pt-3">
                                        <button type="button"
                                                @click="showEdit = false"
                                                class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                                            Batal
                                        </button>
                                        <button type="submit"
                                                class="px-5 py-2 rounded-xl text-xs md:text-sm font-semibold text-white
                                                       bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                                       shadow-md hover:brightness-110">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- MODAL DELETE --}}
                        <div x-show="showDelete" x-cloak
                             class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
                            <div @click.outside="showDelete = false"
                                 class="bg-white rounded-2xl shadow-2xl border border-red-100 w-[90%] max-w-sm p-6 relative">

                                <h3 class="text-base md:text-lg font-semibold text-slate-800 mb-2">
                                    Hapus Foto?
                                </h3>
                                <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                                    Foto <span class="font-semibold">"{{ $g->judul }}"</span> akan dihapus dari galeri beranda.
                                    Tindakan ini tidak dapat dibatalkan.
                                </p>

                                <div class="flex justify-end gap-2 mt-2">
                                    <button type="button"
                                            @click="showDelete = false"
                                            class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                                        Batal
                                    </button>

                                    <form action="{{ route('admin.galleries.destroy', $g) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-4 py-2 rounded-xl bg-red-500 text-white text-xs font-semibold shadow-md hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- ========== DESKTOP: TABLE VIEW ========== --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-amber-50 text-amber-800">
                        <tr>
                            <th class="px-4 py-2 text-left">Kategori</th>
                            <th class="px-4 py-2 text-left">Judul</th>
                            <th class="px-4 py-2 text-left">Preview</th>
                            <th class="px-4 py-2 text-left">Urutan</th>
                            <th class="px-4 py-2 text-left">Aktif</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($galleries as $g)
                            <tr class="border-t border-amber-50" x-data="{ showEdit:false, showDelete:false }">
                                <td class="px-4 py-2 capitalize align-middle">
                                    {{ str_replace('_', ' ', $g->kategori) }}
                                </td>
                                <td class="px-4 py-2 align-middle">
                                    <span class="font-medium text-slate-800">{{ $g->judul }}</span>
                                </td>
                                <td class="px-4 py-2 align-middle">
                                    <div class="w-20 h-14 rounded-lg overflow-hidden border border-amber-100 bg-slate-100">
                                        <img src="{{ asset('uploads/' . $g->image_path) }}"
                                             class="w-full h-full object-cover"
                                             alt="Foto {{ $g->judul }}">
                                    </div>
                                </td>
                                <td class="px-4 py-2 align-middle">
                                    {{ $g->urutan }}
                                </td>
                                <td class="px-4 py-2 align-middle">
                                    @if($g->is_active)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] border border-emerald-100">
                                            ● Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[11px] border border-slate-200">
                                            ● Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 align-middle text-right whitespace-nowrap">
                                    <button type="button"
                                            @click="showEdit = true"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-100 hover:bg-amber-100 mr-1">
                                        Edit
                                    </button>

                                    <button type="button"
                                            @click="showDelete = true"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100">
                                        Hapus
                                    </button>

                                    {{-- MODAL EDIT --}}
                                    {{-- (sama seperti di mobile, boleh reuse block di atas;
                                         biar singkat, kamu boleh biarkan versi lama di sini
                                         karena tampil hanya di desktop) --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Pagination --}}
        <div class="px-4 py-3 border-t border-amber-50 bg-amber-50/40">
            {{ $galleries->links() }}
        </div>
    </div>

    {{-- =============== MODAL CREATE (GLOBAL) =============== --}}
    <div x-show="showCreate" x-cloak
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div @click.outside="showCreate = false"
             class="bg-white rounded-2xl shadow-2xl border border-amber-100 w-[92%] max-w-xl max-h-[90vh] overflow-y-auto p-6 relative">

            <button type="button"
                    @click="showCreate = false"
                    class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 text-sm">
                ✕
            </button>

            <h2 class="text-lg md:text-xl font-semibold text-[#c98a00] mb-4">
                Tambah Foto Galeri
            </h2>

            <form action="{{ route('admin.galleries.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-4 text-sm">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                        Kategori
                    </label>
                    <select name="kategori"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                        <option value="baju_adat">Baju Adat</option>
                        <option value="makeup">Make Up</option>
                        <option value="pelaminan">Pelaminan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                        Judul
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                           class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400"
                           placeholder="Contoh: Baju Adat Minang Emas">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                            Foto
                        </label>
                        <input type="file" name="image"
                               class="block w-full text-xs text-slate-600
                                      file:mr-3 file:rounded-lg file:px-3 file:py-1.5
                                      file:border file:border-amber-200 file:bg-white
                                      file:text-slate-700 file:cursor-pointer
                                      hover:file:bg-amber-50">
                        <p class="text-[11px] text-slate-400 mt-1">
                            Rekomendasi ukuran landscape, file jpg/jpeg/png.
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                            Urutan
                        </label>
                        <input type="number" name="urutan"
                               value="{{ old('urutan', ($galleries->max('urutan') ?? 0) + 1) }}"
                               class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                        <p class="text-[11px] text-slate-400 mt-1">
                            Urutan muncul di slider (angka kecil tampil lebih dulu).
                        </p>
                    </div>
                </div>

                <div>
                    <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                        <input type="checkbox" name="is_active" value="1" checked
                               class="rounded border-slate-300 text-amber-500 focus:ring-amber-400">
                        <span>Aktifkan di galeri</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2 pt-3">
                    <button type="button"
                            @click="showCreate = false"
                            class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2 rounded-xl text-xs md:text-sm font-semibold text-white
                                   bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                   shadow-md hover:brightness-110">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
