<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail MUA - AdatKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fff9f7] text-slate-800 min-h-screen">

    <div class="max-w-5xl mx-auto px-4 py-8 space-y-8">

        {{-- KEMBALI KE DAFTAR MUA --}}
        <a href="{{ url('/daftarmua') }}"
            class="text-sm text-rose-600 hover:text-rose-700 hover:underline font-medium inline-flex items-center">
            ← Kembali ke Daftar MUA
        </a>

        {{-- BAGIAN ATAS: FOTO + INFO MUA --}}
        <section class="bg-white/90 border border-amber-100 rounded-2xl shadow-sm p-6 md:p-8">
            <div class="flex flex-col md:flex-row gap-6">

                {{-- FOTO --}}
                <div class="md:w-1/3 flex flex-col items-center gap-3">
                    <div class="w-40 h-40 rounded-3xl overflow-hidden shadow-md">
                        <img src="{{ asset('storage/' . $mua->foto) }}" alt="Foto MUA"
                            class="w-full h-full object-cover">
                    </div>

                    {{-- SOSMED --}}
                    <div class="flex flex-wrap justify-center gap-2 text-xs mt-2">
                        @if (!empty($mua->instagram))
                            <a href="https://instagram.com/{{ $mua->instagram }}" target="_blank"
                                class="px-3 py-1 rounded-full bg-rose-50 text-rose-700 font-medium hover:bg-rose-100 transition">
                                Instagram: {{ $mua->instagram }}
                            </a>
                        @endif

                        @if (!empty($mua->tiktok))
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-medium">
                                TikTok: {{ $mua->tiktok }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- INFO MUA --}}
                <div class="flex-1 space-y-2">
                    <h1 class="text-2xl md:text-3xl font-bold text-rose-700">
                        {{ $mua->nama_usaha }}
                    </h1>

                    <p class="flex items-start gap-2 text-sm text-slate-700">
                        <span>📍</span>
                        <span>{{ $mua->alamat }}</span>
                    </p>

                    <p class="flex items-start gap-2 text-sm text-slate-700">
                        <span>📞</span>
                        <a href="https://wa.me/{{ $mua->kontak_wa }}" target="_blank"
                            class="text-rose-600 hover:underline">
                            {{ $mua->kontak_wa }} (Chat via WhatsApp)
                        </a>
                    </p>

                    <p class="text-sm text-slate-700 mt-2">
                        {{ $mua->deskripsi }}
                    </p>

                    <p class="text-xs font-semibold text-rose-500 uppercase tracking-wide mt-3">
                        MUA GEN Z WELL
                    </p>
                </div>
            </div>
        </section>

        {{-- LAYANAN TERSEDIA --}}
        <section class="space-y-4">
            <h2 class="text-xl md:text-2xl font-bold text-rose-700">
                Layanan Tersedia
            </h2>

            <div class="grid gap-4 md:grid-cols-3">
                @forelse ($mua->layanan as $item)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
                        <img src="{{ $item->foto ? asset('storage/' . $item->foto) : 'https://placehold.co/400x400?text=Layanan' }}"
                            alt="{{ $item->nama }}" class="w-full h-48 object-cover">

                        <div class="p-4">
                            <p class="text-xs uppercase tracking-wide text-amber-600 mb-1">
                                {{ $item->kategori ?? 'Layanan' }}
                            </p>

                            <h4 class="text-lg font-semibold text-gray-800">
                                {{ $item->nama }}
                            </h4>

                            @if ($item->deskripsi)
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ \Illuminate\Support\Str::limit($item->deskripsi, 100) }}
                                </p>
                            @endif

                            <p class="mt-3 font-bold text-rose-600">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </p>

                            <a href="{{ route('pengguna.pesanan.create', $item->id) }}"
                                class="inline-flex items-center px-4 py-2 rounded-xl bg-rose-600 text-white text-sm font-medium hover:bg-rose-700">
                                Pesan Layanan Ini
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-600 col-span-3">
                        Belum ada layanan yang ditambahkan.
                    </p>
                @endforelse
            </div>
        </section>

    </div>

</body>

</html>