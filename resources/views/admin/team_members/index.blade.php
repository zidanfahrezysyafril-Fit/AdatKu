@extends('layouts.admin')

@section('title', 'Kelola Tim Pengembang')
@section('page_title', 'Tim Pengembang')
@section('page_desc', 'Kelola foto, urutan, dan status tampil anggota tim di section "Di Balik AdatKu" di halaman utama.')

@section('content')
    <div x-data="{ showCreate:false }" class="max-w-6xl mx-auto px-4 md:px-6 py-6 md:py-8">

        {{-- Header + tombol tambah --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
            <div>
                <h1 class="text-2xl font-bold text-[#c98a00]">Kelola Tim Pengembang</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Di sini kamu hanya mengatur <span class="font-semibold">foto, urutan, dan status tampil</span>.
                    Nama, peran, dan divisi anggota tim dikunci dari tampilan beranda.
                </p>
            </div>
            <div class="flex justify-start md:justify-end">
                <button type="button" @click="showCreate = true"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white
                               bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                               shadow-md hover:brightness-110 transition">
                    <span class="text-lg leading-none">＋</span>
                    <span>Tambah TIM</span>
                </button>
            </div>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        {{-- List / Tabel --}}
        <div class="card-table border border-amber-50 rounded-2xl overflow-hidden bg-white shadow-[0_10px_30px_rgba(0,0,0,0.03)]">
            <div class="px-4 py-3 border-b border-amber-50 flex items-center justify-between text-xs text-slate-500 bg-amber-50/40">
                <span>Daftar anggota tim</span>
            </div>

            @if($teamMembers->isEmpty())
                <div class="px-4 py-6 bg-white text-center text-slate-500 text-sm">
                    Belum ada anggota tim ditambahkan.
                </div>
            @else
                {{-- ========== MOBILE: CARD VIEW ========== --}}
                <div class="md:hidden bg-white divide-y divide-amber-50">
                    @foreach($teamMembers as $m)
                        @php
                            $photoUrl = $m->photo
                                ? asset('storage/' . $m->photo)
                                : 'https://placehold.co/80x80?text=' . urlencode(\Illuminate\Support\Str::limit($m->name, 2, ''));
                        @endphp

                        <div class="px-4 py-4" x-data="{ showEdit:false, showDelete:false }">
                            <div class="flex items-start gap-3 mb-2">
                                <div class="w-14 h-14 rounded-full overflow-hidden border border-amber-100 bg-slate-100 shrink-0">
                                    <img src="{{ $photoUrl }}" class="w-full h-full object-cover" alt="{{ $m->name }}">
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $m->name }}
                                    </p>
                                    <p class="text-[11px] text-slate-500">
                                        {{ $m->role ?: '—' }}
                                    </p>
                                    <p class="text-[11px] text-slate-400">
                                        Divisi: {{ $m->division ?: '—' }}
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        Urutan: <span class="font-medium text-slate-700">{{ $m->urutan }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-3">
                                @if($m->is_active)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] border border-emerald-100">
                                        ● Aktif di beranda
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[11px] border border-slate-200">
                                        ● Disembunyikan
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-col xs:flex-row gap-2">
                                <button type="button" @click="showEdit = true"
                                        class="flex-1 text-[11px] px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-100 hover:bg-amber-100">
                                    Edit
                                </button>

                                <button type="button" @click="showDelete = true"
                                        class="flex-1 text-[11px] px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100">
                                    Hapus
                                </button>
                            </div>

                            {{-- MODAL EDIT (MOBILE) --}}
                            <div x-show="showEdit" x-cloak
                                 x-transition.opacity
                                 class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
                                <div @click.outside="showEdit = false"
                                     class="bg-white rounded-2xl shadow-2xl border border-amber-100 w-[92%] max-w-xl max-h-[90vh] overflow-y-auto p-6 relative">

                                    <button type="button" @click="showEdit = false"
                                            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 text-sm">
                                        ✕
                                    </button>

                                    <h2 class="text-lg md:text-xl font-semibold text-[#c98a00] mb-4">
                                        Edit Anggota Tim
                                    </h2>

                                    <form action="{{ route('admin.team-members.update', $m) }}" method="POST"
                                          enctype="multipart/form-data" class="space-y-4 text-sm">
                                        @csrf
                                        @method('PUT')

                                        <div class="grid grid-cols-1 md:grid-cols-[1.1fr,1fr] gap-4">
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                    Nama Lengkap
                                                </label>
                                                <p class="text-sm font-semibold text-slate-800">
                                                    {{ $m->name }}
                                                </p>
                                                <p class="text-[11px] text-slate-400 mt-1">
                                                    Teks nama dikunci dan mengikuti pengaturan di beranda.
                                                </p>
                                                <input type="hidden" name="name" value="{{ $m->name }}">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                    Urutan
                                                </label>
                                                <input type="number" name="urutan" value="{{ $m->urutan }}"
                                                       class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                    Peran (role)
                                                </label>
                                                <p class="text-sm text-slate-700">
                                                    {{ $m->role ?: '-' }}
                                                </p>
                                                <p class="text-[11px] text-slate-400 mt-1">
                                                    Teks peran dikunci di tampilan beranda.
                                                </p>
                                                <input type="hidden" name="role" value="{{ $m->role }}">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                    Divisi
                                                </label>
                                                <p class="text-sm text-slate-700">
                                                    {{ $m->division ?: '-' }}
                                                </p>
                                                <p class="text-[11px] text-slate-400 mt-1">
                                                    Teks divisi dikunci di tampilan beranda.
                                                </p>
                                                <input type="hidden" name="division" value="{{ $m->division }}">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                    Foto Saat Ini
                                                </label>
                                                <div
                                                    class="w-full h-32 rounded-xl overflow-hidden border border-amber-100 bg-slate-100">
                                                    <img src="{{ $photoUrl }}" class="w-full h-full object-cover"
                                                         alt="{{ $m->name }}">
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                    Ganti Foto (opsional)
                                                </label>
                                                <input type="file" name="photo" class="block w-full text-xs text-slate-600
                                                                  file:mr-3 file:rounded-lg file:px-3 file:py-1.5
                                                                  file:border file:border-amber-200 file:bg-white
                                                                  file:text-slate-700 file:cursor-pointer
                                                                  hover:file:bg-amber-50">
                                                <p class="text-[11px] text-slate-400 mt-1">
                                                    Biarkan kosong jika tidak ingin mengubah foto.
                                                </p>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                                                <input type="checkbox" name="is_active" value="1"
                                                       class="rounded border-slate-300 text-amber-500 focus:ring-amber-400"
                                                       {{ $m->is_active ? 'checked' : '' }}>
                                                <span>Tampilkan di halaman beranda</span>
                                            </label>
                                        </div>

                                        <div class="flex justify-end gap-2 pt-3">
                                            <button type="button" @click="showEdit = false"
                                                    class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                                                Batal
                                            </button>
                                            <button type="submit" class="px-5 py-2 rounded-xl text-xs md:text-sm font-semibold text-white
                                                               bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                                               shadow-md hover:brightness-110">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- MODAL DELETE (MOBILE) --}}
                            <div x-show="showDelete" x-cloak
                                 x-transition.opacity
                                 class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
                                <div @click.outside="showDelete = false"
                                     class="bg-white rounded-2xl shadow-2xl border border-red-100 w-[90%] max-w-sm p-6 relative">

                                    <h3 class="text-base md:text-lg font-semibold text-slate-800 mb-2">
                                        Hapus Anggota?
                                    </h3>
                                    <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                                        Anggota <span class="font-semibold">"{{ $m->name }}"</span> akan dihapus dari
                                        daftar tim.
                                        Tindakan ini tidak dapat dibatalkan.
                                    </p>

                                    <div class="flex justify-end gap-2 mt-2">
                                        <button type="button" @click="showDelete = false"
                                                class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                                            Batal
                                        </button>

                                        <form action="{{ route('admin.team-members.destroy', $m) }}" method="POST">
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
                                <th class="px-4 py-2 text-left">Foto</th>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-left">Peran</th>
                                <th class="px-4 py-2 text-left">Divisi</th>
                                <th class="px-4 py-2 text-left">Urutan</th>
                                <th class="px-4 py-2 text-left">Aktif</th>
                                <th class="px-4 py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($teamMembers as $m)
                                @php
                                    $photoUrl = $m->photo
                                        ? asset('storage/' . $m->photo)
                                        : 'https://placehold.co/80x80?text=' . urlencode(\Illuminate\Support\Str::limit($m->name, 2, ''));
                                @endphp

                                <tr class="border-t border-amber-50" x-data="{ showEdit:false, showDelete:false }">
                                    <td class="px-4 py-2 align-middle">
                                        <div class="w-12 h-12 rounded-full overflow-hidden border border-amber-100 bg-slate-100">
                                            <img src="{{ $photoUrl }}" class="w-full h-full object-cover" alt="{{ $m->name }}">
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 align-middle">
                                        <span class="font-semibold text-slate-800 text-sm">{{ $m->name }}</span>
                                    </td>
                                    <td class="px-4 py-2 align-middle">
                                        <span class="text-xs text-slate-600">{{ $m->role }}</span>
                                    </td>
                                    <td class="px-4 py-2 align-middle">
                                        <span class="text-xs text-slate-600">{{ $m->division }}</span>
                                    </td>
                                    <td class="px-4 py-2 align-middle">
                                        {{ $m->urutan }}
                                    </td>
                                    <td class="px-4 py-2 align-middle">
                                        @if($m->is_active)
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
                                        <button type="button" @click="showEdit = true"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-100 hover:bg-amber-100 mr-1">
                                            Edit
                                        </button>

                                        <button type="button" @click="showDelete = true"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </td>

                                    {{-- MODAL EDIT (DESKTOP) - TELEPORT KE BODY --}}
                                    <template x-teleport="body">
                                        <div x-show="showEdit" x-cloak
                                             x-transition.opacity
                                             class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
                                            <div @click.outside="showEdit = false"
                                                 class="bg-white rounded-2xl shadow-2xl border border-amber-100 w-[92%] max-w-2xl max-h-[90vh] overflow-y-auto p-6 relative">

                                                <button type="button" @click="showEdit = false"
                                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 text-sm">
                                                    ✕
                                                </button>

                                                <h2 class="text-lg md:text-xl font-semibold text-[#c98a00] mb-4">
                                                    Edit Anggota Tim
                                                </h2>

                                                <form action="{{ route('admin.team-members.update', $m) }}" method="POST"
                                                      enctype="multipart/form-data" class="space-y-4 text-sm">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="grid grid-cols-1 md:grid-cols-[1.1fr,1fr] gap-4">
                                                        <div>
                                                            <label
                                                                class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                                Nama Lengkap
                                                            </label>
                                                            <p class="text-sm font-semibold text-slate-800">
                                                                {{ $m->name }}
                                                            </p>
                                                            <p class="text-[11px] text-slate-400 mt-1">
                                                                Teks nama dikunci dan mengikuti pengaturan di beranda.
                                                            </p>
                                                            <input type="hidden" name="name" value="{{ $m->name }}">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                                Urutan
                                                            </label>
                                                            <input type="number" name="urutan" value="{{ $m->urutan }}"
                                                                   class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                                                        </div>
                                                    </div>

                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                                Peran (role)
                                                            </label>
                                                            <p class="text-sm text-slate-700">
                                                                {{ $m->role ?: '-' }}
                                                            </p>
                                                            <p class="text-[11px] text-slate-400 mt-1">
                                                                Teks peran dikunci di tampilan beranda.
                                                            </p>
                                                            <input type="hidden" name="role" value="{{ $m->role }}">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                                Divisi
                                                            </label>
                                                            <p class="text-sm text-slate-700">
                                                                {{ $m->division ?: '-' }}
                                                            </p>
                                                            <p class="text-[11px] text-slate-400 mt-1">
                                                                Teks divisi dikunci di tampilan beranda.
                                                            </p>
                                                            <input type="hidden" name="division" value="{{ $m->division }}">
                                                        </div>
                                                    </div>

                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                                Foto Saat Ini
                                                            </label>
                                                            <div
                                                                class="w-full h-32 rounded-xl overflow-hidden border border-amber-100 bg-slate-100">
                                                                <img src="{{ $photoUrl }}" class="w-full h-full object-cover"
                                                                     alt="{{ $m->name }}">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                                                Ganti Foto (opsional)
                                                            </label>
                                                            <input type="file" name="photo" class="block w-full text-xs text-slate-600
                                                                              file:mr-3 file:rounded-lg file:px-3 file:py-1.5
                                                                              file:border file:border-amber-200 file:bg-white
                                                                              file:text-slate-700 file:cursor-pointer
                                                                              hover:file:bg-amber-50">
                                                            <p class="text-[11px] text-slate-400 mt-1">
                                                                Biarkan kosong jika tidak ingin mengubah foto.
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                                                            <input type="checkbox" name="is_active" value="1"
                                                                   class="rounded border-slate-300 text-amber-500 focus:ring-amber-400"
                                                                   {{ $m->is_active ? 'checked' : '' }}>
                                                            <span>Tampilkan di halaman beranda</span>
                                                        </label>
                                                    </div>

                                                    <div class="flex justify-end gap-2 pt-3">
                                                        <button type="button" @click="showEdit = false"
                                                                class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="px-5 py-2 rounded-xl text-xs md:text-sm font-semibold text-white
                                                                           bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                                                           shadow-md hover:brightness-110">
                                                            Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- MODAL DELETE (DESKTOP) - TELEPORT KE BODY --}}
                                    <template x-teleport="body">
                                        <div x-show="showDelete" x-cloak
                                             x-transition.opacity
                                             class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
                                            <div @click.outside="showDelete = false"
                                                 class="bg-white rounded-2xl shadow-2xl border border-red-100 w-[90%] max-w-sm p-6 relative">

                                                <h3 class="text-base md:text-lg font-semibold text-slate-800 mb-2">
                                                    Hapus Anggota?
                                                </h3>
                                                <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                                                    Anggota <span class="font-semibold">"{{ $m->name }}"</span> akan dihapus dari
                                                    daftar tim.
                                                    Tindakan ini tidak dapat dibatalkan.
                                                </p>

                                                <div class="flex justify-end gap-2 mt-2">
                                                    <button type="button" @click="showDelete = false"
                                                            class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                                                        Batal
                                                    </button>

                                                    <form action="{{ route('admin.team-members.destroy', $m) }}" method="POST">
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
                                    </template>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Pagination --}}
            <div class="px-4 py-3 border-t border-amber-50 bg-amber-50/40">
                {{ $teamMembers->links() }}
            </div>
        </div>

        {{-- =============== MODAL CREATE (GLOBAL) =============== --}}
        <div x-show="showCreate" x-cloak
            x-transition.opacity
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div @click.outside="showCreate = false"
                class="bg-white rounded-2xl shadow-2xl border border-amber-100 w-[92%] max-w-xl max-h-[90vh] overflow-y-auto p-6 relative">

                <button type="button" @click="showCreate = false"
                    class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 text-sm">
                    ✕
                </button>

                <h2 class="text-lg md:text-xl font-semibold text-[#c98a00] mb-4">
                    Tambah Anggota Tim
                </h2>

                <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4 text-sm">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-[1.1fr,1fr] gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                Nama / Keterangan
                            </label>
                            <p class="text-sm text-slate-700">
                                Teks nama, peran, dan divisi yang tampil di beranda
                                sudah dikunci di file <span class="font-semibold">home.blade.php</span>.
                            </p>
                            <p class="text-[11px] text-slate-400 mt-1">
                                Dari sini kamu hanya menambahkan slot baru (foto & urutan) bila diperlukan.
                            </p>

                            {{-- Hidden default supaya validasi controller tetap aman --}}
                            <input type="hidden" name="name" value="{{ old('name', 'Anggota Tim') }}">
                            <input type="hidden" name="role" value="{{ old('role', 'Peran Tim') }}">
                            <input type="hidden" name="division" value="{{ old('division', 'Divisi') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                Urutan
                            </label>
                            <input type="number" name="urutan"
                                   value="{{ old('urutan', ($teamMembers->max('urutan') ?? 0) + 1) }}"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                            <p class="text-[11px] text-slate-400 mt-1">
                                Urutan tampilan di beranda (kartu tengah bisa kamu atur dari urutan).
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-[0.12em]">
                                Foto
                            </label>
                            <input type="file" name="photo" class="block w-full text-xs text-slate-600
                                          file:mr-3 file:rounded-lg file:px-3 file:py-1.5
                                          file:border file:border-amber-200 file:bg-white
                                          file:text-slate-700 file:cursor-pointer
                                          hover:file:bg-amber-50">
                            <p class="text-[11px] text-slate-400 mt-1">
                                Rekomendasi foto square (1:1), jpg/jpeg/png.
                            </p>
                        </div>
                        <div class="flex items-end">
                            <label class="inline-flex items-center gap-2 text-xs text-slate-700">
                                <input type="checkbox" name="is_active" value="1" checked
                                    class="rounded border-slate-300 text-amber-500 focus:ring-amber-400">
                                <span>Tampilkan di halaman beranda</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-3">
                        <button type="button" @click="showCreate = false"
                            class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-xs md:text-sm font-semibold text-white
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
