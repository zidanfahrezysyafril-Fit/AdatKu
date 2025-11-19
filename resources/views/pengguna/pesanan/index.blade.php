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

            {{-- KANAN: TOMBOL KEMBALI KE BERANDA --}}
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}"
                   class="text-sm md:text-base text-[#b48a00] hover:text-[#eab308] font-medium flex items-center gap-1 transition">
                    <span class="text-lg">←</span>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
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
                Lihat dan kelola semua pesanan layanan yang pernah kamu buat. Cek status pembayaran dan hubungi MUA jika
                diperlukan.
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

                        <article
                            class="bg-white/95 rounded-[26px] card-shadow border border-rose-50 px-5 md:px-7 py-5 md:py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                            {{-- KIRI --}}
                            <div class="space-y-2">
                                <p class="text-xs text-slate-500">
                                    Booking:
                                    <span class="font-semibold text-slate-900">
                                        {{ \Carbon\Carbon::parse($item->tanggal_booking)->translatedFormat('d M Y') }}
                                    </span>
                                </p>

                                <h2 class="text-lg md:text-xl font-semibold text-rose-700 capitalize">
                                    {{ $namaLayanan }}
                                </h2>

                                <p class="text-xs text-slate-500">
                                    Status Pembayaran:
                                    <span
                                        class="status-dot inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium border {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </p>

                                <a href="{{ route('pengguna.show', $item->id) }}"
                                   class="inline-flex items-center gap-1 mt-1.5 text-xs font-medium text-rose-500 hover:text-rose-600 hover:underline underline-offset-2">
                                    <span>detail pesanan</span>
                                    <span>↗</span>
                                </a>
                            </div>

                            {{-- KANAN --}}
                            <div class="text-right space-y-3 md:min-w-[230px]">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.24em] text-slate-400">Total</p>
                                    <p class="text-2xl md:text-3xl font-extrabold text-amber-600">
                                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="flex flex-col items-end gap-2">
                                    @if ($waNumber && $item->status_pembayaran !== 'Dibatalkan')
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                                                  bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-100 hover:bg-emerald-100 transition">
                                            <span>💬</span>
                                            <span>Chat MUA via WhatsApp</span>
                                        </a>
                                    @endif

                                    @if ($item->status_pembayaran === 'Belum_Lunas')
                                        <form method="POST" action="{{ route('pengguna.destroy', $item->id) }}"
                                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-4 py-2 rounded-full text-xs font-semibold
                                                           bg-rose-500 text-white hover:bg-rose-600 transition">
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
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#3d2630] text-[wheat] text-center py-6 mt-10">
        <p class="text-lg">&copy; 2025 AdatKu — Semua Hak Dilindungi.</p>
    </footer>

</body>
</html>
