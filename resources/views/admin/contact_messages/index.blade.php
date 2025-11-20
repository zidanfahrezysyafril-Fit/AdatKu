@extends('layouts.admin') {{-- pastikan nama layout admin kamu sama, kalau beda tinggal sesuaikan --}}

@section('title', 'Pesan Hubungi Kami - Admin | AdatKu')

@section('content')
<div class="p-6">

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- HEADER + SUMMARY --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-[#c98a00]">
                Pesan Masuk
            </h2>
            <p class="text-sm text-slate-600">
                Daftar pesan dari halaman <span class="font-semibold">Hubungi Kami</span>.
            </p>
        </div>

        <div class="flex gap-3 text-sm">
            <div class="px-4 py-2 rounded-xl bg-white border border-amber-100 shadow-sm">
                <div class="text-[11px] uppercase tracking-wide text-slate-500">
                    Total Pesan
                </div>
                <div class="text-lg font-semibold">
                    {{ $messages->total() ?? $messages->count() }}
                </div>
            </div>

            @php
                $unreadCount = $messages->where('is_read', false)->count() ?? 0;
            @endphp
            <div class="px-4 py-2 rounded-xl bg-[#fff7cf] border border-amber-200 shadow-sm">
                <div class="text-[11px] uppercase tracking-wide text-slate-500">
                    Belum Dibaca
                </div>
                <div class="text-lg font-semibold text-[#b45309]">
                    {{ $unreadCount }}
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL PESAN --}}
    <div class="bg-white rounded-2xl shadow-md border border-amber-100 overflow-hidden">
        <div class="px-4 py-3 border-b border-amber-100 flex items-center justify-between gap-2">
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
                    <thead class="bg-[#fff7e0] text-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Pengirim</th>
                            <th class="px-4 py-3 text-left font-semibold">Kontak</th>
                            <th class="px-4 py-3 text-left font-semibold">Subjek & Pesan</th>
                            <th class="px-4 py-3 text-left font-semibold">Waktu</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                            <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-50">

                        @foreach ($messages as $message)
                            <tr class="{{ $message->is_read ? 'bg-white' : 'bg-amber-50/70' }}">
                                {{-- PENGIRIM --}}
                                <td class="px-4 py-3 align-top">
                                    <div class="font-semibold text-slate-800">
                                        {{ $message->nama }}
                                    </div>
                                </td>

                                {{-- KONTAK --}}
                                <td class="px-4 py-3 align-top text-slate-700">
                                    <div>
                                        <span class="text-xs text-slate-500">Email:</span><br>
                                        <a href="mailto:{{ $message->email }}" class="hover:underline text-[#c98a00]">
                                            {{ $message->email }}
                                        </a>
                                    </div>

                                    @if ($message->telepon)
                                        <div class="mt-1">
                                            <span class="text-xs text-slate-500">Telepon:</span><br>
                                            <span>{{ $message->telepon }}</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- SUBJEK & PESAN --}}
                                <td class="px-4 py-3 align-top">
                                    <div class="font-semibold text-slate-800 mb-1">
                                        {{ $message->subjek }}
                                    </div>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        {{ \Illuminate\Support\Str::limit($message->pesan, 120) }}
                                    </p>
                                </td>

                                {{-- WAKTU --}}
                                <td class="px-4 py-3 align-top text-xs text-slate-600">
                                    <div>
                                        {{ $message->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-[11px] text-slate-500">
                                        {{ $message->created_at->format('H:i') }} WIB
                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-3 align-top">
                                    @if ($message->is_read)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Sudah dibaca
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Belum dibaca
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-4 py-3 align-top">
                                    <div class="flex flex-col gap-1.5">

                                        @if (!$message->is_read)
                                            <form action="{{ route('admin.contact.read', $message->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full text-xs px-3 py-1.5 rounded-full bg-[#f7e07b] hover:bg-[#f5d547] text-slate-800 font-medium">
                                                    Tandai Dibaca
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-xs px-3 py-1.5 rounded-full bg-red-50 hover:bg-red-100 text-red-700 font-medium border border-red-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if (method_exists($messages, 'links'))
                <div class="px-4 py-3 border-t border-amber-100">
                    {{ $messages->links() }}
                </div>
            @endif

        @endif
    </div>

</div>
@endsection
