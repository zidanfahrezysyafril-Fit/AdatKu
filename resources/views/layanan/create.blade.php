@extends('layouts.app')
@section('title', 'Tambah Layanan')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-0">
        <div class="bg-white/95 rounded-3xl shadow-sm ring-1 ring-[#FACC6B]/40 overflow-hidden">

            {{-- HEADER --}}
            <div
                class="px-6 sm:px-8 py-4 border-b border-rose-100 bg-gradient-to-r from-[#fff7f9] via-[#fff8ef] to-[#fffaf3] flex items-center justify-between gap-3">
                <div>
                    <p class="text-[11px] font-semibold tracking-[0.22em] text-amber-500 uppercase">
                        MUA Panel
                    </p>
                    <h2 class="text-xl sm:text-2xl font-bold" style="color:#C98A00;">
                        Tambah Layanan
                    </h2>
                </div>

                <a href="{{ route('panelmua.layanan.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs sm:text-sm font-medium
                          border border-amber-200 bg-white/80 text-amber-700 hover:bg-amber-50 shadow-sm">
                    ← <span>Kembali ke daftar</span>
                </a>
            </div>

            {{-- FORM --}}
            <form action="{{ route('panelmua.layanan.store') }}" method="POST" enctype="multipart/form-data"
                  class="p-6 sm:p-8 space-y-6 bg-gradient-to-b from-[#FFF8E8]/60 to-transparent">
                @csrf

                @include('layanan._form', ['item' => $item ?? null])

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('panelmua.layanan.index') }}"
                       class="px-4 py-2 rounded-2xl border border-slate-300/80 bg-white text-slate-700 text-sm font-medium hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-2xl text-sm font-semibold text-[#7A4600] shadow-md
                                   hover:brightness-110 active:brightness-95 transition"
                            style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
                        Simpan Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
