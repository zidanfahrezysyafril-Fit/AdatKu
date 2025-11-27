@extends('layouts.admin')

@section('title', 'Pengajuan MUA — Admin')
@section('page_title', 'Pengajuan MUA')
@section('page_desc', 'Kelola permintaan user yang ingin menjadi MUA')

@section('content')
    <div class="space-y-6">

        {{-- ========= KARTU STATISTIK ========= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-rose-100 rounded-2xl p-4 sm:p-5">
                <p class="text-xs sm:text-sm text-slate-500">Total Pending</p>
                <h3 class="text-2xl sm:text-3xl font-bold mt-1 text-amber-600">{{ $pending->count() }}</h3>
                <p class="text-[11px] sm:text-xs text-slate-400 mt-1">Menunggu ditinjau admin</p>
            </div>
            <div class="bg-white border border-rose-100 rounded-2xl p-4 sm:p-5">
                <p class="text-xs sm:text-sm text-slate-500">Total Disetujui</p>
                <h3 class="text-2xl sm:text-3xl font-bold mt-1 text-emerald-600">{{ $approved->count() }}</h3>
                <p class="text-[11px] sm:text-xs text-slate-400 mt-1">Akan otomatis menjadi role MUA</p>
            </div>
            <div class="bg-white border border-rose-100 rounded-2xl p-4 sm:p-5">
                <p class="text-xs sm:text-sm text-slate-500">Total Ditolak</p>
                <h3 class="text-2xl sm:text-3xl font-bold mt-1 text-rose-600">{{ $rejected->count() }}</h3>
                <p class="text-[11px] sm:text-xs text-slate-400 mt-1">Bisa diajukan ulang oleh user</p>
            </div>
        </div>

        {{-- ========= SECTION PENDING ========= --}}
        <div class="bg-white border border-rose-100 rounded-2xl overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-rose-100 flex items-center justify-between gap-2">
                <div>
                    <h3 class="font-semibold text-slate-900 text-sm sm:text-base">Pengajuan Pending</h3>
                    <p class="text-[11px] sm:text-xs text-slate-500">Permintaan yang belum kamu proses.</p>
                </div>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[11px] sm:text-xs bg-amber-50 text-amber-700">
                    {{ $pending->count() }} pending
                </span>
            </div>

            @if ($pending->isEmpty())
                <div class="p-4 sm:p-6 text-center text-sm text-slate-500">
                    Belum ada pengajuan yang menunggu persetujuan.
                </div>
            @else
                {{-- ========== MOBILE: CARD VIEW ========== --}}
                <div class="md:hidden divide-y divide-rose-100">
                    @foreach ($pending as $index => $req)
                        <div class="px-4 py-4">
                            {{-- Nama + tanggal --}}
                            <div class="flex items-start justify-between gap-3 mb-1.5">
                                <div class="flex-1">
                                    <p class="text-xs text-slate-400">#{{ $index + 1 }}</p>
                                    <p class="font-semibold text-slate-900 text-sm">
                                        {{ optional($req->user)->name ?? '-' }}
                                    </p>
                                    <p class="text-[11px] text-slate-400">
                                        ID: {{ $req->user_id }}
                                    </p>
                                </div>
                                <p class="text-[11px] text-slate-500 whitespace-nowrap">
                                    {{ $req->created_at?->format('d M Y H:i') }}
                                </p>
                            </div>

                            {{-- Email & kontak --}}
                            <div class="text-xs text-slate-600 space-y-1 mb-2">
                                <p class="break-all">
                                    <span class="text-slate-400">Email:</span>
                                    <span class="ml-1">{{ optional($req->user)->email ?? '-' }}</span>
                                </p>
                                <p>
                                    <span class="text-slate-400">WA:</span>
                                    <span class="ml-1">{{ $req->kontak_wa }}</span>
                                </p>
                            </div>

                            {{-- Usaha --}}
                            <div class="mb-3">
                                <p class="text-xs text-slate-400 mb-0.5">Nama Usaha</p>
                                <p class="text-sm font-medium text-slate-800">
                                    {{ $req->nama_usaha }}
                                </p>
                                @if ($req->alamat)
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $req->alamat }}
                                    </p>
                                @endif
                            </div>

                            {{-- Aksi --}}
                            <div class="flex flex-col xs:flex-row gap-2">
                                {{-- DETAIL -> MODAL --}}
                                <button type="button" onclick="openDetailModal({{ $req->id }})"
                                    class="flex-1 inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-medium border border-rose-200 text-rose-700 hover:bg-rose-50">
                                    Detail
                                </button>

                                <form action="{{ route('admin.mua-requests.approve', $req) }}" method="POST" class="flex-1"
                                    onsubmit="return confirm('Setujui pengajuan ini dan jadikan user sebagai MUA?');">
                                    @csrf
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-medium bg-emerald-500 text-white hover:bg-emerald-600">
                                        Setujui
                                    </button>
                                </form>

                                <button type="button"
                                    class="flex-1 inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-medium bg-rose-500 text-white hover:bg-rose-600"
                                    onclick="openRejectModal({{ $req->id }}, '{{ addslashes(optional($req->user)->name ?? 'User') }}')">
                                    Tolak
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ========== DESKTOP: TABLE VIEW ========== --}}
                <div class="hidden md:block overflow-x-auto">
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
                                    <td class="py-3 px-4 align-top text-xs text-slate-500 whitespace-nowrap">
                                        {{ $req->created_at?->format('d M Y H:i') }}
                                    </td>
                                    <td class="py-3 px-4 align-top">
                                        <div class="flex flex-col gap-2 w-40">
                                            {{-- DETAIL -> MODAL --}}
                                            <button type="button" onclick="openDetailModal({{ $req->id }})"
                                                class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs border border-rose-200 text-rose-700 hover:bg-rose-50">
                                                Detail
                                            </button>

                                            <form action="{{ route('admin.mua-requests.approve', $req) }}" method="POST"
                                                onsubmit="return confirm('Setujui pengajuan ini dan jadikan user sebagai MUA?');">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs bg-emerald-500 text-white hover:bg-emerald-600">
                                                    Setujui
                                                </button>
                                            </form>

                                            <button type="button"
                                                onclick="openRejectModal({{ $req->id }}, '{{ addslashes(optional($req->user)->name ?? 'User') }}')"
                                                class="w-full inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs bg-rose-500 text-white hover:bg-rose-600">
                                                Tolak
                                            </button>
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
            @endif
        </div>

        {{-- ========= SECTION RIWAYAT (APPROVED + REJECTED) ========= --}}
        <div class="bg-white border border-rose-100 rounded-2xl overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-rose-100 flex items-center justify-between gap-2">
                <div>
                    <h3 class="font-semibold text-slate-900 text-sm sm:text-base">Riwayat Pengajuan MUA</h3>
                    <p class="text-[11px] sm:text-xs text-slate-500">Pengajuan yang sudah diproses admin.</p>
                </div>
                <span class="text-[11px] sm:text-xs text-slate-400">
                    {{ $approved->count() }} disetujui · {{ $rejected->count() }} ditolak
                </span>
            </div>

            @php
                $history = $approved->concat($rejected)->sortByDesc('updated_at');
            @endphp

            @if ($history->isEmpty())
                <div class="p-4 sm:p-6 text-center text-sm text-slate-500">
                    Belum ada riwayat pengajuan yang diproses.
                </div>
            @else
                {{-- MOBILE: CARD --}}
                <div class="md:hidden divide-y divide-rose-100">
                    @foreach ($history as $req)
                        <div class="px-4 py-4">
                            <div class="flex justify-between items-start gap-3 mb-1.5">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ optional($req->user)->name ?? '-' }}
                                    </p>
                                    <p class="text-[11px] text-slate-400 break-all">
                                        {{ optional($req->user)->email ?? '-' }}
                                    </p>
                                </div>
                                <p class="text-[11px] text-slate-500 whitespace-nowrap">
                                    {{ $req->updated_at?->format('d M Y H:i') }}
                                </p>
                            </div>

                            <p class="text-xs text-slate-400 mb-0.5">Nama Usaha</p>
                            <p class="text-sm text-slate-800 mb-2">
                                {{ $req->nama_usaha }}
                            </p>

                            <div class="mb-2">
                                @if($req->status === 'approved')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] bg-emerald-50 text-emerald-700">
                                        Disetujui
                                    </span>
                                @elseif($req->status === 'rejected')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] bg-rose-50 text-rose-700">
                                        Ditolak
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] bg-amber-50 text-amber-700">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-[11px] text-slate-500 mb-3">
                                {{ $req->catatan_admin ?: 'Tidak ada catatan admin.' }}
                            </p>

                            <button type="button" onclick="openDetailModal({{ $req->id }})"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] border border-rose-200 text-rose-700 hover:bg-rose-50">
                                Lihat Detail
                            </button>
                        </div>
                    @endforeach
                </div>

                {{-- DESKTOP: TABLE --}}
                <div class="hidden md:block overflow-x-auto">
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
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs bg-emerald-50 text-emerald-700">
                                                Disetujui
                                            </span>
                                        @elseif($req->status === 'rejected')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs bg-rose-50 text-rose-700">
                                                Ditolak
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs bg-amber-50 text-amber-700">
                                                {{ ucfirst($req->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 align-top text-xs text-slate-600 max-w-xs">
                                        {{ $req->catatan_admin ?: '-' }}
                                    </td>
                                    <td class="py-3 px-4 align-top text-xs text-slate-500 whitespace-nowrap">
                                        {{ $req->updated_at?->format('d M Y H:i') }}
                                    </td>
                                    <td class="py-3 px-4 align-top text-right">
                                        <button type="button" onclick="openDetailModal({{ $req->id }})"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs border border-rose-200 text-rose-700 hover:bg-rose-50">
                                            Lihat
                                        </button>
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
            @endif
        </div>

        {{-- ========= MODAL TOLAK PENGAJUAN ========= --}}
        <div id="rejectModal"
            class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <form id="rejectForm" method="POST"
                class="bg-white rounded-2xl w-[90%] max-w-md p-6 shadow-lg border border-rose-100">
                @csrf
                <h2 class="text-lg md:text-xl font-semibold text-rose-700 mb-2">
                    Tolak Pengajuan MUA
                </h2>
                <p class="text-xs text-slate-500 mb-3">
                    Beri alasan penolakan untuk
                    <span id="rejectUserName" class="font-semibold"></span>.
                </p>

                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Alasan Penolakan <span class="text-rose-500">*</span>
                </label>
                <textarea name="catatan_admin" rows="3" required minlength="5"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400"></textarea>

                <div class="mt-5 flex justify-end gap-2">
                    <button type="button" onclick="closeRejectModal()
                            " class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-sm">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm">
                        Ya, Tolak
                    </button>
                </div>
            </form>
        </div>

        {{-- ========= MODAL DETAIL PENGAJUAN ========= --}}
        <div id="detailModal"
            class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div
                class="bg-white rounded-2xl w-[94%] max-w-2xl p-6 shadow-lg border border-rose-100 max-h-[90vh] overflow-y-auto">

                <div class="flex items-start justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-lg md:text-xl font-semibold text-slate-900">
                            Detail Pengajuan MUA
                        </h2>
                        <p class="text-xs text-slate-500">
                            Lihat informasi lengkap pengajuan user.
                        </p>
                    </div>
                    <button type="button" onclick="closeDetailModal()"
                        class="text-slate-400 hover:text-slate-600 text-xl leading-none">
                        &times;
                    </button>
                </div>

                {{-- USER INFO --}}
                <div class="mb-4 pb-4 border-b border-rose-50">
                    <p class="text-[11px] font-semibold tracking-wide text-slate-500 uppercase">User</p>
                    <p id="detailUserName" class="text-sm font-semibold text-slate-900">-</p>
                    <p id="detailUserEmail" class="text-xs text-slate-500 break-all">-</p>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="space-y-3">
                        <div>
                            <p class="text-[11px] font-semibold tracking-wide text-slate-500 uppercase">Nama Usaha</p>
                            <p id="detailNamaUsaha" class="text-sm text-slate-900">-</p>
                        </div>

                        <div>
                            <p class="text-[11px] font-semibold tracking-wide text-slate-500 uppercase">Kontak WA</p>
                            <p id="detailKontakWa" class="text-sm text-slate-900">-</p>
                        </div>

                        <div>
                            <p class="text-[11px] font-semibold tracking-wide text-slate-500 uppercase">Alamat</p>
                            <p id="detailAlamat" class="text-sm text-slate-900">-</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <p class="text-[11px] font-semibold tracking-wide text-slate-500 uppercase">Instagram</p>
                            <p id="detailInstagram" class="text-sm text-slate-900">-</p>
                        </div>

                        <div>
                            <p class="text-[11px] font-semibold tracking-wide text-slate-500 uppercase">TikTok</p>
                            <p id="detailTiktok" class="text-sm text-slate-900">-</p>
                        </div>

                        <div>
                            <p class="text-[11px] font-semibold tracking-wide text-slate-500 uppercase">Status</p>
                            <span id="detailStatusBadge"
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs bg-amber-50 text-amber-700">
                                -
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-[11px] font-semibold tracking-wide text-slate-500 uppercase">Deskripsi Usaha</p>
                        <div id="detailDeskripsi"
                            class="text-sm leading-relaxed text-slate-800 bg-amber-50/60 rounded-2xl px-4 py-3">
                            -
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] font-semibold tracking-wide text-slate-500 uppercase">Catatan Admin</p>
                        <p id="detailCatatanAdmin" class="text-sm text-slate-800">
                            -
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-[11px] text-slate-500">
                        <span> Dibuat: <span id="detailCreatedAt">-</span> </span>
                        <span>·</span>
                        <span> Diupdate: <span id="detailUpdatedAt">-</span> </span>
                    </div>
                </div>

                <div class="mt-5 flex justify-end">
                    <button type="button" onclick="closeDetailModal()"
                        class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm">
                        Tutup
                    </button>
                </div>

            </div>
        </div>

        <script>
            function openRejectModal(id, name) {
                const modal = document.getElementById('rejectModal');
                const form = document.getElementById('rejectForm');
                const span = document.getElementById('rejectUserName');

                // set URL action: /admin/mua-requests/{id}/reject
                form.action = "{{ url('admin/mua-requests') }}/" + id + "/reject";
                span.textContent = name || 'user';

                modal.classList.remove('hidden');
            }

            function closeRejectModal() {
                const modal = document.getElementById('rejectModal');
                modal.classList.add('hidden');
            }

            // ========== DETAIL MODAL ==========
            function openDetailModal(id) {
                const modal = document.getElementById('detailModal');

                setDetailModalLoading();

                fetch("{{ url('admin/mua-requests') }}/" + id, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal mengambil data');
                        return res.json();
                    })
                    .then(data => {
                        fillDetailModal(data);
                        modal.classList.remove('hidden');
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Gagal memuat detail pengajuan.');
                    });
            }

            function closeDetailModal() {
                const modal = document.getElementById('detailModal');
                modal.classList.add('hidden');
            }

            function setDetailModalLoading() {
                document.getElementById('detailUserName').textContent = 'Memuat...';
                document.getElementById('detailUserEmail').textContent = '';
                document.getElementById('detailNamaUsaha').textContent = '-';
                document.getElementById('detailKontakWa').textContent = '-';
                document.getElementById('detailAlamat').textContent = '-';
                document.getElementById('detailInstagram').textContent = '-';
                document.getElementById('detailTiktok').textContent = '-';
                document.getElementById('detailDeskripsi').textContent = '-';
                document.getElementById('detailCatatanAdmin').textContent = '-';
                document.getElementById('detailCreatedAt').textContent = '-';
                document.getElementById('detailUpdatedAt').textContent = '-';

                const badge = document.getElementById('detailStatusBadge');
                badge.textContent = '-';
                badge.className =
                    'inline-flex items-center px-2.5 py-1 rounded-full text-xs bg-amber-50 text-amber-700';
            }

            function fillDetailModal(data) {
                // user
                document.getElementById('detailUserName').textContent = (data.user && data.user.name) ? data.user.name : '-';
                document.getElementById('detailUserEmail').textContent = (data.user && data.user.email) ? data.user.email : '-';

                // field utama
                document.getElementById('detailNamaUsaha').textContent = data.nama_usaha || '-';
                document.getElementById('detailKontakWa').textContent = data.kontak_wa || '-';
                document.getElementById('detailAlamat').textContent = data.alamat || '-';
                document.getElementById('detailInstagram').textContent = data.instagram || '-';
                document.getElementById('detailTiktok').textContent = data.tiktok || '-';
                document.getElementById('detailDeskripsi').textContent = data.deskripsi || '-';
                document.getElementById('detailCatatanAdmin').textContent = data.catatan_admin || '-';

                document.getElementById('detailCreatedAt').textContent = data.created_at_formatted || '-';
                document.getElementById('detailUpdatedAt').textContent = data.updated_at_formatted || '-';

                // status badge
                const badge = document.getElementById('detailStatusBadge');
                let text = 'Pending';
                let cls = 'bg-amber-50 text-amber-700';

                if (data.status === 'approved') {
                    text = 'Disetujui';
                    cls = 'bg-emerald-50 text-emerald-700';
                } else if (data.status === 'rejected') {
                    text = 'Ditolak';
                    cls = 'bg-rose-50 text-rose-700';
                }

                badge.textContent = text;
                badge.className =
                    'inline-flex items-center px-2.5 py-1 rounded-full text-xs ' + cls;
            }
        </script>

    </div>
@endsection