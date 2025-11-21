@extends('layouts.admin')

@section('title', 'Pesan Hubungi Kami - Admin | AdatKu')

@section('content')
{{-- STYLE KHUSUS HALAMAN INI --}}
<style>
    [x-cloak] { display: none !important; }

    @keyframes float-bubble {
        0%   { transform: translateY(0px) translateX(0px); opacity: 0; }
        20%  { opacity: 1; }
        50%  { transform: translateY(-14px) translateX(6px); }
        80%  { opacity: 1; }
        100% { transform: translateY(-26px) translateX(-4px); opacity: 0; }
    }

    @keyframes pop-scale {
        0%   { transform: scale(0.8); opacity: 0; }
        60%  { transform: scale(1.04); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }

    .popup-card {
        animation: pop-scale 0.32s ease-out;
    }

    .floating-emoji {
        animation: float-bubble 3.5s ease-in-out infinite;
    }
</style>

<div class="px-8 py-6"
     x-data="{
        showSuccess: {{ session()->has('success') ? 'true' : 'false' }},
        successMessage: @js(session('success')),
        confirmDeleteUrl: null,
        openDelete(url) { this.confirmDeleteUrl = url },
        closeDelete() { this.confirmDeleteUrl = null }
     }">

    {{-- HEADER ATAS (judul + card total) --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#c98a00] mb-1">
                Pesan Masuk
            </h1>
            <p class="text-sm text-slate-600">
                Daftar pesan dari halaman <span class="font-semibold">Hubungi Kami</span>.
            </p>
        </div>

        <div class="flex gap-4">
            {{-- TOTAL PESAN --}}
            <div class="bg-white rounded-2xl shadow border border-amber-100 px-5 py-3 min-w-[120px]">
                <p class="text-[11px] uppercase tracking-wide text-slate-500">
                    Total Pesan
                </p>
                <p class="text-2xl font-bold text-slate-800 mt-1">
                    {{ $messages->total() ?? $messages->count() }}
                </p>
            </div>

            @php
                $unreadCount = $messages->where('is_read', false)->count() ?? 0;
            @endphp

            {{-- BELUM DIBACA --}}
            <div class="bg-[#fff7cf] rounded-2xl shadow border border-amber-200 px-5 py-3 min-w-[120px]">
                <p class="text-[11px] uppercase tracking-wide text-slate-500">
                    Belum Dibaca
                </p>
                <p class="text-2xl font-bold text-[#b45309] mt-1">
                    {{ $unreadCount }}
                </p>
            </div>
        </div>
    </div>

    {{-- KOTAK TABEL --}}
    <div class="bg-white rounded-2xl shadow-md border border-amber-100 overflow-hidden">
        <div class="px-6 py-3 border-b border-amber-100 flex items-center justify-between gap-2 bg-[#fffdf7]">
            <span class="text-sm text-slate-600">
                Menampilkan <span class="font-semibold">{{ $messages->count() }}</span> pesan terakhir
            </span>
        </div>

        @if ($messages->isEmpty())
            <div class="p-6 text-center text-sm text-slate-500">
                Belum ada pesan yang masuk.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-[#fff3cf] text-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Pengirim</th>
                            <th class="px-6 py-3 text-left font-semibold">Kontak</th>
                            <th class="px-6 py-3 text-left font-semibold">Subjek &amp; Pesan</th>
                            <th class="px-6 py-3 text-left font-semibold">Waktu</th>
                            <th class="px-6 py-3 text-left font-semibold">Status</th>
                            <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-50">

                        @foreach ($messages as $message)
                            <tr class="{{ $message->is_read ? 'bg-white' : 'bg-amber-50/60' }}">
                                {{-- PENGIRIM --}}
                                <td class="px-6 py-4 align-top">
                                    <p class="font-semibold text-slate-800">
                                        {{ $message->nama }}
                                    </p>
                                </td>

                                {{-- KONTAK --}}
                                <td class="px-6 py-4 align-top text-slate-700">
                                    <div>
                                        <span class="text-xs text-slate-500">Email:</span><br>
                                        <a href="mailto:{{ $message->email }}"
                                           class="hover:underline text-[#c98a00]">
                                            {{ $message->email }}
                                        </a>
                                    </div>

                                    @if ($message->telepon)
                                        <div class="mt-2">
                                            <span class="text-xs text-slate-500">Telepon:</span><br>
                                            <span>{{ $message->telepon }}</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- SUBJEK & PESAN --}}
                                <td class="px-6 py-4 align-top">
                                    <p class="font-semibold text-slate-800 mb-1">
                                        {{ $message->subjek }}
                                    </p>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        {{ \Illuminate\Support\Str::limit($message->pesan, 120) }}
                                    </p>
                                </td>

                                {{-- WAKTU (dipaksa ke Asia/Jakarta) --}}
                                <td class="px-6 py-4 align-top text-xs text-slate-600">
                                    <div>
                                        {{ $message->created_at->timezone('Asia/Jakarta')->format('d M Y') }}
                                    </div>
                                    <div class="text-[11px] text-slate-500">
                                        {{ $message->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB
                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4 align-top">
                                    @if ($message->is_read)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Sudah dibaca
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Belum dibaca
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-col gap-1.5">

                                        @if (! $message->is_read)
                                            <form action="{{ route('admin.contact.read', $message->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="w-full text-xs px-3 py-1.5 rounded-full bg-[#f7e07b] hover:bg-[#f5d547] text-slate-800 font-medium">
                                                    Tandai Dibaca
                                                </button>
                                            </form>
                                        @endif

                                        {{-- tombol Hapus buka modal --}}
                                        <button type="button"
                                                @click="openDelete('{{ route('admin.contact.destroy', $message->id) }}')"
                                                class="w-full text-xs px-3 py-1.5 rounded-full bg-red-50 hover:bg-red-100 text-red-700 font-medium border border-red-200">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if (method_exists($messages, 'links'))
                <div class="px-6 py-3 border-t border-amber-100 bg-[#fffdf7]">
                    {{ $messages->links() }}
                </div>
            @endif

        @endif
    </div>

    {{-- ========== POPUP SUKSES (SETELAH DIBACA / DIHAPUS) ========== --}}
    <div x-cloak
         x-show="showSuccess"
         x-transition.opacity
         class="fixed inset-0 z-40 flex items-center justify-center bg-black/30 backdrop-blur-sm"
         @keydown.escape.window="showSuccess = false">

        <div class="popup-card bg-gradient-to-br from-[#fff9fb] via-white to-[#fff3d7]
                    rounded-3xl shadow-2xl border border-amber-100 max-w-md w-full mx-4 p-6 relative overflow-hidden">

            {{-- bubble / ornamen --}}
            <div class="absolute -top-6 -left-4 w-16 h-16 rounded-full bg-amber-100/60 blur-md"></div>
            <div class="absolute -bottom-10 -right-6 w-24 h-24 rounded-full bg-rose-100/60 blur-xl"></div>

            {{-- emoji melayang --}}
            <div class="absolute top-4 right-6 text-2xl floating-emoji delay-100">✨</div>
            <div class="absolute bottom-6 left-6 text-2xl floating-emoji delay-300">💌</div>
            <div class="absolute top-10 left-1/2 -translate-x-1/2 text-xl floating-emoji delay-700">🎉</div>

            <div class="relative">
                {{-- icon utama --}}
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center mb-4 border border-emerald-100">
                    <span class="text-3xl">✅</span>
                </div>

                <h2 class="text-xl font-semibold text-slate-800 mb-1">
                    Yeay, berhasil! 🎊
                </h2>
                <p class="text-sm text-slate-600 mb-4" x-text="successMessage"></p>

                <div class="flex items-center justify-between text-[11px] text-slate-400 mb-3">
                    <span>Terima kasih sudah merapikan pesan masuk ✨</span>
                    <span>AdatKu Admin Panel</span>
                </div>

                <div class="flex justify-end">
                    <button type="button"
                            @click="showSuccess = false"
                            class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 text-sm hover:bg-slate-50">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ========== POPUP KONFIRMASI HAPUS ========== --}}
    <div x-cloak
         x-show="confirmDeleteUrl"
         x-transition.opacity
         class="fixed inset-0 z-40 flex items-center justify-center bg-black/30 backdrop-blur-sm"
         @keydown.escape.window="closeDelete()">

        <div class="popup-card bg-gradient-to-br from-white via-[#fff5f5] to-[#ffe4e6]
                    rounded-3xl shadow-2xl border border-rose-100 max-w-md w-full mx-4 p-6 relative overflow-hidden">

            {{-- bubble warna --}}
            <div class="absolute -top-8 -right-10 w-24 h-24 rounded-full bg-rose-100/70 blur-xl"></div>
            <div class="absolute -bottom-10 -left-6 w-20 h-20 rounded-full bg-amber-100/70 blur-xl"></div>

            {{-- emoji melayang --}}
            <div class="absolute top-4 left-5 text-2xl floating-emoji delay-150">⚠️</div>
            <div class="absolute bottom-4 right-8 text-2xl floating-emoji delay-550">🗑️</div>

            <div class="relative">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center mb-4 border border-rose-100">
                    <span class="text-3xl">😢</span>
                </div>

                <h2 class="text-xl font-semibold text-slate-800 mb-1">
                    Hapus pesan ini?
                </h2>
                <p class="text-sm text-slate-600 mb-3">
                    Pesan yang dihapus <span class="font-semibold">tidak bisa dikembalikan</span>.
                    Yakin kamu mau menghapus pesan dari pengguna ini?
                </p>

                <div class="flex items-center gap-2 text-[11px] text-slate-500 mb-4 flex-wrap">
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-white/60 border border-slate-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                        Tindakan permanen
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-white/60 border border-amber-200">
                        🧹 Bersihin kotak masuk
                    </span>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button"
                            @click="closeDelete()"
                            class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 text-sm hover:bg-slate-50">
                        Batal aja
                    </button>

                    <form :action="confirmDeleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 rounded-full bg-rose-500 text-white text-sm font-semibold hover:bg-rose-600 shadow-sm flex items-center gap-1">
                            <span>Ya, hapus</span> <span>🗑️</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
