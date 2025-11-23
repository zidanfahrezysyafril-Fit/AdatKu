<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail MUA - {{ $mua->nama_studio ?? 'AdatKu MUA' }}</title>

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
            font-family: 'Great Vibes', cursive;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(190, 143, 43, 0.25);
        }

        .badge-glow {
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.35);
            animation: pulse 2s infinite;
        }

        /* ================= ICON MELAYANG ================= */
        .floating-icon {
            position: fixed;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.9);
            z-index: 30;
            pointer-events: none;
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

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.85;
            }
        }

        .image-overlay {
            position: relative;
            overflow: hidden;
        }

        .image-overlay::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.35) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-overlay:hover::after {
            opacity: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f7e07b 0%, #eab308 45%, #c98a00 100%);
            transition: all 0.25s ease;
        }

        .btn-primary:hover {
            filter: brightness(1.12);
            transform: translateY(-1px);
            box-shadow: 0 10px 28px rgba(201, 138, 0, 0.35);
        }

        .social-icon {
            transition: all 0.25s ease;
        }

        .social-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.25);
        }

        /* Modal Styles (umum: dipakai pesanan & keranjang) */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px);
            z-index: 9999;
            animation: fadeIn 0.28s ease;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-content {
            background: white;
            border-radius: 1.5rem;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(12px) scale(0.96);
            opacity: 0;
            transition: all 0.24s ease;
            box-shadow: 0 22px 60px rgba(15, 23, 42, 0.35);
        }

        .modal.active .modal-content {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .input-field {
            transition: all 0.22s;
        }

        .input-field:focus {
            border-color: #eab308;
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.18);
            outline: none;
        }

        /* Scrollbar styling */
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: #eab308;
            border-radius: 10px;
        }

        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #c98a00;
        }
    </style>
</head>

<body class="text-slate-800 min-h-screen flex flex-col">

    @php
        // Default aman kalau controller belum kirim variabel
        $cartItems = $cartItems ?? collect();
        $cartTotal = $cartTotal ?? $cartItems->sum(function ($item) {
            return (optional($item->layanan)->harga ?? 0) * $item->jumlah;
        });
        $cartCount = $cartCount ?? $cartItems->sum('jumlah');
    @endphp

    {{-- ================= HEADER ================= --}}
    <header class="sticky top-0 z-50 bg-white/95 border-b border-rose-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
            {{-- KIRI: LOGO + NAMA --}}
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                        class="w-14 h-14 rounded-full object-cover shadow-md">
                    <h1
                        class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
                        AdatKu
                    </h1>
                </a>
            </div>

            {{-- KANAN: MENU + KERANJANG --}}
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

                {{-- 🛒 KERANJANG (POPUP) --}}
                <button type="button" onclick="openCartModal()"
                    class="relative flex items-center gap-2 px-3 py-1.5 rounded-full border border-amber-200 bg-amber-50/70 text-[#b48a00] hover:bg-amber-100 hover:border-amber-300 transition">
                    <span class="text-lg">🛒</span>
                    <span class="text-sm font-semibold">Keranjang</span>
                    <span
                        class="inline-flex items-center justify-center min-w-[22px] h-[22px] rounded-full bg-rose-500 text-white text-[11px] font-bold">
                        {{ $cartCount }}
                    </span>
                </button>
            </nav>
        </div>
    </header>

    {{-- ================= KONTEN DETAIL MUA ================= --}}
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 py-8 space-y-10">
            {{-- ALERT SUCCESS --}}
            @if (session('success'))
                <div class="max-w-xl mx-auto mb-4">
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-sm">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if ($errors->any())
                <div class="max-w-xl mx-auto mb-4">
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl text-sm">
                        <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- PROFILE SECTION --}}
            <section class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-rose-100">
                <div class="flex flex-col lg:flex-row">
                    {{-- LEFT: FOTO + SOSMED --}}
                    <div
                        class="lg:w-2/5 bg-gradient-to-br from-[#3b2128] via-[#4a2e38] to-[#351b27] p-8 lg:p-12 flex flex-col items-center justify-center">
                        @php
                            $fotoMua = $mua->foto
                                ? asset('storage/' . $mua->foto)
                                : 'https://placehold.co/400x400/FFF1F2/E11D48?text=' . urlencode($mua->nama_studio ?? 'MUA');
                        @endphp

                        <div class="relative">
                            <div
                                class="w-56 h-56 rounded-full overflow-hidden shadow-2xl ring-4 ring-[#f5d547] relative z-10">
                                <img src="{{ $fotoMua }}" alt="Foto MUA" class="w-full h-full object-cover">
                            </div>

                            <div
                                class="absolute -top-4 -right-4 w-24 h-24 bg-amber-200 rounded-full opacity-60 blur-2xl">
                            </div>
                            <div
                                class="absolute -bottom-4 -left-4 w-32 h-32 bg-rose-200 rounded-full opacity-60 blur-2xl">
                            </div>
                        </div>

                        <div
                            class="mt-6 px-6 py-2 rounded-full bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white text-xs font-bold uppercase tracking-wider badge-glow">
                            ✨ {{ $mua->tagline ?? 'MUA Professional' }}
                        </div>

                        {{-- Social Media --}}
                        <div class="mt-8 flex flex-col gap-3 w-full max-w-xs">
                            @if (!empty($mua->instagram))
                                <a href="https://instagram.com/{{ ltrim($mua->instagram, '@') }}" target="_blank"
                                    class="social-icon flex items-center gap-3 px-5 py-3 rounded-2xl bg-white text-slate-800 font-medium border border-rose-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm0 2h10c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3zm5 3a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm5.25-3a1.25 1.25 0 100 2.5 1.25 1.25 0 000-2.5z" />
                                    </svg>
                                    <span>{{ '@' . ltrim($mua->instagram, '@') }}</span>
                                </a>
                            @endif

                            @if (!empty($mua->tiktok))
                                <a href="https://www.tiktok.com/@{{ ltrim($mua->tiktok, '@') }}" target="_blank"
                                    class="social-icon flex items-center gap-3 px-5 py-3 rounded-2xl bg-slate-900 text-white font-medium">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                                    </svg>
                                    <span>{{ '@' . ltrim($mua->tiktok, '@') }}</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- RIGHT: INFO --}}
                    <div class="lg:w-3/5 p-8 lg:p-12 space-y-6">
                        <div>
                            <h1
                                class="text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-rose-700 to-rose-500 bg-clip-text text-transparent mb-3">
                                {{ $mua->nama ?? $mua->nama_usaha ?? $mua->nama_mua ?? 'Nama MUA' }}
                            </h1>

                            <p class="text-slate-500 text-sm uppercase tracking-wider font-semibold">
                                {{ $mua->tagline ?? $mua->deskripsi ?? 'MUA Profesional' }}
                            </p>
                        </div>

                        <div class="space-y-4 pt-4">
                            {{-- Lokasi --}}
                            <div
                                class="flex items-start gap-4 p-4 rounded-2xl bg-rose-50/60 hover:bg-rose-50 transition-colors">
                                <div
                                    class="flex-shrink-0 w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-rose-600 uppercase tracking-wide mb-1">Lokasi
                                    </p>
                                    <p class="text-slate-700 font-medium">
                                        {{ $mua->alamat ?? 'Alamat belum diisi' }}
                                    </p>
                                </div>
                            </div>

                            {{-- WhatsApp --}}
                            @if (!empty($mua->kontak_wa))
                                @php
                                    $waNumber = preg_replace('/[^0-9]/', '', $mua->kontak_wa);
                                    if (strpos($waNumber, '0') === 0) {
                                        $waNumber = '62' . substr($waNumber, 1);
                                    }
                                @endphp
                                <div
                                    class="flex items-start gap-4 p-4 rounded-2xl bg-emerald-50/60 hover:bg-emerald-50 transition-colors">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wide mb-1">
                                            WhatsApp
                                        </p>
                                        <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                                            class="font-medium text-slate-800 hover:text-emerald-700 transition-colors">
                                            {{ $mua->kontak_wa }} <span class="text-emerald-700">→ Chat Sekarang</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Deskripsi --}}
                        <div class="pt-4">
                            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-3">Tentang Kami</h3>
                            <p class="text-slate-600 leading-relaxed">
                                {{ $mua->deskripsi ?? 'Kami adalah tim makeup artist profesional siap membantu berbagai acara spesial Anda.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- SERVICES SECTION --}}
            <section class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-3xl lg:text-4xl font-bold text-rose-700 mb-2">
                            Layanan Tersedia
                        </h2>
                        <p class="text-slate-500">Pilih paket yang sesuai dengan kebutuhan Anda</p>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($layanan as $layanan)
                        <div class="card-hover bg-white rounded-3xl shadow-lg overflow-hidden border border-rose-100">
                            <div class="image-overlay relative h-64">
                                <img src="{{ $layanan->foto ? asset('storage/' . $layanan->foto) : 'https://placehold.co/600x600/FFF1F2/E11D48?text=' . urlencode($layanan->nama) }}"
                                    alt="{{ $layanan->nama }}" class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="px-3 py-1 rounded-full bg-[#f7e07b] text-[#8a6600] text-xs font-bold uppercase tracking-wide shadow-lg">
                                        {{ strtoupper($layanan->kategori ?? 'MAKEUP') }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 space-y-4">
                                <div>
                                    <h4 class="text-xl font-bold text-slate-800 mb-2">
                                        {{ $layanan->nama }}
                                    </h4>
                                    <p class="text-sm text-slate-600 leading-relaxed">
                                        {{ $layanan->deskripsi ?? 'Layanan makeup untuk berbagai acara spesial Anda.' }}
                                    </p>
                                </div>

                                <div class="flex items-baseline gap-2">
                                    <span class="text-xs text-slate-500 font-medium">Mulai dari</span>
                                    <span class="text-2xl font-extrabold text-rose-600">
                                        Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- FORM CEPAT: TAMBAH 1 ITEM KE KERANJANG --}}
                                <form id="cart-form-{{ $layanan->id }}" method="POST" action="{{ route('cart.add') }}"
                                    class="hidden">
                                    @csrf
                                    <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                </form>

                                <div class="flex gap-3">
                                    {{-- Tombol + Keranjang --}}
                                    <button type="button"
                                        onclick="document.getElementById('cart-form-{{ $layanan->id }}').submit()"
                                        class="flex-1 px-3 py-3 rounded-xl border border-amber-200 bg-white text-[#b48a00] text-sm font-semibold hover:bg-amber-50 hover:border-amber-300 transition flex items-center justify-center gap-2">
                                        <span class="text-lg">＋</span>
                                        <span>Keranjang</span>
                                    </button>

                                    {{-- Tombol Pesan Layanan Ini (popup jumlah) --}}
                                    <button type="button" onclick="openModal(
                                                        '{{ addslashes($layanan->nama) }}',
                                                        'Rp {{ number_format($layanan->harga, 0, ',', '.') }}',
                                                        '{{ $layanan->id }}'
                                                    )"
                                        class="flex-1 btn-primary py-3 rounded-xl text-white font-semibold shadow-lg flex items-center justify-center gap-2">
                                        Pesan Layanan Ini
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm">
                            Belum ada layanan yang terdaftar untuk MUA ini.
                        </p>
                    @endforelse
                </div>
            </section>

            {{-- CTA SECTION --}}
            <section
                class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] rounded-3xl p-8 lg:p-12 text-center text-white shadow-2xl">
                <h3 class="text-3xl font-bold mb-4">
                    Siap Mewujudkan Penampilan Impian Anda? ✨
                </h3>
                <p class="text-amber-50 mb-6 max-w-2xl mx-auto">
                    Hubungi kami sekarang untuk konsultasi gratis dan dapatkan penawaran terbaik untuk acara spesial
                    Anda.
                </p>

                @if (!empty($mua->whatsapp))
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="https://wa.me/{{ $waNumber ?? '' }}"
                            class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-white text-[#c98a00] font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Chat via WhatsApp
                        </a>
                    </div>
                @endif
            </section>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="mt-6">
        <div class="relative bg-gradient-to-br from-[#3b2128] via-[#4a2e38] to-[#351b27] text-[wheat] pt-10 pb-6 px-5">
            <div
                class="absolute inset-0 opacity-[0.09] bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]">
            </div>

            <div class="relative max-w-6xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 items-start">
                    {{-- Brand & intro --}}
                    <div>
                        <h1
                            class="logo-font text-4xl bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent drop-shadow-[0_2px_6px_rgba(0,0,0,0.4)]">
                            AdatKu
                        </h1>
                        <p class="text-sm mt-2 text-[#f5e9df] leading-relaxed">
                            Platform penyewaan MUA, busana adat, dan pelaminan untuk mempercantik acara istimewa kamu.
                            Budaya tetap hidup, tampilan tetap elegan ✨
                        </p>
                    </div>

                    {{-- Link cepat --}}
                    <div class="text-sm">
                        <h3 class="font-semibold text-[#f7e07b] mb-3">Navigasi</h3>
                        <ul class="space-y-1.5">
                            <li><a href="{{ route('home') }}" class="hover:text-[#f7e07b] transition">Beranda</a></li>
                            <li><a href="#tentang" class="hover:text-[#f7e07b] transition">Tentang AdatKu</a></li>
                            <li><a href="#galeri" class="hover:text-[#f7e07b] transition">Galeri</a></li>
                            <li><a href="#tim" class="hover:text-[#f7e07b] transition">Tim Pengembang</a></li>
                            <li><a href="{{ route('hubungikami') }}" class="hover:text-[#f7e07b] transition">Hubungi
                                    Kami</a></li>
                        </ul>
                    </div>

                    {{-- Kontak & kredit --}}
                    <div class="text-sm">
                        <h3 class="font-semibold text-[#f7e07b] mb-3">Kontak</h3>
                        <p class="text-[#f5e9df] text-[13px]">
                            Email: <a href="mailto:adatku11@gmail.com"
                                class="hover:text-[#f7e07b]">adatku11@gmail.com</a><br>
                            Instagram: <a href="https://www.instagram.com/_.adatku?igsh=Nm1mbWk2emx1cGZl"
                                target="_blank" class="hover:text-[#f7e07b]">@_.adatku</a>
                        </p>

                        <div class="mt-4 text-[11px] text-[#e2c9bf] leading-relaxed">
                            <p>Dikembangkan oleh:</p>
                            <p class="mt-1">
                                <span class="font-semibold">Zidan Fahrezy Syafril</span> (Koordinator & Fullstack)<br>
                                <span class="font-semibold">Cahyani Putri Sofari</span> (Frontend & Dokumentasi)<br>
                                <span class="font-semibold">Fetty Ratna Dewi</span> (Frontend & Dokumentasi)
                            </p>
                        </div>
                    </div>
                </div>

                <p class="mt-4 text-xs text-center text-[#e2c9bf] ">
                    Dikembangkan oleh
                    <span class="font-semibold">Zidan Fahrezy Syafril</span>,
                    <span class="font-semibold">Cahyani Putri Sofari</span>,
                    dan <span class="font-semibold">Fetty Ratna Dewi</span>.
                </p>
                <p class="mt-2 text-xs text-center text-[#f7e07b]">
                    &copy; 2025 <span class="font-semibold">AdatKu</span> — Semua Hak Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    {{-- MODAL POPUP PESAN LAYANAN (TAMBAH KE KERANJANG) --}}
    <div id="orderModal" class="modal" onclick="closeModalOnBackdrop(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            {{-- Modal Header --}}
            <div
                class="sticky top-0 bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] p-6 flex items-center justify-between z-10">
                <h2 class="text-2xl font-bold text-white">Buat Pesanan 🎉</h2>
                <button onclick="closeModal()" class="text-white hover:bg-white/20 p-2 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 space-y-6">
                {{-- Info Layanan --}}
                <div class="border rounded-2xl p-4 bg-amber-50/70 border-amber-100">
                    <p id="modalServiceName" class="text-lg font-bold text-[#b45309] capitalize">-</p>
                    <p class="text-sm text-slate-600 mt-1">Mulai dari</p>
                    <p id="modalServicePrice" class="text-2xl font-extrabold text-rose-600">-</p>
                </div>

                {{-- Form Pesanan -> tambah ke keranjang --}}
                <form id="orderForm" method="POST" action="{{ route('cart.add') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" id="layananId" name="layanan_id">

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-700">
                            Jumlah Layanan *
                        </label>
                        <input type="number" name="jumlah" min="1" value="1" required
                            class="input-field w-full border border-gray-300 rounded-xl px-4 py-3"
                            placeholder="Masukkan jumlah">
                        @error('jumlah')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <p class="text-[11px] text-slate-500">
                        Detail seperti tanggal booking & alamat akan kamu lengkapi saat checkout di halaman keranjang.
                    </p>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeModal()"
                            class="flex-1 px-6 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 btn-primary px-6 py-3 rounded-xl text-white font-semibold shadow-lg">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- ... semua kode di atas TIDAK aku ubah ... --}}

    {{-- MODAL KERANJANG --}}
    <div id="cartModal" class="modal" onclick="closeCartOnBackdrop(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div
                class="sticky top-0 bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] p-6 flex items-center justify-between z-10">
                <h2 class="text-2xl font-bold text-white">Keranjang Saya 🛒</h2>
                <button onclick="closeCartModal()"
                    class="text-white hover:bg-white/20 p-2 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                @guest
                    <p class="text-sm text-slate-600">
                        Silakan <a href="{{ route('login') }}" class="text-rose-600 font-semibold underline">login</a>
                        terlebih dahulu untuk melihat keranjang.
                    </p>
                @else
                    @if ($cartItems->isEmpty())
                        <p class="text-sm text-slate-600">
                            Keranjangmu masih kosong. Pilih layanan dulu lalu tekan tombol <span class="font-semibold">＋
                                Keranjang</span> ya ✨
                        </p>
                    @else
                        {{-- Daftar item di keranjang --}}
                        <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                            @foreach ($cartItems as $item)
                                @php
                                    $layanan = $item->layanan;
                                    if (!$layanan) {
                                        continue;
                                    }
                                    $subtotal = ($layanan->harga ?? 0) * $item->jumlah;
                                @endphp
                                <div class="flex gap-3 p-3 rounded-2xl border border-amber-100 bg-amber-50/40">
                                    @if ($layanan->foto)
                                        <img src="{{ asset('storage/' . $layanan->foto) }}" alt="{{ $layanan->nama }}"
                                            class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 text-xs font-semibold flex-shrink-0">
                                            {{ Str::limit($layanan->nama, 10) }}
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ $layanan->nama }}
                                        </p>
                                        <p class="text-[11px] text-slate-500 uppercase tracking-wide">
                                            {{ strtoupper($layanan->kategori ?? 'MAKEUP') }}
                                        </p>
                                        <p class="text-xs text-slate-600 mt-1">
                                            Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                            <span class="text-slate-400">× {{ $item->jumlah }}</span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-slate-500">Subtotal</p>
                                        <p class="text-sm font-bold text-rose-600">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total --}}
                        <div class="border-t border-amber-100 pt-3 mt-2 flex items-center justify-between">
                            <span class="text-sm font-semibold text-slate-700">
                                Total ({{ $cartCount }} item)
                            </span>
                            <span class="text-lg font-extrabold text-rose-700">
                                Rp {{ number_format($cartTotal, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- 🔸 FORM CHECKOUT: TANGGAL + ALAMAT --}}
                        <form method="POST" action="{{ route('cart.checkout') }}" class="mt-4 space-y-3">
                            @csrf

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">
                                    Tanggal Booking <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_booking"
                                    value="{{ old('tanggal_booking', now()->toDateString()) }}"
                                    class="w-full border border-amber-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400">
                                @error('tanggal_booking')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">
                                    Alamat Lengkap Acara <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat" rows="2"
                                    class="w-full border border-amber-200 rounded-xl px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400"
                                    placeholder="Tulis alamat lengkap lokasi acara kamu...">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full btn-primary py-3 rounded-xl text-white font-semibold shadow-lg">
                                Buat Pesanan
                            </button>
                        </form>

                        {{-- Siapkan teks WhatsApp untuk ringkasan pesanan --}}
                        @php
                            $waCheckoutText = null;

                            if (!empty($mua->kontak_wa ?? null)) {
                                $text = "Halo kak, saya mau booking layanan MUA di AdatKu:\n";

                                foreach ($cartItems as $item) {
                                    $layanan = $item->layanan;
                                    if (!$layanan) {
                                        continue;
                                    }

                                    $subtotal = ($layanan->harga ?? 0) * $item->jumlah;
                                    $text .= '- ' . $layanan->nama . ' x ' . $item->jumlah . ' (Rp '
                                        . number_format($subtotal, 0, ',', '.') . ")\n";
                                }

                                $text .= "\nPerkiraan total: Rp " . number_format($cartTotal, 0, ',', '.');
                                $text .= "\n\nNama:\nTanggal acara:\nAlamat lengkap:\nCatatan tambahan:";

                                $waCheckoutText = rawurlencode($text);
                            }
                        @endphp

                        {{-- Tombol Checkout via WhatsApp (opsional) --}}
                        @if (!empty($mua->kontak_wa ?? null) && $waCheckoutText)
                            <a href="https://wa.me/{{ $waNumber ?? '' }}?text={{ $waCheckoutText }}" target="_blank"
                                class="mt-3 block w-full bg-emerald-500 hover:bg-emerald-600 text-center py-3 rounded-xl text-white font-semibold shadow-lg">
                                Checkout via WhatsApp
                            </a>
                        @endif

                        <p class="mt-2 text-[11px] text-slate-500 text-center">
                            Setelah pesanan dibuat, kamu bisa lihat di menu <span class="font-semibold">Pesanan Saya</span>,
                            cek status (pending / disetujui / ditolak), dan lanjut chat via WhatsApp di sana.
                        </p>
                    @endif
                @endguest
            </div>
        </div>
    </div>

    {{-- ... sisanya (icon melayang + script) tetap sama ... --}}


    {{-- ICON MELAYANG (4 bawah + 4 atas) --}}
    <!-- Dari bawah -->
    <span class="floating-icon from-bottom icon-lg"
        style="left: 10%; animation-duration: 22s; animation-delay: 0s;">❖</span>
    <span class="floating-icon from-bottom icon-md"
        style="left: 32%; animation-duration: 24s; animation-delay: 3s;">✿</span>
    <span class="floating-icon from-bottom icon-xl"
        style="left: 58%; animation-duration: 28s; animation-delay: 6s;">❁</span>
    <span class="floating-icon from-bottom icon-lg"
        style="left: 80%; animation-duration: 25s; animation-delay: 4s;">✥</span>

    <!-- Dari atas -->
    <span class="floating-icon from-top icon-md"
        style="left: 15%; animation-duration: 23s; animation-delay: 2s;">✦</span>
    <span class="floating-icon from-top icon-lg"
        style="left: 42%; animation-duration: 27s; animation-delay: 5s;">❋</span>
    <span class="floating-icon from-top icon-xl"
        style="left: 68%; animation-duration: 30s; animation-delay: 8s;">◈</span>
    <span class="floating-icon from-top icon-md"
        style="left: 88%; animation-duration: 26s; animation-delay: 3s;">❂</span>

    <script>
        // Modal Pesan Layanan
        function openModal(serviceName, servicePrice, layananId) {
            document.getElementById('modalServiceName').textContent = serviceName;
            document.getElementById('modalServicePrice').textContent = servicePrice;
            document.getElementById('layananId').value = layananId;
            document.getElementById('orderModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('orderModal').classList.remove('active');
            document.body.style.overflow = 'auto';
            document.getElementById('orderForm').reset();
        }

        function closeModalOnBackdrop(event) {
            if (event.target.id === 'orderModal') {
                closeModal();
            }
        }

        // Modal Keranjang
        function openCartModal() {
            document.getElementById('cartModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeCartModal() {
            document.getElementById('cartModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function closeCartOnBackdrop(event) {
            if (event.target.id === 'cartModal') {
                closeCartModal();
            }
        }

        // Close kedua modal pakai ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal();
                closeCartModal();
            }
        });
    </script>

</body>

</html>