@extends('layouts.admin')

@section('title', 'Dashboard — Admin')
@section('page_title', 'Dashboard')
@section('page_desc', 'Ringkasan data user & MUA')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-rose-100 rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total User Terdaftar</p>
            <h3 class="text-3xl font-bold mt-1">{{ $totalUser }}</h3>
        </div>
        <div class="bg-white border border-rose-100 rounded-2xl p-5">
            <p class="text-sm text-slate-500">User yang menjadi MUA</p>
            <h3 class="text-3xl font-bold mt-1">{{ $totalMua }}</h3>
        </div>
        <div class="bg-white border border-rose-100 rounded-2xl p-5">
            <p class="text-sm text-slate-500">User yang login sekarang</p>
            <h3 class="text-lg font-semibold mt-1">
                {{ $userLogin->name ?? '-' }}
            </h3>
            <p class="text-sm text-slate-500">
                {{ $userLogin->email ?? '' }}<br>
                <span class="inline-block px-2 py-1 text-xs rounded-lg mt-1
                      @if(($userLogin->role ?? '') == 'admin') bg-slate-900 text-white
                      @elseif(($userLogin->role ?? '') == 'mua') bg-amber-100 text-amber-900
                      @else bg-emerald-100 text-emerald-900 @endif">
                    {{ $userLogin->role ?? 'user' }}
                </span>
            </p>
        </div>
    </div>

    {{-- NOTIFIKASI PENGAJUAN MUA --}}
    @if($pendingRequestsCount > 0)
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-amber-900">
                        Ada {{ $pendingRequestsCount }} pengajuan menjadi MUA!
                    </h3>
                    <p class="text-sm text-amber-800">
                        Segera tinjau untuk menyetujui atau menolak.
                    </p>
                </div>
                <a href="{{ route('admin.mua-requests.index') }}"
                    class="px-4 py-2 rounded-xl bg-amber-600 text-white hover:bg-amber-700 text-sm">
                    Lihat Semua
                </a>
            </div>

            {{-- REQUEST TERBARU --}}
            @if($latestPendingRequests->count() > 0)
                <div class="mt-4 bg-white rounded-xl border border-amber-200 overflow-hidden">
                    <table class="min-w-full text-sm">
                        <thead class="bg-amber-100 text-amber-900">
                            <tr>
                                <th class="text-left py-2 px-4">Nama</th>
                                <th class="text-left py-2 px-4">Email</th>
                                <th class="text-left py-2 px-4">Diajukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestPendingRequests as $req)
                                <tr class="border-t border-amber-100">
                                    <td class="py-2 px-4">{{ $req->user?->name ?? '-' }}</td>
                                    <td class="py-2 px-4">{{ $req->user?->email ?? '-' }}</td>
                                    <td class="py-2 px-4">{{ $req->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif


    <div class="bg-white border border-rose-100 rounded-2xl p-5 flex flex-wrap gap-3 mb-6">
        <a href="{{ route('admin.dashboard') ?? '#' }}"
            class="px-4 py-2 rounded-xl bg-rose-600 text-white hover:bg-rose-700">
            Kelola Users
        </a>
    </div>

    <div class="bg-white border border-rose-100 rounded-2xl overflow-hidden">
        <div class="p-4 border-b border-rose-100 flex items-center justify-between">
            <h3 class="font-semibold">Daftar User yang Menjadi MUA</h3>
            <span class="text-sm text-slate-500">{{ $totalMua }} data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-rose-50 text-slate-700">
                    <tr>
                        <th class="text-left py-3 px-4">#</th>
                        <th class="text-left py-3 px-4">Nama</th>
                        <th class="text-left py-3 px-4">Email</th>
                        <th class="text-left py-3 px-4">Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($muas as $index => $mua)
                        <tr class="border-t border-rose-100 hover:bg-rose-50/40">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">{{ $mua->name }}</td>
                            <td class="py-3 px-4">{{ $mua->email }}</td>
                            <td class="py-3 px-4">{{ $mua->created_at?->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 px-4 text-center text-slate-500">
                                Belum ada user yang menjadi MUA.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection