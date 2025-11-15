<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Profil {{ $mua->nama_usaha }} - AdatKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[rgba(255,242,213,0.08)] text-gray-900">

    <!-- NAVBAR SEDERHANA -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('public.mua.index') }}" class="text-amber-700 font-semibold">
                ← Kembali ke Daftar MUA
            </a>
            <h1 class="font-bold text-lg text-amber-800">AdatKu</h1>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-10 space-y-10">

        {{-- PROFIL MUA --}}
        <section class="bg-white rounded-2xl shadow-md p-6 flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-60">
                <img src="{{ $mua->foto ? asset('storage/' . $mua->foto) : 'https://placehold.co/400x400?text=MUA' }}"
                    alt="{{ $mua->nama_usaha }}" class="w-full h-60 object-cover rounded-2xl shadow">
            </div>

            <div class="flex-1">
                <h2 class="text-3xl font-bold text-rose-700">{{ $mua->nama_usaha }}</h2>

                @if ($mua->alamat)
                    <p class="mt-2 text-gray-600">📍 {{ $mua->alamat }}</p>
                @endif

                @if ($mua->kontak_wa)
                    <p class="mt-1 text-gray-600">
                        📱 <a href="https://wa.me/{{ preg_replace('/\D/', '', $mua->kontak_wa) }}" target="_blank"
                            class="text-emerald-600 hover:underline">
                            {{ $mua->kontak_wa }} (Chat via WhatsApp)
                        </a>
                    </p>
                @endif

                @if ($mua->deskripsi)
                    <p class="mt-4 text-gray-700 leading-relaxed">
                        {{ $mua->deskripsi }}
                    </p>
                @endif

                <div class="mt-4 flex flex-wrap gap-3 text-sm">
                    @if ($mua->instagram)
                        <a href="https://instagram.com/{{ ltrim($mua->instagram, '@') }}" target="_blank"
                            class="px-3 py-1 rounded-full bg-pink-50 text-pink-700 border border-pink-200">
                            Instagram: {{ $mua->instagram }}
                        </a>
                    @endif
                    @if ($mua->tiktok)
                        <a href="https://www.tiktok.com/@{{ ltrim($mua->tiktok, '@') }}" target="_blank"
                            class="px-3 py-1 rounded-full bg-slate-50 text-slate-700 border border-slate-200">
                            TikTok: {{ $mua->tiktok }}
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <section>
            <h3 class="text-2xl font-bold text-rose-700 mb-4">Layanan Tersedia</h3>

            @if ($mua->layanan->isEmpty())
                <p class="text-gray-500">Belum ada layanan yang ditambahkan oleh MUA ini.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($mua->layanan as $item)
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
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>

</body>

</html>