@extends('layouts.app')

@section('content')
    <main class="w-full px-4 sm:px-6 lg:px-10 py-6 sm:py-8">
        <div class="max-w-6xl mx-auto">

            {{-- FLASH SUCCESS --}}
            @if (session('success'))
                <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,3500)" x-transition.opacity
                    class="mb-5 flex items-start gap-3 px-4 py-3 rounded-2xl bg-[#FFF8E0] border border-[#FACC6B] text-[#8A4B00] text-sm shadow-sm">
                    <div
                        class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-full bg-[#FFF1BF] text-[#D97706] text-base">
                        ✓
                    </div>
                    <div class="flex-1 font-medium">
                        {{ session('success') }}
                    </div>
                    <button @click="show=false"
                        class="ml-auto text-[11px] font-semibold uppercase tracking-wide text-[#9A5A00]">
                        Tutup
                    </button>
                </div>
            @endif

            <div class="bg-white/95 rounded-3xl ring-1 ring-[#FACC6B]/40 shadow-sm overflow-hidden">

                {{-- HEADER --}}
                <div
                    class="px-5 sm:px-8 py-5 sm:py-6 bg-gradient-to-r from-[#fff7f9] via-[#fff8ef] to-[#fffaf3] border-b border-rose-50">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <p class="text-[10px] sm:text-[11px] font-semibold tracking-[0.22em] text-amber-500 uppercase">
                                MUA Panel
                            </p>
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mt-1" style="color:#C98A00;">
                                Pesanan Masuk
                            </h1>
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-[11px] sm:text-xs font-medium bg-amber-50 text-amber-800 border border-amber-100">
                            Total pesanan: {{ $groupedPesanans->count() }}
                        </span>
                    </div>
                    <div
                        class="h-[3px] w-14 sm:w-16 bg-gradient-to-r from-amber-300/90 via-amber-400/90 to-rose-300/80 rounded-full mt-3">
                    </div>
                </div>

                @if ($groupedPesanans->isEmpty())
                    <div
                        class="bg-white/95 rounded-3xl ring-1 ring-[#FACC6B]/40 shadow-sm px-6 sm:px-8 py-10 text-center text-sm text-slate-500">
                        Belum ada pesanan untuk MUA ini.
                    </div>
                @else

                    {{-- ================== TABEL (≥ SM) ================== --}}
                    <div class="hidden sm:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-amber-50/80 text-amber-800 text-[13px]">
                                    <tr class="border-b border-amber-100">
                                        <th class="px-5 py-3 text-left">#</th>
                                        <th class="px-5 py-3 text-left">Tanggal Booking</th>
                                        <th class="px-5 py-3 text-left">Pengguna</th>
                                        <th class="px-5 py-3 text-left">Layanan</th>
                                        <th class="px-5 py-3 text-left">Total</th>
                                        <th class="px-5 py-3 text-left">Status Pembayaran</th>
                                        <th class="px-5 py-3 text-left">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-amber-50 text-[13.5px]">
                                    @foreach ($groupedPesanans as $group)
                                        @php
                                            $first = $group->first();

                        $layananList = $group->map(function ($p) {
                            return optional($p->layanan)->nama;
                        })->filter()->values();

                        $namaDisplay = $layananList->isNotEmpty()
                            ? $layananList->implode(', ')
                            : '-';

                        $totalGroup = $group->sum('total_harga');
                        $status = $first->status_pembayaran;
                                        @endphp

                                        <tr class="hover:bg-[#FFF8E8] transition-colors">
                                            {{-- # --}}
                                            <td class="px-5 py-4 align-top text-slate-500">
                                                {{ $loop->iteration }}
                                            </td>

                                            {{-- Tanggal Booking --}}
                                            <td class="px-5 py-4 align-top">
                                                {{ \Carbon\Carbon::parse($first->tanggal_booking)->translatedFormat('d M Y') }}
                                            </td>

                                            {{-- Pengguna --}}
                                            <td class="px-5 py-4 align-top">
                                                <div class="font-medium text-slate-900">
                                                    {{ $first->pengguna->name ?? '—' }}
                                                </div>
                                                <div class="text-[11px] text-slate-500">
                                                    {{ $first->alamat }}
                                                </div>
                                            </td>

                                            {{-- Layanan --}}
                                            <td class="px-5 py-4 align-top">
                                                {{ $namaDisplay }}
                                            </td>

                                            {{-- Total --}}
                                            <td class="px-5 py-4 align-top font-semibold text-slate-900 whitespace-nowrap">
                                                Rp {{ number_format($totalGroup, 0, ',', '.') }}
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-5 py-4 align-top">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold
                                                                            @if ($status === 'Belum_Lunas')
                                                                                bg-yellow-50 text-yellow-700
                                                                            @elseif ($status === 'Lunas')
                                                                                bg-emerald-50 text-emerald-700
                                                                            @else
                                                                                bg-rose-50 text-rose-700
                                                                            @endif">
                                                    {{ str_replace('_', ' ', $status) }}
                                                </span>
                                            </td>

                                            {{-- Aksi --}}
                                            <td class="px-5 py-4 align-top">
                                                <div class="flex flex-col gap-2">

                                                    @if ($status === 'Lunas')
                                                        <a href="{{ route('panelmua.pembayaran.create', $first->id) }}"
                                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-[11px] font-medium
                                                                                                  bg-emerald-50 text-emerald-600 hover:bg-emerald-100">
                                                            Input Pembayaran
                                                        </a>
                                                    @endif

                                                    {{-- Update status --}}
                                                    <form action="{{ route('panelmua.pesanan.updateStatus', $first->id) }}"
                                                        method="POST" class="flex items-center gap-2">
                                                        @csrf
                                                        @method('PATCH')

                                                        <select name="status_pembayaran"
                                                            class="border border-amber-200/70 rounded-xl px-2 py-1 text-[11px] text-slate-700 bg-[#FFFBF3] focus:outline-none focus:ring-2 focus:ring-[#FACC6B] focus:border-[#DA9A00]">
                                                            <option value="Belum_Lunas" @selected($status === 'Belum_Lunas')>
                                                                Belum Lunas
                                                            </option>
                                                            <option value="Lunas" @selected($status === 'Lunas')>
                                                                Lunas
                                                            </option>
                                                            <option value="Dibatalkan" @selected($status === 'Dibatalkan')>
                                                                Dibatalkan
                                                            </option>
                                                        </select>

                                                        <button type="submit"
                                                            class="px-3 py-1.5 text-[11px] rounded-xl text-[#7A4600] font-semibold shadow-sm hover:brightness-110 active:brightness-95 transition"
                                                            style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
                                                            Update
                                                        </button>
                                                    </form>

                                                    {{-- Hapus --}}
                                                    <form action="{{ route('panelmua.pesanan.destroy', $first->id) }}"
                                                        method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="px-3 py-1.5 text-[11px] rounded-xl bg-red-50 text-red-600 hover:bg-red-100 btn-delete-pesanan">
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
                    </div>

                    {{-- ================== CARD LIST (MOBILE) ================== --}}
                    <div class="sm:hidden px-4 py-4 space-y-3">
                        @foreach ($groupedPesanans as $group)
                            @php
                                $first = $group->first();

                $layananList = $group->map(function ($p) {
                    return optional($p->layanan)->nama;
                })->filter()->values();

                $namaDisplay = $layananList->isNotEmpty()
                    ? $layananList->implode(', ')
                    : '-';

                $totalGroup = $group->sum('total_harga');
                $status = $first->status_pembayaran;
                            @endphp

                            <div class="border border-[#FACC6B]/40 rounded-2xl bg-white/95 p-4 space-y-3 shadow-sm">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($first->tanggal_booking)->translatedFormat('d M Y') }}
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold
                                                                    @if ($status === 'Belum_Lunas')
                                                                        bg-yellow-50 text-yellow-700
                                                                    @elseif ($status === 'Lunas')
                                                                        bg-emerald-50 text-emerald-700
                                                                    @else
                                                                        bg-rose-50 text-rose-700
                                                                    @endif">
                                        {{ str_replace('_', ' ', $status) }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $first->pengguna->name ?? '—' }}
                                    </p>
                                    <p class="text-[11px] text-slate-500">
                                        {{ $first->alamat }}
                                    </p>
                                </div>

                                <div class="text-xs text-slate-600">
                                    <span class="font-semibold">Layanan:</span>
                                    <span>{{ $namaDisplay }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-500">Total</span>
                                    <span class="text-sm font-semibold text-slate-900">
                                        Rp {{ number_format($totalGroup, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="pt-2 space-y-2">
                                    @if ($status === 'Lunas')
                                        <a href="{{ route('panelmua.pembayaran.create', $first->id) }}"
                                            class="w-full inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-[11px] font-medium
                                                                                      bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                                            Input Pembayaran
                                        </a>
                                    @endif

                                    <form action="{{ route('panelmua.pesanan.updateStatus', $first->id) }}" method="POST"
                                        class="flex flex-wrap items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status_pembayaran"
                                            class="flex-1 min-w-[120px] border border-amber-200/70 rounded-xl px-2 py-1 text-[11px] text-slate-700 bg-[#FFFBF3] focus:outline-none focus:ring-2 focus:ring-[#FACC6B] focus:border-[#DA9A00]">
                                            <option value="Belum_Lunas" @selected($status === 'Belum_Lunas')>
                                                Belum Lunas
                                            </option>
                                            <option value="Lunas" @selected($status === 'Lunas')>
                                                Lunas
                                            </option>
                                            <option value="Dibatalkan" @selected($status === 'Dibatalkan')>
                                                Dibatalkan
                                            </option>
                                        </select>

                                        <button type="submit"
                                            class="px-3 py-1.5 text-[11px] rounded-xl w-auto text-[#7A4600] font-semibold shadow-sm hover:brightness-110 active:brightness-95 transition"
                                            style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
                                            Update
                                        </button>
                                    </form>

                                    <form action="{{ route('panelmua.pesanan.destroy', $first->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="w-full px-3 py-1.5 text-[11px] rounded-xl bg-red-50 text-red-600 hover:bg-red-100 btn-delete-pesanan">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endif
        </div>
    </main>

    {{-- MODAL HAPUS PESANAN --}}
    <div id="deleteModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-[90%] px-6 pt-6 pb-5 relative overflow-hidden">

            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-amber-400 via-rose-400 to-pink-500"></div>

            <div class="flex items-start gap-3">
                <div
                    class="mt-1 flex h-10 w-10 items-center justify-center rounded-full bg-amber-50 text-amber-500 text-xl">
                    !
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 mb-1">
                        Hapus pesanan?
                    </h2>
                    <p class="text-sm text-slate-500">
                        Yakin ingin menghapus pesanan ini dari panel MUA? Tindakan ini tidak bisa dibatalkan.
                    </p>
                </div>
            </div>

            <div class="mt-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <button type="button" onclick="closeDeleteModal()"
                        class="w-full sm:w-auto px-4 py-2 rounded-full text-xs font-semibold
                               border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                    Kembali
                </button>

                <button type="button" onclick="confirmDelete()"
                        class="w-full sm:w-auto px-4 py-2 rounded-full text-xs font-semibold
                               bg-rose-500 text-white hover:bg-rose-600 transition">
                    Ya, hapus
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPT MODAL HAPUS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('deleteModal');
            let selectedForm = null;

            // tombol Hapus
            document.querySelectorAll('.btn-delete-pesanan').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    selectedForm = this.closest('form');

                    if (!selectedForm) return;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            window.closeDeleteModal = function () {
                selectedForm = null;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            window.confirmDelete = function () {
                if (selectedForm) {
                    selectedForm.submit();
                }
                closeDeleteModal();
            }

            // klik luar modal
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeDeleteModal();
                }
            });

            // ESC
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeDeleteModal();
                }
            });
        });
    </script>
@endsection
