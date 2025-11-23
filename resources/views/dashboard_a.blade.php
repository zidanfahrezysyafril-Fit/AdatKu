@extends('layouts.admin')

@section('title', 'Dashboard — Admin')
@section('page_title', 'Dashboard')
@section('page_desc', 'Ringkasan data user & MUA')

@section('content')

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Total User --}}
        <div class="bg-white/95 border border-rose-100 rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="absolute inset-x-0 -top-0.5 h-1 bg-gradient-to-r from-rose-300 via-amber-200 to-rose-400"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[11px] font-semibold tracking-wide text-rose-500 uppercase mb-1">
                        Total User Terdaftar
                    </p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ $totalUser }}</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Seluruh akun yang sudah terdaftar di AdatKu.
                    </p>
                </div>
                <div
                    class="w-10 h-10 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-3.33 0-6 1.34-6 4v2h12v-2c0-2.66-2.67-4-6-4Z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- User jadi MUA --}}
        <div class="bg-white/95 border border-rose-100 rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="absolute inset-x-0 -top-0.5 h-1 bg-gradient-to-r from-amber-200 via-rose-300 to-amber-300"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[11px] font-semibold tracking-wide text-rose-500 uppercase mb-1">
                        User yang Menjadi MUA
                    </p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ $totalMua }}</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        User yang sudah disetujui sebagai penyedia jasa MUA.
                    </p>
                </div>
                <div
                    class="w-10 h-10 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-amber-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            d="M4 4h16a1 1 0 0 1 1 1v4H3V5a1 1 0 0 1 1-1Zm-1 7h8v8H4a1 1 0 0 1-1-1v-7Zm10 0h8v3h-8v-3Zm0 5h6v3h-6v-3Z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- User login sekarang --}}
        <div class="bg-white/95 border border-rose-100 rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="absolute inset-x-0 -top-0.5 h-1 bg-gradient-to-r from-emerald-300 via-rose-200 to-amber-300"></div>
            <p class="text-[11px] font-semibold tracking-wide text-rose-500 uppercase mb-1">
                User yang Login Sekarang
            </p>
            <h3 class="text-base md:text-lg font-semibold mt-1 text-slate-900">
                {{ $userLogin->name ?? '-' }}
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">
                {{ $userLogin->email ?? '' }}
            </p>
            <span
                class="inline-flex items-center px-2.5 py-1 text-[11px] rounded-full mt-2 border
                @if(($userLogin->role ?? '') == 'admin')
                    bg-slate-900 text-white border-slate-900
                @elseif(($userLogin->role ?? '') == 'mua')
                    bg-amber-50 text-amber-900 border-amber-200
                @else
                    bg-emerald-50 text-emerald-900 border-emerald-200
                @endif">
                ● {{ ucfirst($userLogin->role ?? 'user') }}
            </span>
        </div>
    </div>

    {{-- NOTIFIKASI PENDING MUA --}}
    @if($pendingRequestsCount > 0)
        <div
            class="bg-gradient-to-r from-rose-50 via-amber-50 to-rose-50 border border-rose-100 rounded-2xl p-5 mb-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div class="flex items-start gap-3">
                    <div
                        class="w-9 h-9 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-700 border border-rose-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                             viewBox="0 0 24 24">
                            <path d="M12 2 2 20h20L12 2Zm0 5 5 9H7l5-9Zm-1 4v3h2v-3h-2Zm0 4v2h2v-2h-2Z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-rose-900">
                            Ada {{ $pendingRequestsCount }} pengajuan menjadi MUA!
                        </h3>
                        <p class="text-sm text-rose-800">
                            Tinjau segera untuk menyetujui atau menolak pengajuan terbaru.
                        </p>
                    </div>
                </div>

                <a href="{{ route('admin.mua-requests.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm text-white
                          bg-gradient-to-r from-rose-400 via-amber-400 to-orange-400 hover:opacity-95 shadow-md">
                    <span>Lihat Semua Pengajuan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            {{-- list request terbaru --}}
            @if($latestPendingRequests->count() > 0)
                <div class="mt-4 bg-white/95 rounded-xl border border-rose-100 overflow-hidden">
                    <table class="min-w-full text-sm">
                        <thead class="bg-rose-50 text-rose-800">
                        <tr>
                            <th class="text-left py-2.5 px-4">Nama</th>
                            <th class="text-left py-2.5 px-4">Email</th>
                            <th class="text-left py-2.5 px-4">Diajukan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($latestPendingRequests as $req)
                            <tr class="border-t border-rose-100 hover:bg-rose-50/60">
                                <td class="py-2.5 px-4">{{ $req->user?->name ?? '-' }}</td>
                                <td class="py-2.5 px-4">{{ $req->user?->email ?? '-' }}</td>
                                <td class="py-2.5 px-4">{{ $req->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

    {{-- AKSI CEPAT --}}
    <div
        class="bg-white/95 border border-rose-100 rounded-2xl p-5 mb-6 flex flex-wrap items-center justify-between gap-3 shadow-sm">
        <div>
            <h3 class="font-semibold text-slate-900">Aksi Cepat</h3>
            <p class="text-xs text-slate-500 mt-1">
                Kelola data user dan pengajuan MUA dari satu tempat.
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm text-white
                      bg-gradient-to-r from-rose-500 via-amber-400 to-orange-400 hover:opacity-95 shadow-md">
                <span>Kelola Users</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </a>

            <a href="{{ route('admin.mua-requests.index') }}
               " class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm text-rose-700 border border-rose-200 bg-rose-50/80 hover:bg-rose-50">
                <span>Lihat Request MUA</span>
            </a>
        </div>
    </div>

    {{-- TABEL MUA --}}
    <div class="bg-white/97 border border-rose-100 rounded-2xl overflow-hidden shadow-sm">
        <div class="p-4 border-b border-rose-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-slate-900">Daftar User yang Menjadi MUA</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    List MUA yang sudah disetujui oleh admin.
                </p>
            </div>
            <span
                class="inline-flex items-center px-3 py-1 text-xs rounded-full bg-rose-50 text-rose-700 border border-rose-100">
                {{ $totalMua }} data
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-rose-50 text-slate-700">
                <tr>
                    <th class="text-left py-3 px-4 w-12">#</th>
                    <th class="text-left py-3 px-4">Nama</th>
                    <th class="text-left py-3 px-4">Email</th>
                    <th class="text-left py-3 px-4 w-32">Dibuat</th>
                </tr>
                </thead>
                <tbody>
                @forelse($muas as $index => $mua)
                    <tr class="border-t border-rose-100 hover:bg-rose-50/60">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4">{{ $mua->name }}</td>
                        <td class="py-3 px-4">{{ $mua->email }}</td>
                        <td class="py-3 px-4">{{ $mua->created_at?->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-5 px-4 text-center text-slate-500 text-sm">
                            Belum ada user yang menjadi MUA.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
