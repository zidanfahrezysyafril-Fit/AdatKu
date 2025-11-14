@extends('layouts.app')
@section('title', 'Tambah Layanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-xl font-bold text-rose-700">Tambah Layanan</h2>
            <a href="{{ route('panelmua.layanan.index') }}"
               class="text-sm text-slate-500 hover:text-slate-700">
                Kembali
            </a>
        </div>

        <form action="{{ route('panelmua.layanan.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            @include('layanan._form', ['item' => $item ?? null])

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('panelmua.layanan.index') }}"
                   class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-rose-600 text-white hover:bg-rose-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
