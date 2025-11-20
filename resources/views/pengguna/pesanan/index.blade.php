<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - AdatKu</title>

    {{-- FONTS & TAILWIND --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Great+Vibes&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes modal-pop {
            0% {
                opacity: 0;
                transform: translateY(12px) scale(0.96);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-card {
            animation: modal-pop 0.22s ease-out;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff9fb;
            /* pattern lembut seperti home */
            background-image:
                linear-gradient(135deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
                linear-gradient(225deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
                linear-gradient(315deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
                linear-gradient(45deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%);
            background-size: 24px 24px;
            background-position: 0 0, 0 12px, 12px -12px, -12px 0;
        }

        .logo-font {
            font-family: 'Perfecto Kaligrafi', 'Great Vibes', cursive;
        }

        .status-dot::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background-color: currentColor;
            display: inline-block;
            margin-right: 6px;
        }

        .card-shadow {
            box-shadow: 0 22px 60px rgba(15, 23, 42, 0.10);
        }
    </style>
</head>

<body class="text-slate-800 min-h-screen flex flex-col">

    {{-- ================= HEADER: STRIP PUTIH PANJANG ================= --}}
    <header class="sticky top-0 z-50 bg-white/95 border-b border-rose-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">

            {{-- KIRI: LOGO + NAMA --}}
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                        class="w-14 h-14 rounded-full object-cover shadow-md">
                    <h1
                        class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
                        AdatKu
                    </h1>
                </a>
            </div>

            {{-- KANAN: MENU BERANDA & DAFTAR MUA DENGAN PANAH --}}
            <nav class="flex items-center gap-6 text-sm md:text-base font-medium">
                <a href="{{ url('/') }}" class="text-[#b48a00] hover:text-[#eab308] flex items-center gap-1 transition">
                    <span class="text-lg">←</span>
                    <span>Beranda</span>
                </a>

                <a href="{{ url('/daftarmua') }}"
                    class="text-[#b48a00] hover:text-[#eab308] flex items-center gap-1 transition">
                    <span class="text-lg">←</span>
                    <span>Daftar MUA</span>
                </a>
            </nav>
        </div>
    </header>

    {{-- ================= KONTEN PESANAN ================= --}}
    <main class="flex-1">
        <section class="max-w-6xl mx-auto px-6 pt-8">
            <p class="text-[11px] font-semibold tracking-[0.26em] uppercase text-rose-400">
                Pengguna
            </p>
            <h1 class="text-3xl md:text-4xl font-semibold text-rose-700 mb-1.5">
                Pesanan Saya
            </h1>
            <p class="text-sm md:text-base text-slate-600 max-w-xl">
                Lihat dan kelola semua pesanan layanan yang pernah kamu buat. Cek status pembayaran dan hubungi MUA
                untuk melanjutkan pembayaran.
            </p>
        </section>

        <section class="max-w-6xl mx-auto px-6 mt-7 mb-20">
            @if ($pesanans->isEmpty())
                <div
                    class="mt-4 rounded-[28px] border border-dashed border-rose-200 bg-[rgba(255,242,213,0.65)] px-6 py-10 text-center">
                    <p class="text-3xl mb-2">✨</p>
                    <p class="text-sm font-medium text-slate-700">Kamu belum punya pesanan apa pun.</p>
                    <p class="text-xs text-slate-500 mt-1">
                        Yuk jelajahi layanan MUA dan adat di AdatKu, lalu buat pesanan pertamamu.
                    </p>
                    <a href="{{ url('/') }}"
                        class="inline-flex mt-4 px-5 py-2 rounded-full text-xs font-semibold bg-rose-500 text-white hover:bg-rose-600 transition">
                        Cari Layanan Sekarang
                    </a>
                </div>
            @else
                <div class="space-y-5">
                    @foreach ($pesanans as $item)
                        @php
                            $mua = $item->layanan->mua ?? null;
                            if ($mua) {
                                $waNumber = $mua->kontak_wa ?? null;
                                $namaMua = $mua->nama_toko ?? $mua->nama;
                            } else {
                                $waNumber = null;
                                $namaMua = '';
                            }

                            $tanggal = \Carbon\Carbon::parse($item->tanggal_booking)->translatedFormat('d M Y');
                            $namaUser = $item->pengguna->name;
                            $namaLayanan = $item->layanan->nama ?? '-';

                            $waText = $mua
                                ? urlencode(
                                    "Halo Kak $namaMua, saya $namaUser ingin melanjutkan / konfirmasi pembayaran pesanan $namaLayanan untuk tanggal {$tanggal}.",
                                )
                                : '';

                            $status = $item->status_pembayaran;
                            $statusLabel = str_replace('_', ' ', $status);

                            $statusClass =
                                $status === 'Lunas'
                                ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                : ($status === 'Belum_Lunas'
                                    ? 'bg-amber-50 text-amber-700 border-amber-100'
                                    : 'bg-slate-50 text-slate-600 border-slate-100');
                        @endphp

                        {{-- ================== KARTU PESANAN ================== --}}
                        <article
                            class="bg-white/95 rounded-[28px] card-shadow border border-rose-100 overflow-hidden flex flex-col md:flex-row">

                            {{-- KIRI: RINCIAN PESANAN (mirip detail) --}}
                            <div class="flex-1 px-6 md:px-8 py-5 md:py-7 space-y-2">
                                <p class="text-[10px] font-semibold tracking-[0.26em] uppercase text-rose-400">
                                    Rincian Pesanan
                                </p>

                                <h2 class="text-xl md:text-2xl font-semibold text-rose-700">
                                    {{ $namaLayanan }}
                                </h2>

                                <p class="text-xs text-slate-500 max-w-md">
                                    Booking untuk tanggal
                                    <span class="font-semibold text-slate-800">
                                        {{ \Carbon\Carbon::parse($item->tanggal_booking)->translatedFormat('d M Y') }}
                                    </span>.
                                    Cek status pembayaran dan hubungi MUA jika kamu butuh bantuan.
                                </p>

                                <div class="mt-3 space-y-1.5 text-sm">
                                    <div class="flex">
                                        <span class="w-32 text-slate-500">Booking</span>
                                        <span class="flex-1 font-medium text-slate-800">
                                            {{ \Carbon\Carbon::parse($item->tanggal_booking)->translatedFormat('d M Y') }}
                                        </span>
                                    </div>

                                    <div class="flex">
                                        <span class="w-32 text-slate-500">Status</span>
                                        <span class="flex-1">
                                            <span
                                                class="status-dot inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium border {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                @php
                                    $detailPayload = [
                                        "layanan" => $namaLayanan,
                                        "tanggal" => \Carbon\Carbon::parse($item->tanggal_booking)->translatedFormat("d F Y"),
                                        "alamat"  => $item->alamat,
                                        "status"  => $statusLabel, // Lunas / Belum Lunas / Dibatalkan
                                        "harga"   => "Rp " . number_format($item->total_harga, 0, ",", "."),
                                        "created" => $item->created_at->format("d/m/Y H:i"),
                                        "updated" => $item->updated_at->format("d/m/Y H:i"),
                                    ];
                                @endphp

                                <button type="button"
                                    class="inline-flex items-center gap-1 mt-3 text-xs font-semibold text-rose-500 hover:text-rose-600 hover:underline underline-offset-2"
                                    onclick='openDetailModal(@json($detailPayload))'>
                                    <span>Detail pesanan</span>
                                    <span>↗</span>
                                </button>
                            </div>

                            {{-- KANAN: RINGKASAN + AKSI (mirip panel kanan detail) --}}
                            <div
                                class="md:w-72 bg-gradient-to-b from-rose-50/80 to-amber-50/60 border-t md:border-t-0 md:border-l border-rose-100 px-6 md:px-7 py-5 md:py-7 flex flex-col justify-between">
                                <div class="space-y-3 text-right md:text-left">
                                    <p class="text-[10px] font-semibold tracking-[0.26em] uppercase text-rose-400">
                                        Ringkasan
                                    </p>

                                    <div class="flex md:block items-center justify-between md:justify-start gap-2">
                                        <span class="text-xs text-slate-500 md:block">Total Harga</span>
                                        <span class="text-2xl md:text-3xl font-extrabold text-amber-600">
                                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="text-[11px] text-slate-500 space-y-0.5 md:text-left">
                                        <p>Pesanan dibuat:
                                            <span class="font-medium text-slate-700">
                                                {{ $item->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </p>
                                        <p>Terakhir diperbarui:
                                            <span class="font-medium text-slate-700">
                                                {{ $item->updated_at->format('d/m/Y H:i') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-col items-stretch md:items-start gap-2">
                                    @if ($waNumber && $item->status_pembayaran !== 'Dibatalkan')
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank"
                                            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-full
                                                                                                                              bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100 hover:bg-emerald-100 transition">
                                            <span>💬</span>
                                            <span>Chat MUA via WhatsApp</span>
                                        </a>
                                    @endif

                                    @if ($item->status_pembayaran === 'Belum_Lunas')
                                        {{-- FORM BATALKAN PESANAN (untuk modal custom) --}}
                                        <form method="POST" action="{{ route('pengguna.destroy', $item->id) }}" class="cancel-form"
                                            id="cancel-form-{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="w-full md:w-auto px-4 py-2 rounded-full text-xs font-semibold
                                                                                                                bg-rose-500 text-white hover:bg-rose-600 transition btn-cancel-pesanan"
                                                data-id="{{ $item->id }}">
                                                Batalkan Pesanan
                                            </button>
                                        </form>
                                    @elseif ($item->status_pembayaran === 'Dibatalkan')
                                        <span
                                            class="inline-block px-4 py-2 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500">
                                            Pesanan dibatalkan
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </article>
                        {{-- ================== END KARTU PESANAN ================== --}}
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    {{-- =============== MODAL KONFIRMASI BATALKAN PESANAN =============== --}}
    <div id="cancelModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
        <div
            class="modal-card bg-white rounded-3xl shadow-2xl max-w-sm w-[90%] px-6 pt-6 pb-5 relative overflow-hidden">

            {{-- Accent gradient --}}
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-rose-500 via-amber-400 to-pink-500"></div>

            <div class="flex items-start gap-3">
                <div
                    class="mt-1 flex h-10 w-10 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-xl">
                    !
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 mb-1">
                        Batalkan pesanan?
                    </h2>
                    <p class="text-sm text-slate-500">
                        Yakin ingin membatalkan pesanan ini? Tindakan ini tidak bisa dibatalkan
                        dan kamu perlu membuat pesanan baru jika berubah pikiran.
                    </p>
                </div>
            </div>

            <div class="mt-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <button type="button" onclick="closeCancelModal()" class="w-full sm:w-auto px-4 py-2 rounded-full text-xs font-semibold
                               border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                    Kembali
                </button>

                <button type="button" onclick="confirmCancel()" class="w-full sm:w-auto px-4 py-2 rounded-full text-xs font-semibold
                               bg-rose-500 text-white hover:bg-rose-600 transition">
                    Ya, batalkan pesanan
                </button>
            </div>
        </div>
    </div>

    {{-- =============== MODAL DETAIL PESANAN =============== --}}
    <div id="detailModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="modal-card bg-white/95 rounded-3xl border border-rose-100 card-shadow overflow-hidden
                w-[95%] max-w-5xl flex flex-col lg:flex-row">

            {{-- Kiri: judul & info utama --}}
            <div class="lg:w-2/3 p-8 lg:p-10 space-y-4">
                <p class="text-xs font-semibold tracking-[0.18em] uppercase text-rose-500">
                    Rincian Pesanan
                </p>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-rose-700">
                    Detail Pesanan
                </h1>

                <p class="text-sm text-slate-500 max-w-md">
                    Berikut informasi lengkap pesanan layanan yang kamu buat. Pastikan data sudah benar sebelum
                    melanjutkan proses berikutnya.
                </p>

                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex">
                        <span class="w-32 text-slate-500 font-medium">Layanan</span>
                        <span id="dm-layanan" class="flex-1 font-semibold text-slate-800"></span>
                    </div>

                    <div class="flex">
                        <span class="w-32 text-slate-500 font-medium">Tanggal Booking</span>
                        <span id="dm-tanggal" class="flex-1 font-medium text-slate-800"></span>
                    </div>

                    <div class="flex">
                        <span class="w-32 text-slate-500 font-medium">Alamat</span>
                        <span id="dm-alamat" class="flex-1 font-medium text-slate-800"></span>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <span class="w-32 text-slate-500 font-medium">Status Pembayaran</span>
                        <span id="dm-status"></span>
                    </div>
                </div>
            </div>

            {{-- Kanan: ringkasan --}}
            <div class="lg:w-1/3 bg-gradient-to-b from-rose-50/80 to-amber-50/60 p-8 flex flex-col justify-between">
                <div class="space-y-4">
                    <p class="text-xs font-semibold tracking-[0.18em] uppercase text-rose-500">
                        Ringkasan
                    </p>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600">Total Harga</span>
                        <span id="dm-harga" class="text-xl font-extrabold text-rose-600"></span>
                    </div>

                    <div class="mt-4 text-xs text-slate-500 space-y-1">
                        <p>Dibuat pada:
                            <span id="dm-created" class="font-medium text-slate-700"></span>
                        </p>
                        <p>Diperbarui:
                            <span id="dm-updated" class="font-medium text-slate-700"></span>
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-2">
                    <button type="button" onclick="closeDetailModal()"
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-2xl border border-rose-100 bg-white/80 text-xs font-medium text-rose-600 hover:bg-rose-50 transition">
                        Tutup Detail
                    </button>
                </div>
            </div>

        </div>
    </div>

    <footer class="mt-10">
        <div class="relative bg-gradient-to-br from-[#3b2128] via-[#4a2e38] to-[#351b27] text-[wheat] pt-10 pb-6 px-5">
            {{-- ORNAMENT PATTERN --}}
            <div
                class="absolute inset-0 opacity-[0.09] bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]">
            </div>

            {{-- CONTENT --}}
            <div class="relative max-w-6xl mx-auto text-center">
                <h1
                    class="logo-font text-4xl bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent drop-shadow-[0_2px_6px_rgba(0,0,0,0.4)]">
                    AdatKu
                </h1>

                <p class="text-sm mt-2 text-[#f5e9df] max-w-xl mx-auto leading-relaxed">
                    Platform penyewaan MUA & busana adat untuk mempercantik acara istimewa kamu.
                    Budaya tetap hidup, tampil tetap elegan ✨
                </p>

                <div class="mt-4 flex justify-center gap-5 text-sm font-medium">
                    <a href="/" class="hover:text-[#f7e07b] transition">Beranda</a>
                    <a href="#" class="hover:text-[#f7e07b] transition">Tentang Kami</a>
                    <a href="{{ route('hubungikami') }}" class="hover:text-[#f7e07b] transition">Hubungi Kami</a>
                </div>

                <p class="mt-6 text-xs text-[#e2c9bf]">
                    &copy; 2025 <span class="font-semibold">AdatKu</span> — Semua Hak Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    <script>
        let selectedPesananId = null;

        // setelah DOM siap
        document.addEventListener('DOMContentLoaded', function () {
            // pasang event click ke semua tombol batal
            document.querySelectorAll('.btn-cancel-pesanan').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault(); // cegah submit form dulu
                    selectedPesananId = this.dataset.id;

                    const modal = document.getElementById('cancelModal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });
        });

        function closeCancelModal() {
            selectedPesananId = null;
            const modal = document.getElementById('cancelModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function confirmCancel() {
            if (!selectedPesananId) return;

            const form = document.getElementById(`cancel-form-${selectedPesananId}`);
            if (form) {
                form.submit();
            }
            closeCancelModal();
        }

        // tutup modal kalau klik area gelap di luar kartu
        document.addEventListener('click', function (e) {
            const modal = document.getElementById('cancelModal');
            if (e.target === modal) {
                closeCancelModal();
            }
        });

        // tutup modal dengan tombol ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCancelModal();
            }
        });
    </script>

    <script>
        function openDetailModal(data) {
            // isi text
            document.getElementById('dm-layanan').innerText = data.layanan;
            document.getElementById('dm-tanggal').innerText = data.tanggal;
            document.getElementById('dm-alamat').innerText = data.alamat;
            document.getElementById('dm-harga').innerText = data.harga;
            document.getElementById('dm-created').innerText = data.created;
            document.getElementById('dm-updated').innerText = data.updated;

            // badge status
            let badge = '';
            if (data.status.toLowerCase().includes('lunas') && !data.status.toLowerCase().includes('belum')) {
                badge = `<span class="px-3 py-1.5 text-[11px] rounded-full bg-emerald-100 text-emerald-700 font-semibold">Lunas</span>`;
            } else if (data.status.toLowerCase().includes('belum')) {
                badge = `<span class="px-3 py-1.5 text-[11px] rounded-full bg-yellow-100 text-yellow-700 font-semibold">Belum Lunas</span>`;
            } else {
                badge = `<span class="px-3 py-1.5 text-[11px] rounded-full bg-rose-100 text-rose-700 font-semibold">Dibatalkan</span>`;
            }
            document.getElementById('dm-status').innerHTML = badge;

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // tutup kalau klik area gelap
        document.addEventListener('click', function (e) {
            const modal = document.getElementById('detailModal');
            if (e.target === modal) {
                closeDetailModal();
            }
        });

        // tutup dengan ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDetailModal();
            }
        });
    </script>

</body>

</html>