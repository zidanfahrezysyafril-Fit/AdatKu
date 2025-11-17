<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fff9f7] text-slate-800 min-h-screen">

    <div class="max-w-3xl mx-auto py-10 px-4">
        <a href="{{ route('pengguna.pesanan.index') }}"
            class="inline-flex items-center text-rose-600 hover:underline mb-6">
            &larr; Kembali ke daftar pesanan
        </a>
        <div class="bg-white shadow-md rounded-2xl p-6 border border-rose-100">
            <h1 class="text-2xl font-bold text-rose-700 mb-4">
                Detail Pesanan
            </h1>

            <div class="space-y-3 text-sm">
                <div>
                    <span class="font-semibold text-slate-700">Layanan:</span>
                    <span class="ml-2">
                        {{ $pesanan->layanan->nama ?? '-' }}
                    </span>
                </div>

                <div>
                    <span class="font-semibold text-slate-700">Tanggal Booking:</span>
                    <span class="ml-2">
                        {{ \Carbon\Carbon::parse($pesanan->tanggal_booking)->translatedFormat('d F Y') }}
                    </span>
                </div>

                <div>
                    <span class="font-semibold text-slate-700">Alamat:</span>
                    <span class="ml-2">
                        {{ $pesanan->alamat }}
                    </span>
                </div>

                <div>
                    <span class="font-semibold text-slate-700">Total Harga:</span>
                    <span class="ml-2">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </span>
                </div>

                <div>
                    <span class="font-semibold text-slate-700">Status Pembayaran:</span>
                    <span class="ml-2">
                        @if ($pesanan->status_pembayaran === 'Belum_Lunas')
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                Belum Lunas
                            </span>
                        @elseif ($pesanan->status_pembayaran === 'Lunas')
                            <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">
                                Lunas
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-rose-100 text-rose-700">
                                Dibatalkan
                            </span>
                        @endif
                    </span>
                </div>

                <div class="pt-4 text-xs text-slate-500">
                    Dibuat pada: {{ $pesanan->created_at->format('d/m/Y H:i') }} <br>
                    Diperbarui: {{ $pesanan->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>

</body>

</html>