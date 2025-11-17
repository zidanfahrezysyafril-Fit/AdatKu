@extends('layouts.admin')

@section('title', 'Users')
@section('page_title', 'Kelola Users')
@section('page_desc', 'Daftar user yang sudah terdaftar di AdatKu.')

@section('content')
    <div class="space-y-4">

        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm"> 
                {{ session('success') }}
            </div>
        @endif
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-4 flex justify-between items-center">
            <div>
                <p class="text-sm text-slate-500">User yang login sekarang</p>
                <p class="text-lg font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">
                {{ auth()->user()->role ?? 'User' }}
            </span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-slate-800">Daftar Semua Users</h2>
                <span class="text-sm text-slate-500">{{ $users->count() }} user terdaftar</span>
            </div>

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
                                <td class="px-3 py-2 border-b">{{ $index + 1 }}</td>
                                <td class="px-3 py-2 border-b">{{ $user->name }}</td>
                                <td class="px-3 py-2 border-b">{{ $user->email }}</td>
                                <td class="px-3 py-2 border-b">{{ $user->role ?? '-' }}</td>
                                <td class="px-3 py-2 border-b text-xs text-slate-500">
                                    {{ $user->created_at?->format('d M Y H:i') }}
                                </td>

                                <td class="px-3 py-2 border-b text-center">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="text-blue-600 hover:underline text-xs font-medium">
                                        Edit Role
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-4 text-center text-slate-500">
                                    Belum ada user yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
