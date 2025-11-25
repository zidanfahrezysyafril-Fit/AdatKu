@extends('layouts.admin')

@section('title', 'Users')
@section('page_title', 'Kelola Users')
@section('page_desc', 'Daftar user yang sudah terdaftar di AdatKu.')

@section('content')
    <div class="space-y-4">

        {{-- Flash success --}}
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card user login sekarang --}}
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-4 sm:p-5
                        flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-xs sm:text-sm text-slate-500">User yang login sekarang</p>
                <p class="text-base sm:text-lg font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500 break-all">{{ auth()->user()->email }}</p>
            </div>
            <span
                class="self-start sm:self-auto px-3 py-1 rounded-full text-[11px] sm:text-xs bg-emerald-100 text-emerald-700 whitespace-nowrap">
                {{ auth()->user()->role ?? 'User' }}
            </span>
        </div>

        {{-- Wrapper daftar users --}}
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                <h2 class="text-base sm:text-lg font-semibold text-slate-800">
                    Daftar Semua Users
                </h2>
                <span class="text-xs sm:text-sm text-slate-500">
                    {{ $users->count() }} user terdaftar
                </span>
            </div>

            {{-- ======= MOBILE: CARD PER USER (md:hidden) ======= --}}
            <div class="space-y-3 md:hidden">
                @forelse ($users as $index => $user)
                            <div class="border border-rose-100 rounded-2xl px-3 py-3 bg-rose-50/40">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <p class="text-[11px] text-slate-400">#{{ $index + 1 }}</p>
                                        <p class="text-sm font-semibold text-slate-800 leading-snug">
                                            {{ $user->name }}
                                        </p>
                                        <p class="text-[11px] text-slate-500 break-all mt-0.5">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                    <div class="text-right space-y-1">
                                        {{-- badge role --}}
                                        @php
                                            $role = $user->role ?? '-';
                                            $roleClasses = match ($role) {
                                                'admin' => 'bg-slate-900 text-white',
                                                'mua' => 'bg-amber-100 text-amber-800',
                                                'pengguna' => 'bg-rose-100 text-rose-700',
                                                default => 'bg-slate-100 text-slate-700'
                                            };
                                        @endphp
                    <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] {{ $roleClasses }}">
                                            {{ ucfirst($role) }}
                                        </span>

                                        <p class="text-[10px] text-slate-500">
                                            {{ $user->created_at?->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-3 flex justify-end">
                                    <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-medium
                                                      text-amber-700 bg-amber-50 border border-amber-100 hover:bg-amber-100">
                                        Edit
                                    </a>
                                </div>
                            </div>
                @empty
                    <p class="text-center text-slate-500 text-sm py-4">
                        Belum ada user yang terdaftar.
                    </p>
                @endforelse
            </div>

            {{-- ======= DESKTOP/TABLET: TABEL (hidden di mobile) ======= --}}
            <div class="hidden md:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-rose-50 text-slate-700">
                                <th class="px-3 py-2 text-left border-b">#</th>
                                <th class="px-3 py-2 text-left border-b">Nama</th>
                                <th class="px-3 py-2 text-left border-b">Email</th>
                                <th class="px-3 py-2 text-left border-b">Role</th>
                                <th class="px-3 py-2 text-left border-b">Dibuat</th>
                                <th class="px-3 py-2 text-center border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr class="hover:bg-rose-50/70">
                                    <td class="px-3 py-2 border-b align-top">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2 border-b align-top">
                                        <span class="block font-medium text-slate-800">{{ $user->name }}</span>
                                    </td>
                                    <td class="px-3 py-2 border-b align-top">
                                        <span class="block break-all">{{ $user->email }}</span>
                                    </td>
                                    <td class="px-3 py-2 border-b align-top">
                                        @php
                                            $role = $user->role ?? '-';
                                            $roleClasses = match ($role) {
                                                'admin' => 'bg-slate-900 text-white',
                                                'mua' => 'bg-amber-100 text-amber-800',
                                                'pengguna' => 'bg-rose-100 text-rose-700',
                                                default => 'bg-slate-100 text-slate-700'
                                            };
                                        @endphp
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] {{ $roleClasses }}">
                                            {{ ucfirst($role) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 border-b align-top text-[11px] text-slate-500 whitespace-nowrap">
                                        {{ $user->created_at?->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-3 py-2 border-b text-center align-top">
                                        <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg
                                                      text-[11px] font-medium text-amber-700 bg-amber-50
                                                      hover:bg-amber-100">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-4 text-center text-slate-500 text-sm">
                                        Belum ada user yang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection 