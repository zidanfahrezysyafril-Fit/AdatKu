@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Edit User')
@section('page_desc', 'Ubah data user dan rolenya.')

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-rose-100
                    p-4 sm:p-6 space-y-4">

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs sm:text-sm mb-3">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-rose-100 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-rose-300">
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border border-rose-100 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-rose-300">
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">
                    Password
                    <span class="text-[10px] sm:text-xs text-slate-400">(kosongkan jika tidak diubah)</span>
                </label>
                <input type="password" name="password" class="w-full rounded-xl border border-rose-100 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-rose-300">
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Role</label>
                <select name="role" class="w-full rounded-xl border border-rose-100 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-rose-300">
                    <option value="pengguna" {{ old('role', $user->role) == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                    <option value="mua" {{ old('role', $user->role) == 'mua' ? 'selected' : '' }}>MUA</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-2 pt-2">
                <a href="{{ route('users.index') }}"
                    class="w-full sm:w-auto text-center px-4 py-2 rounded-xl border text-sm text-slate-600 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 rounded-xl bg-rose-600 text-sm text-white font-medium hover:bg-rose-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection