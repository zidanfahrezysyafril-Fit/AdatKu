@extends('layouts.admin')

@section('title', 'Dashboard — Admin')
@section('page_title', 'Dashboard')
@section('page_desc', 'Ringkasan data user & MUA')

@section('content')

    <div class="space-y-6">

        {{-- ================= STAT CARDS ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-2">

            {{-- Total User --}}
            <div class="card-soft p-5">
                <p class="text-[11px] font-semibold tracking-wide text-amber-600 uppercase mb-1">
                    Total User Terdaftar
                </p>
                <h3 class="text-3xl font-bold text-slate-900">{{ $totalUser }}</h3>
                <p class="text-xs text-slate-500 mt-1">
                    Seluruh akun yang sudah terdaftar di AdatKu.
                </p>
            </div>

            {{-- User jadi MUA --}}
            <div class="card-soft p-5">
                <p class="text-[11px] font-semibold tracking-wide text-amber-600 uppercase mb-1">
                    User yang Menjadi MUA
                </p>
                <h3 class="text-3xl font-bold text-slate-900">{{ $totalMua }}</h3>
                <p class="text-xs text-slate-500 mt-1">
                    User yang sudah disetujui sebagai penyedia jasa MUA.
                </p>
            </div>

            {{-- User login sekarang --}}
            <div class="card-soft p-5">
                <p class="text-[11px] font-semibold tracking-wide text-amber-600 uppercase mb-1">
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

        {{-- ================= NOTIFIKASI PENDING MUA ================= --}}
        @if($pendingRequestsCount > 0)
            <div
                class="card-soft p-5 bg-gradient-to-r from-[#fff3ea] via-[#ffeef5] to-[#fff6e8] border border-amber-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <div
                            class="w-9 h-9 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-700 border border-amber-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                 viewBox="0 0 24 24">
                                <path d="M12 2 2 20h20L12 2Zm0 5 5 9H7l5-9Zm-1 4v3h2v-3h-2Zm0 4v2h2v-2h-2Z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-amber-900">
                                Ada {{ $pendingRequestsCount }} pengajuan menjadi MUA!
                            </h3>
                            <p class="text-sm text-amber-800">
                                Tinjau segera untuk menyetujui atau menolak pengajuan terbaru.
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('admin.mua-requests.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm text-white
                              bg-gradient-to-r from-amber-400 via-rose-400 to-orange-400 hover:opacity-95 shadow-md">
                        <span>Lihat Semua Pengajuan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                {{-- list request terbaru --}}
                @if($latestPendingRequests->count() > 0)
                    <div class="mt-4 bg-white rounded-xl border border-amber-100 overflow-hidden">
                        <table class="min-w-full text-sm">
                            <thead class="bg-amber-50 text-amber-800">
                            <tr>
                                <th class="text-left py-2.5 px-4">Nama</th>
                                <th class="text-left py-2.5 px-4">Email</th>
                                <th class="text-left py-2.5 px-4">Diajukan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($latestPendingRequests as $req)
                                <tr class="border-t border-amber-100 hover:bg-amber-50/60 bg-white">
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

        {{-- ================= AKSI CEPAT ================= --}}
        <div class="card-soft p-5 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="font-semibold text-slate-900">Aksi Cepat</h3>
                <p class="text-xs text-slate-500 mt-1">
                    Kelola data user dan pengajuan MUA dari satu tempat.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('users.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm text-white
                          bg-gradient-to-r from-amber-500 via-rose-400 to-orange-400 hover:opacity-95 shadow-md">
                    <span>Kelola Users</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </a>

                <a href="{{ route('admin.mua-requests.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm text-amber-700 border border-amber-200 bg-amber-50/80 hover:bg-amber-50">
                    <span>Lihat Request MUA</span>
                </a>
            </div>
        </div>

        {{-- ================= TABEL MUA ================= --}}
        <div class="card-table">
            <div class="p-4 border-b border-amber-100 flex items-center justify-between bg-white">
                <div>
                    <h3 class="font-semibold text-slate-900">Daftar User yang Menjadi MUA</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        List MUA yang sudah disetujui oleh admin.
                    </p>
                </div>
                <span
                    class="inline-flex items-center px-3 py-1 text-xs rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                    {{ $totalMua }} data
                </span>
            </div>

            <div class="overflow-x-auto bg-white">
                <table class="min-w-full text-sm">
                    <thead class="bg-amber-50 text-slate-700">
                    <tr>
                        <th class="text-left py-3 px-4 w-12">#</th>
                        <th class="text-left py-3 px-4">Nama</th>
                        <th class="text-left py-3 px-4">Email</th>
                        <th class="text-left py-3 px-4 w-32">Dibuat</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($muas as $index => $mua)
                        <tr class="bg-white border-t border-amber-100 hover:bg-amber-50/60">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">{{ $mua->name }}</td>
                            <td class="py-3 px-4">{{ $mua->email }}</td>
                            <td class="py-3 px-4">{{ $mua->created_at?->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr class="bg-white">
                            <td colspan="4" class="py-5 px-4 text-center text-slate-500 text-sm">
                                Belum ada user yang menjadi MUA.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
