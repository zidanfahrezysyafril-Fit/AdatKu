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
            background-image:
                linear-gradient(135deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
                linear-gradient(225deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%);
            background-size: 26px 26px;
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

        .floating-icon {
            position: fixed;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.9);
            z-index: 30;
            pointer-events: none;
            text-shadow: 0 0 12px rgba(0, 0, 0, 0.18);
        }

        .icon-md {
            font-size: 22px;
        }

        .icon-lg {
            font-size: 30px;
        }

        .icon-xl {
            font-size: 38px;
        }

        @keyframes float-up {
            0% {
                transform: translateY(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            100% {
                transform: translateY(-140vh);
                opacity: 0;
            }
        }

        .from-bottom {
            bottom: -10%;
            animation-name: float-up;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }

        @keyframes float-down {
            0% {
                transform: translateY(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            100% {
                transform: translateY(140vh);
                opacity: 0;
            }
        }

        .from-top {
            top: -10%;
            animation-name: float-down;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }
    </style>
</head>

<body class="text-slate-800 min-h-screen flex flex-col">

    {{-- ================= HEADER ================= --}}
    <header class="sticky top-0 z-50 bg-white/95 border-b border-amber-100 shadow-sm backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">

            {{-- KIRI: LOGO + NAMA --}}
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                        class="w-14 h-14 rounded-full object-cover shadow-md border border-amber-200">
                    <h1
                        class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
                        AdatKu
                    </h1>
                </a>
            </div>

            {{-- KANAN: MENU --}}
            <nav class="flex items-center gap-6 text-sm md:text-base font-medium text-[#b48a00]">
                <a href="{{ url('/') }}" class="hover:text-[#eab308] flex items-center gap-1 transition">
                    <span class="text-lg">←</span>
                    <span>Beranda</span>
                </a>

                <a href="{{ url('/daftarmua') }}" class="hover:text-[#eab308] flex items-center gap-1 transition">
                    <span class="text-lg">←</span>
                    <span>Daftar MUA</span>
                </a>
            </nav>
        </div>
    </header>

    {{-- ================= KONTEN PESANAN ================= --}}
    <main class="flex-1">
        {{-- FLASH MESSAGE --}}
        @if (session('success') || session('error'))
            <div class="max-w-6xl mx-auto px-6 mt-4">
                <div class="mb-4 flex items-start gap-3 px-4 py-3 rounded-2xl text-sm shadow-sm
                                                @if(session('success'))
                                                    bg-emerald-50 border border-emerald-200 text-emerald-800
                                                @else
                                                    bg-rose-50 border border-rose-200 text-rose-800
                                                @endif">
                    <div class="mt-0.5">
                        @if (session('success')) ✓ @else ! @endif
                    </div>
                    <div class="flex-1 font-medium">
                        {{ session('success') ?? session('error') }}
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()"
                        class="ml-auto text-[11px] font-semibold uppercase tracking-wide">
                        Tutup
                    </button>
                </div>
            </div>
        @endif
        <section class="max-w-6xl mx-auto px-6 pt-8">
            <p class="text-[11px] font-semibold tracking-[0.26em] uppercase text-amber-400">
                Pengguna
            </p>
            <h1 class="text-3xl md:text-4xl font-semibold text-amber-500 mb-1.5">
                Pesanan Saya
            </h1>
            <p class="text-sm md:text-base text-slate-600 max-w-xl">
                Lihat dan kelola semua pesanan layanan yang pernah kamu buat. Cek status pembayaran dan hubungi MUA
                untuk melanjutkan pembayaran.
            </p>
        </section>

        <section class="max-w-6xl mx-auto px-6 mt-7 mb-20">
            @php
                // 1 checkout = 1 kartu
                $groupedPesanan = $pesanan->groupBy(function ($p) {
                    return $p->kode_checkout ?: ('single-' . $p->id);
                });

                // helper format nomor WA (bikin sekali, aman kalau dipakai di view lain juga)
                if (!function_exists('formatWaNumber')) {
                    function formatWaNumber(?string $number): ?string
                    {
                        if (empty($number)) {
                            return null;
                        }

                        // buang semua non-angka
                        $n = preg_replace('/\D+/', '', $number);

                        if ($n === '' || $n === null) {
                            return null;
                        }

                        // 0xxxxxxxxx -> 62xxxxxxxxx
                        if (substr($n, 0, 1) === '0') {
                            return '62' . substr($n, 1);
                        }

                        // sudah 62xxxxxxxx
                        if (substr($n, 0, 2) === '62') {
                            return $n;
                        }

                        // 8xxxxxxxx -> 628xxxxxxxx
                        if (substr($n, 0, 1) === '8') {
                            return '62' . $n;
                        }

                        // fallback
                        return $n;
                    }
                }
            @endphp

            @if ($groupedPesanan->isEmpty())
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
                    @foreach ($groupedPesanan as $groupKey => $group)
                        @php
                            $first = $group->first();

                            // list layanan di checkout ini
                            $layananList = $group
                                ->map(fn($p) => optional($p->layanan)->nama)
                                ->filter()
                                ->values();

                            $jumlahLayanan = $layananList->count();
                            $namaUtama = $layananList->first() ?? '-';

                            if ($jumlahLayanan > 1) {
                                $namaDisplay = $namaUtama . ' + ' . ($jumlahLayanan - 1) . ' layanan lain';
                            } else {
                                $namaDisplay = $namaUtama;
                            }

                            $totalHarga = $group->sum('total_harga');

                            // MUA pertama (buat teks WA)
                            $mua = optional(optional($first->layanan)->mua);
                            if ($mua) {
                                // pakai helper biar selalu 62xxxxxxxx
                                $waNumber = formatWaNumber($mua->kontak_wa ?? null);
                                $namaMua = $mua->nama_toko ?? $mua->nama_usaha ?? $mua->nama;
                            } else {
                                $waNumber = null;
                                $namaMua = '';
                            }

                            $tanggalBooking = \Carbon\Carbon::parse($first->tanggal_booking)->translatedFormat('d M Y');
                            $tanggalBookingLong = \Carbon\Carbon::parse($first->tanggal_booking)->translatedFormat('d F Y');

                            $namaUser = optional($first->pengguna)->name ?? 'Pelanggan';

                            $waText = ($mua && $waNumber)
                                ? rawurlencode(
                                    "Halo Kak $namaMua, saya $namaUser ingin melanjutkan / konfirmasi pembayaran pesanan (" .
                                    $layananList->implode(', ') .
                                    ") untuk tanggal {$tanggalBookingLong} dengan total Rp " .
                                    number_format($totalHarga, 0, ',', '.') .
                                    '.'
                                )
                                : '';

                            // ====== AGREGASI STATUS SE-KELOMPOK ======
                            $statusSet = $group->pluck('status_pembayaran')->unique();

                            if ($statusSet->count() === 1 && $statusSet->first() === 'Lunas') {
                                $status = 'Lunas';
                            } elseif ($statusSet->count() === 1 && $statusSet->first() === 'Dibatalkan') {
                                $status = 'Dibatalkan';
                            } else {
                                // campuran / ada yg belum lunas -> tampilkan "Belum Lunas"
                                $status = 'Belum_Lunas';
                            }

                            $statusLabel = str_replace('_', ' ', $status);

                            $statusClass =
                                $status === 'Lunas'
                                ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                : ($status === 'Belum_Lunas'
                                    ? 'bg-amber-50 text-amber-700 border-amber-100'
                                    : 'bg-slate-50 text-slate-600 border-slate-100');

                            $detailPayload = [
                                'layanan' => $layananList->implode(', '),
                                'tanggal' => $tanggalBookingLong,
                                'alamat' => $first->alamat,
                                'status' => $statusLabel,
                                'harga' => 'Rp ' . number_format($totalHarga, 0, ',', '.'),
                                'created' => $first->created_at->format('d/m/Y H:i'),
                                'updated' => $first->updated_at->format('d/m/Y H:i'),
                            ];
                        @endphp

                        {{-- ================== KARTU PESANAN ================== --}}
                        <article
                            class="bg-white/95 rounded-[28px] card-shadow border border-rose-100 overflow-hidden flex flex-col md:flex-row">

                            {{-- KIRI --}}
                            <div class="flex-1 px-6 md:px-8 py-5 md:py-7 space-y-2">
                                <p class="text-[10px] font-semibold tracking-[0.26em] uppercase text-amber-600">
                                    Rincian Pesanan
                                </p>

                                <h2 class="text-xl md:text-2xl font-semibold text-amber-400">
                                    {{ $namaDisplay }}
                                </h2>

                                <p class="text-xs text-slate-500 max-w-md">
                                    Booking untuk tanggal
                                    <span class="font-semibold text-slate-800">
                                        {{ $tanggalBooking }}
                                    </span>.
                                    Cek status pembayaran dan hubungi MUA jika kamu butuh bantuan.
                                </p>

                                <div class="mt-3 space-y-1.5 text-sm">
                                    <div class="flex">
                                        <span class="w-32 text-slate-500">Tanggal Booking :</span>
                                        <span class="flex-1 font-medium text-slate-800">
                                            {{ $tanggalBooking }}
                                        </span>
                                    </div>

                                    <div class="flex">
                                        <span class="w-32 text-slate-500">Status :</span>
                                        <span class="flex-1">
                                            <span
                                                class="status-dot inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium border {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                {{-- LAYANAN DI PESANAN INI --}}
                                <div class="mt-4 space-y-2">
                                    @foreach ($group as $pItem)
                                        @php
                                            $layananItem = $pItem->layanan;
                                        @endphp

                                        @if ($layananItem)
                                            <div class="flex items-center gap-3">
                                                @if ($layananItem->foto)
                                                    <img src="{{ asset($layananItem->foto) }}" alt="{{ $layananItem->nama }}"
                                                        class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                                                @else
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center text-[10px] text-rose-600 font-semibold flex-shrink-0">
                                                        {{ \Illuminate\Support\Str::limit($layananItem->nama, 8) }}
                                                    </div>
                                                @endif

                                                <div class="flex-1">
                                                    <p class="text-xs font-semibold text-slate-800">
                                                        {{ $layananItem->nama }}
                                                    </p>
                                                    <p class="text-[11px] text-slate-500">
                                                        Rp {{ number_format($pItem->total_harga, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <button type="button"
                                    class="inline-flex items-center gap-1 mt-3 text-xs font-semibold text-amber-600 hover:text-amber-300 hover:underline underline-offset-2"
                                    onclick='openDetailModal(@json($detailPayload))'>
                                    <span>Detail pesanan</span>
                                    <span>↗</span>
                                </button>
                            </div>

                            {{-- KANAN --}}
                            <div
                                class="md:w-72 bg-gradient-to-b from-rose-50/80 to-amber-50/60 border-t md:border-t-0 md:border-l border-rose-100 px-6 md:px-7 py-5 md:py-7 flex flex-col justify-between">
                                <div class="space-y-3 text-right md:text-left">
                                    <p class="text-[10px] font-semibold tracking-[0.26em] uppercase text-amber-600">
                                        Ringkasan
                                    </p>

                                    <div class="flex md:block items-center justify-between md:justify-start gap-2">
                                        <span class="text-xs text-slate-500 md:block">Total Harga</span>
                                        <span class="text-2xl md:text-3xl font-extrabold text-amber-600">
                                            Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="text-[11px] text-slate-500 space-y-0.5 md:text-left">
                                        <p>Pesanan dibuat:
                                            <span class="font-medium text-slate-700">
                                                {{ $first->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </p>
                                        <p>Terakhir diperbarui:
                                            <span class="font-medium text-slate-700">
                                                {{ $first->updated_at->format('d/m/Y H:i') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-col items-stretch md:items-start gap-2">
                                    @if ($waNumber && $status !== 'Dibatalkan')
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank"
                                            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-full
                                                                                                                                                              bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100 hover:bg-emerald-100 transition">
                                            <span>💬</span>
                                            <span>Chat MUA via WhatsApp</span>
                                        </a>
                                    @endif

                                    @if ($status === 'Belum_Lunas')
                                        {{-- FORM BATALKAN PESANAN (1 KARTU) --}}
                                        <form method="POST" action="{{ route('pengguna.destroy', $first->id) }}" class="cancel-form"
                                            id="cancel-form-{{ $first->id }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                class="w-full md:w-auto px-4 py-2 rounded-full text-xs font-semibold
                                                                                                                                                                       bg-rose-600 text-white hover:bg-rose-700 transition
                                                                                                                                                                       btn-cancel-pesanan"
                                                data-id="{{ $first->id }}">
                                                Batalkan Pesanan
                                            </button>
                                        </form>
                                    @elseif ($status === 'Dibatalkan')
                                        <span
                                            class="inline-block px-4 py-2 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500">
                                            Pesanan dibatalkan
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </article>
                        {{-- ================== END KARTU ================== --}}
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    {{-- =============== MODAL KONFIRMASI BATALKAN ================= --}}
    <div id="cancelModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
        <div
            class="modal-card bg-white rounded-3xl shadow-2xl max-w-sm w-[90%] px-6 pt-6 pb-5 relative overflow-hidden">

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

    {{-- =============== MODAL DETAIL ================= --}}
    <div id="detailModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="modal-card bg-white/95 rounded-3xl border border-rose-100 card-shadow overflow-hidden
                    w-[95%] max-w-5xl flex flex-col lg:flex-row">

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

    {{-- FOOTER --}}
    <footer class="mt-10">
        <div class="relative bg-gradient-to-br from-[#3b2128] via-[#4a2e38] to-[#351b27] text-[wheat] pt-12 pb-8 px-5">

            {{-- TEXTURE --}}
            <div
                class="absolute inset-0 opacity-[0.08] bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]">
            </div>

            <div class="relative max-w-7xl mx-auto">
                <div class="grid md:grid-cols-4 gap-10">

                    {{-- BRAND --}}
                    <div>
                        <h1 class="logo-font text-4xl bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                        bg-clip-text text-transparent drop-shadow">
                            AdatKu
                        </h1>

                        <p class="text-sm mt-3 text-[#f5e9df] leading-relaxed">
                            Platform penyewaan MUA, busana adat, dan pelaminan untuk mempercantik acara istimewa kamu.
                            Budaya tetap hidup, tampilan tetap elegan ✨
                        </p>

                        {{-- SOCIAL MEDIA --}}
                        <div class="flex items-center gap-3 mt-4">
                            <a href="https://www.instagram.com/_.adatku" target="_blank"
                                class="w-24 h-6 rounded-full bg-[#c98a00]/20 flex items-center justify-center text-[#f7e07b] hover:bg-[#c98a00]/30">
                                Instagram
                            </a>
                            <a href="mailto:adatku11@gmail.com"
                                class="w-24 h-6 rounded-full bg-[#c98a00]/20 flex items-center justify-center text-[#f7e07b] hover:bg-[#c98a00]/30">
                                adatku11
                            </a>
                        </div>
                    </div>

                    {{-- NAVIGASI --}}
                    <div class="text-sm">
                        <h3 class="font-semibold text-[#f7e07b] mb-3">Navigasi</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="hover:text-[#f7e07b] transition">Beranda</a></li>
                            <li><a href="#tentang" class="hover:text-[#f7e07b] transition">Tentang AdatKu</a></li>
                            <li><a href="#galeri" class="hover:text-[#f7e07b] transition">Galeri</a></li>
                            <li><a href="#tim" class="hover:text-[#f7e07b] transition">Tim Pengembang</a></li>
                            <li><a href="{{ route('hubungikami') }}" class="hover:text-[#f7e07b] transition">Hubungi
                                    Kami</a></li>
                            <li><a href="{{ route('mua.entry') }}" class="hover:text-[#f7e07b] transition">Daftar Jadi
                                    MUA</a></li>
                        </ul>
                    </div>

                    {{-- INFO & OPERASIONAL --}}
                    <div class="text-sm">
                        <h3 class="font-semibold text-[#f7e07b] mb-3">Informasi</h3>
                        <p class="text-[#f5e9df] text-[13px] leading-relaxed">
                            📍 Bengkalis, Riau, Indonesia<br>
                            ⏰ Layanan: 08:00 — 23:00<br>
                            💬 WhatsApp: <a href="https://wa.me/6282284886932" target="_blank"
                                class="hover:text-[#f7e07b]">082284886932</a>
                        </p>

                        <div class="mt-4 text-[12px] space-y-1">
                            <a href="#" class="hover:text-[#f7e07b]">Kebijakan Privasi</a><br>
                            <a href="#" class="hover:text-[#f7e07b]">Syarat & Ketentuan</a>
                        </div>
                    </div>

                    {{-- DEVELOPER --}}
                    <div class="text-sm">
                        <h3 class="font-semibold text-[#f7e07b] mb-3">Dikembangkan oleh</h3>
                        <p class="text-[13px] text-[#e2c9bf] leading-relaxed">
                            <span class="font-semibold">Zidan Fahrezy Syafril</span> — Fullstack & Koordinator<br>
                            <span class="font-semibold">Cahyani Putri Sofari</span> — Frontend & Dokumentasi<br>
                            <span class="font-semibold">Fetty Ratna Dewi</span> — Frontend & Dokumentasi
                        </p>

                        <p class="mt-3 text-[11px] text-[#c9b3aa]">
                            Versi Platform: 1.0.0<br>
                            Dibuat dengan ❤️ oleh Team 3
                        </p>
                    </div>
                </div>

                {{-- COPYRIGHT --}}
                <p class="mt-8 text-xs text-center text-[#f7e07b] opacity-90">
                    &copy; 2025 <span class="font-semibold">AdatKu</span> — Semua Hak Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    {{-- ICON MELAYANG (biarin sama seperti sebelumnya) --}}
    <span class="floating-icon from-bottom icon-lg"
        style="left: 5%;  animation-duration: 22s; animation-delay: 0s;">❖</span>
    <span class="floating-icon from-bottom icon-xl"
        style="left: 15%; animation-duration: 28s; animation-delay: 3s;">✿</span>
    <span class="floating-icon from-bottom icon-md"
        style="left: 25%; animation-duration: 18s; animation-delay: 6s;">❋</span>
    <span class="floating-icon from-bottom icon-lg"
        style="left: 35%; animation-duration: 25s; animation-delay: 1s;">✦</span>
    <span class="floating-icon from-bottom icon-xl"
        style="left: 45%; animation-duration: 30s; animation-delay: 5s;">❁</span>
    <span class="floating-icon from-bottom icon-md"
        style="left: 55%; animation-duration: 20s; animation-delay: 7s;">✥</span>
    <span class="floating-icon from-bottom icon-lg"
        style="left: 65%; animation-duration: 26s; animation-delay: 2s;">◈</span>
    <span class="floating-icon from-bottom icon-xl"
        style="left: 75%; animation-duration: 24s; animation-delay: 4s;">❂</span>
    <span class="floating-icon from-bottom icon-md"
        style="left: 85%; animation-duration: 29s; animation-delay: 8s;">✺</span>

    <span class="floating-icon from-top icon-lg"
        style="left: 12%; animation-duration: 26s; animation-delay: 1s;">❖</span>
    <span class="floating-icon from-top icon-xl"
        style="left: 22%; animation-duration: 32s; animation-delay: 4s;">✿</span>
    <span class="floating-icon from-top icon-md"
        style="left: 32%; animation-duration: 20s; animation-delay: 6s;">❋</span>
    <span class="floating-icon from-top icon-lg"
        style="left: 52%; animation-duration: 28s; animation-delay: 2s;">✦</span>
    <span class="floating-icon from-top icon-xl"
        style="left: 62%; animation-duration: 30s; animation-delay: 7s;">❁</span>
    <span class="floating-icon from-top icon-md"
        style="left: 72%; animation-duration: 22s; animation-delay: 9s;">✥</span>
    <span class="floating-icon from-top icon-lg"
        style="left: 82%; animation-duration: 27s; animation-delay: 3s;">◈</span>

    {{-- SCRIPT BATALKAN --}}
    <script>
        let selectedPesananId = null;

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-cancel-pesanan').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
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
            if (form) form.submit();
            closeCancelModal();
        }

        document.addEventListener('click', function (e) {
            const modal = document.getElementById('cancelModal');
            if (e.target === modal) {
                closeCancelModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCancelModal();
            }
        });
    </script>

    {{-- SCRIPT DETAIL --}}
    <script>
        function openDetailModal(data) {
            document.getElementById('dm-layanan').innerText = data.layanan;
            document.getElementById('dm-tanggal').innerText = data.tanggal;
            document.getElementById('dm-alamat').innerText = data.alamat;
            document.getElementById('dm-harga').innerText = data.harga;
            document.getElementById('dm-created').innerText = data.created;
            document.getElementById('dm-updated').innerText = data.updated;

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

        document.addEventListener('click', function (e) {
            const modal = document.getElementById('detailModal');
            if (e.target === modal) {
                closeDetailModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDetailModal();
            }
        });
    </script>

</body>

</html>