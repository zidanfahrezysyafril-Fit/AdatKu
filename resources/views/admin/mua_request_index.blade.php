@extends('layouts.admin')

@section('title', 'Pengajuan MUA — Admin')
@section('page_title', 'Pengajuan MUA')
@section('page_desc', 'Kelola permintaan user yang ingin menjadi MUA')

@section('content')

    {{-- KARTU STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-rose-100 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Pending</p>
            <h3 class="text-3xl font-bold mt-1 text-amber-600">{{ $pending->count() }}</h3>
            <p class="text-xs text-slate-400 mt-1">Menunggu ditinjau admin</p>
        </div>
        <div class="bg-white border border-rose-100 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Disetujui</p>
            <h3 class="text-3xl font-bold mt-1 text-emerald-600">{{ $approved->count() }}</h3>
            <p class="text-xs text-slate-400 mt-1">Akan otomatis menjadi role MUA</p>
        </div>
        <div class="bg-white border border-rose-100 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Ditolak</p>
            <h3 class="text-3xl font-bold mt-1 text-rose-600">{{ $rejected->count() }}</h3>
            <p class="text-xs text-slate-400 mt-1">Bisa diajukan ulang oleh user</p>
        </div>
    </div>

    {{-- SECTION PENDING --}}
    <div class="bg-white border border-rose-100 rounded-2xl overflow-hidden mb-6">
        <div class="p-4 border-b border-rose-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold">Pengajuan Pending</h3>
                <p class="text-xs text-slate-500">Permintaan yang belum kamu proses.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-amber-50 text-amber-700">
                {{ $pending->count() }} pending
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-rose-50 text-slate-700">
                    <tr>
                        <th class="text-left py-3 px-4">#</th>
                        <th class="text-left py-3 px-4">User</th>
                        <th class="text-left py-3 px-4">Email</th>
                        <th class="text-left py-3 px-4">Nama Usaha</th>
                        <th class="text-left py-3 px-4">Kontak WA</th>
                        <th class="text-left py-3 px-4">Diajukan</th>
                        <th class="text-left py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pending as $index => $req)
                        <tr class="border-t border-rose-100 hover:bg-rose-50/40">
                            <td class="py-3 px-4 align-top">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 align-top">
                                {{ optional($req->user)->name ?? '-' }}
                                <div class="text-[11px] text-slate-400">
                                    ID: {{ $req->user_id }}
                                </div>
                            </td>
                            <td class="py-3 px-4 align-top">
                                {{ optional($req->user)->email ?? '-' }}
                            </td>
                            <td class="py-3 px-4 align-top">
                                <span class="font-medium">{{ $req->nama_usaha }}</span>
                                @if($req->alamat)
                                    <div class="text-[11px] text-slate-400">
                                        {{ $req->alamat }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4 align-top">
                                {{ $req->kontak_wa }}
                            </td>
                            <td class="py-3 px-4 align-top text-xs text-slate-500">
                                {{ $req->created_at?->format('d M Y H:i') }}
                            </td>
                            <td class="py-3 px-4 align-top">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('admin.mua-requests.show', $req) }}"
                                       class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs border border-rose-200 text-rose-700 hover:bg-rose-50">
                                        Detail
                                    </a>

                                    <form action="{{ route('admin.mua-requests.approve', $req) }}" method="POST"
                                          onsubmit="return confirm('Setujui pengajuan ini dan jadikan user sebagai MUA?');">
                                        @csrf
                                        <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs bg-emerald-500 text-white hover:bg-emerald-600">
                                            Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.mua-requests.reject', $req) }}" method="POST"
                                          onsubmit="return confirm('Tolak pengajuan ini?');">
                                        @csrf
                                        <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs bg-rose-500 text-white hover:bg-rose-600">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-4 text-center text-slate-500 text-sm">
                                Belum ada pengajuan yang menunggu persetujuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SECTION RIWAYAT (APPROVED + REJECTED) --}}
    <div class="bg-white border border-rose-100 rounded-2xl overflow-hidden">
        <div class="p-4 border-b border-rose-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold">Riwayat Pengajuan MUA</h3>
                <p class="text-xs text-slate-500">Pengajuan yang sudah diproses admin.</p>
            </div>
            <span class="text-xs text-slate-400">
                {{ $approved->count() }} disetujui · {{ $rejected->count() }} ditolak
            </span>
        </div>

        @php
            $history = $approved->concat($rejected)->sortByDesc('updated_at');
        @endphp

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-rose-50 text-slate-700">
                    <tr>
                        <th class="text-left py-3 px-4">User</th>
                        <th class="text-left py-3 px-4">Nama Usaha</th>
                        <th class="text-left py-3 px-4">Status</th>
                        <th class="text-left py-3 px-4">Catatan Admin</th>
                        <th class="text-left py-3 px-4">Diupdate</th>
                        <th class="text-left py-3 px-4"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($history as $req)
                        <tr class="border-t border-rose-100 hover:bg-rose-50/40">
                            <td class="py-3 px-4 align-top">
                                {{ optional($req->user)->name ?? '-' }}
                                <div class="text-[11px] text-slate-400">
                                    {{ optional($req->user)->email ?? '-' }}
                                </div>
                            </td>
                            <td class="py-3 px-4 align-top">
                                {{ $req->nama_usaha }}
                            </td>
                            <td class="py-3 px-4 align-top">
                                @if($req->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs bg-emerald-50 text-emerald-700">
                                        Disetujui
                                    </span>
                                @elseif($req->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs bg-rose-50 text-rose-700">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs bg-amber-50 text-amber-700">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 align-top text-xs text-slate-600 max-w-xs">
                                {{ $req->catatan_admin ?: '-' }}
                            </td>
                            <td class="py-3 px-4 align-top text-xs text-slate-500">
                                {{ $req->updated_at?->format('d M Y H:i') }}
                            </td>
                            <td class="py-3 px-4 align-top text-right">
                                <a href="{{ route('admin.mua-requests.show', $req) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs border border-rose-200 text-rose-700 hover:bg-rose-50">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-slate-500 text-sm">
                                Belum ada riwayat pengajuan yang diproses.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
