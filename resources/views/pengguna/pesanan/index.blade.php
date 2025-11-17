<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - AdatKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Great+Vibes&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff9f7;
        }

        .logo-font {
            font-family: 'Great Vibes', cursive;
        }
    </style>
</head>

<body class="text-gray-800">

    {{-- HEADER --}}
    <header class="bg-white shadow-md sticky top-0 z-40">
        <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-4">

            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('logosu.jpg') }}" alt="Logo" class="w-12 h-12 rounded-full shadow">
                <span
                    class="logo-font text-3xl bg-gradient-to-r from-amber-400 via-yellow-500 to-yellow-600 bg-clip-text text-transparent">
                    AdatKu
                </span>
            </a>

            <a href="/" class="text-sm text-amber-700 hover:text-amber-500">Kembali ke Beranda</a>
        </div>
    </header>
    <section class="max-w-6xl mx-auto mt-10 px-6">
        <h1 class="text-3xl font-bold text-rose-700 mb-2">Pesanan Saya</h1>
        <p class="text-gray-600">Lihat semua pesanan layanan yang pernah kamu buat.</p>
    </section>
    <section class="max-w-6xl mx-auto px-6 mt-8 mb-20">

        @if ($pesanans->isEmpty())
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

                        $waText = $mua ? urlencode(
                            "Halo Kak $namaMua, saya $namaUser ingin melanjutkan / konfirmasi pembayaran pesanan $namaLayanan untuk tanggal {$tanggal}."
                        ) : '';
                    @endphp
                    <div class="bg-white rounded-2xl border border-rose-100 shadow-md p-6 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">
                                Booking:
                                <span class="font-semibold">
                                    {{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y') }}
                                </span>
                            </p>

                            <h2 class="text-xl font-semibold text-rose-700">
                                {{ $namaLayanan }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Status Pembayaran:
                                <span class="font-semibold
                            @if ($item->status_pembayaran === 'Lunas') text-green-600
                            @elseif ($item->status_pembayaran === 'Belum_Lunas') text-red-600
                            @else text-gray-600 @endif">
                                    {{ str_replace('_', ' ', $item->status_pembayaran) }}
                                </span>
                            </p>
                        </div>
                        <div class="text-right space-y-3">
                            <div>
                                <p class="text-xs text-gray-400">Total</p>
                                <p class="text-2xl font-bold text-amber-600">
                                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                </p>
                            </div>
                            @if ($waNumber && $item->status_pembayaran !== 'Dibatalkan')
                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 rounded-full
                                      bg-[#e7f9f0] text-[#128C7E] text-xs font-semibold hover:bg-[#d3f3e3] transition">
                                    💬 Chat MUA via WhatsApp
                                </a>
                            @endif
                            @if ($item->status_pembayaran === 'Belum_Lunas')
                                <form method="POST" action="{{ route('pengguna.destroy', $item->id) }}"
                                    onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 rounded-full text-sm font-semibold
                                               bg-rose-100 text-rose-700 hover:bg-rose-200 transition">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            @elseif ($item->status_pembayaran === 'Dibatalkan')
                                <span class="inline-block px-4 py-2 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                    Pesanan dibatalkan
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>

        @endif

    </section>


    {{-- FOOTER --}}
    <footer class="bg-[#3d2630] text-wheat text-center py-6">
        <p class="text-lg">&copy; 2025 AdatKu — Semua Hak Dilindungi.</p>
    </footer>

</body>

</html>