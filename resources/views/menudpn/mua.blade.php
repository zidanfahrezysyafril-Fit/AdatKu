<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar MUA - AdatKu</title>

    {{-- FONTS & TAILWIND --}}
    <link rel="icon" type="image/png" href="{{ asset('logo_2.png?v=5') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo_2.png?v=5') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        [x-cloak] {
            display: none !important;
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
            font-family: 'Great Vibes', cursive;
        }

        /* === ICON MELAYANG === */
        .floating-icon {
            position: fixed;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.9);
            z-index: 20;
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

        /* animasi kartu kecil di banner */
        @keyframes soft-float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .soft-float {
            animation: soft-float 5s ease-in-out infinite;
        }
    </style>

</head>

<body class="bg-[rgba(255,242,213,0.08)] text-gray-900"
    x-data="{ navOpen:false, userMenuOpen:false, profileModal:false, editModal:false }" x-cloak>

    {{-- HEADER --}}
    <header class="sticky top-0 z-40">
        <div class="backdrop-blur-md bg-white/90 border-b border-amber-100/70 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between gap-3 sm:gap-4">

                {{-- LOGO --}}
                <a href="{{ url('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                        class="w-11 h-11 sm:w-12 sm:h-12 rounded-full object-cover shadow-md border border-amber-200">
                    <div class="leading-tight">
                        <h1
                            class="text-xl sm:text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent tracking-wide">
                            AdatKu
                        </h1>
                        <p class="text-[10px] sm:text-[11px] text-amber-800/80 hidden sm:block">
                            Sentuhan adat, pengalaman modern
                        </p>
                    </div>
                </a>

                {{-- NAV DESKTOP --}}
                <nav class="hidden md:flex items-center gap-6 text-[13px] sm:text-[14px] font-medium text-[#b48a00]">
                    <a href="{{ url('home') }}" class="hover:text-[#eab308]">Beranda</a>
                    <a href="#" class="text-[#eab308] font-semibold border-b-2 border-[#eab308] pb-0.5">
                        Daftar MUA
                    </a>
                    <a href="{{ url('hubungikami') }}" class="hover:text-[#eab308]">Hubungi Kami</a>
                </nav>

                {{-- AKSI KANAN --}}
                <div class="flex items-center gap-2 sm:gap-3">

                    {{-- HAMBURGER (MOBILE) --}}
                    <button @click="navOpen = true" class="md:hidden inline-flex items-center gap-2 px-3 py-2 rounded-full border border-amber-200/70 bg-white/80
                               shadow-sm hover:bg-amber-50 hover:border-amber-300 transition text-xs text-amber-800">
                        <span class="relative flex flex-col justify-between w-3.5 h-3">
                            <span class="block h-[2px] rounded-full bg-amber-500"></span>
                            <span class="block h-[2px] rounded-full bg-amber-400"></span>
                            <span class="block h-[2px] rounded-full bg-amber-500 w-2/3 self-end"></span>
                        </span>
                        <span class="hidden sm:inline">Menu</span>
                    </button>

                    @guest
                        <a href="{{ route('auth') }}"
                            class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                              text-white px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 rounded-full shadow-md hover:shadow-lg hover:brightness-105 transition text-xs sm:text-sm font-semibold">
                            Sign In
                        </a>
                    @endguest

                    @auth
                        @php
                            $user = auth()->user();
                            $avatar = $user->avatar
                                ? asset('storage/' . $user->avatar)
                                : asset('default-avatar.png');

                            $avatarUrl = ($user->avatar ?? null)
                                ? asset('storage/' . $user->avatar)
                                : 'https://placehold.co/300x300?text=Profile';
                        @endphp

                        @if ($user->role === 'Pengguna')
                            <a href="{{ route('pengguna.pesanan.index') }}"
                                class="hidden lg:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 hover:bg-amber-100 text-[#b48a00] font-semibold text-xs shadow-sm border border-amber-200">
                                📦 Pesanan Saya
                            </a>
                        @endif

                        {{-- dropdown user --}}
                        <div class="relative">
                            <button @click="userMenuOpen = !userMenuOpen"
                                class="w-9 h-9 sm:w-10 sm:h-10 rounded-full overflow-hidden border-2 border-[#f5d547] shadow focus:outline-none">
                                <img src="{{ $avatar }}" alt="Profile" class="w-full h-full object-cover"
                                    onerror="this.onerror=null;this.src='{{ asset('default-avatar.png') }}'">
                            </button>

                            <div x-show="userMenuOpen" x-cloak x-transition @click.outside="userMenuOpen=false"
                                class="absolute right-0 mt-3 w-56 sm:w-60 bg-white rounded-xl shadow-lg ring-1 ring-black/5 overflow-hidden z-50">
                                <div class="px-4 py-3 border-b">
                                    <p class="text-sm font-semibold text-gray-800 truncate">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                                </div>
                                <ul class="py-1 text-sm">
                                    <li>
                                        <button type="button" @click="profileModal = true; userMenuOpen=false"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-50">
                                            Profil Saya
                                        </button>
                                    </li>
                                    <li class="border-t">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                                Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- NAV DRAWER (MOBILE) --}}
    <div class="fixed inset-0 z-[9998] flex justify-end items-stretch transition-opacity duration-300"
        :class="navOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'"
        @keydown.escape.window="navOpen = false">

        {{-- overlay --}}
        <div class="flex-1 h-full bg-black/40 backdrop-blur-sm" @click="navOpen = false"></div>

        {{-- PANEL KANAN --}}
        <div class="relative h-full w-[78%] max-w-xs sm:max-w-sm bg-white
                    shadow-[0_0_40px_rgba(0,0,0,0.35)] border-l border-amber-100
                    flex flex-col transform transition-transform duration-300 ease-out"
            :class="navOpen ? 'translate-x-0' : 'translate-x-full'">

            {{-- HEADER DRAWER --}}
            <div
                class="px-4 py-3 bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-full bg-white/95 flex items-center justify-center shadow-md border border-amber-100">
                        <span class="logo-font text-xl text-[#c98a00]">A</span>
                    </div>
                    <div class="leading-tight text-white">
                        <p class="text-[11px] uppercase tracking-[0.2em] opacity-90">Navigasi</p>
                        <p class="text-sm font-semibold">AdatKu</p>
                    </div>
                </div>

                <button type="button" @click="navOpen = false"
                    class="w-8 h-8 rounded-full bg-white/95 flex items-center justify-center text-amber-700 shadow-sm hover:bg-amber-50">
                    ✕
                </button>
            </div>

            {{-- MENU LIST --}}
            <div class="flex-1 overflow-y-auto px-4 py-3 text-sm text-slate-800 space-y-1">
                <button @click="navOpen = false; window.location='{{ url('home') }}'"
                    class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
                    <span class="text-lg">🏠</span><span>Beranda</span>
                </button>

                <button @click="navOpen = false"
                    class="flex w-full items-center gap-2 py-2 rounded-lg bg-amber-50/80 text-amber-800 font-semibold">
                    <span class="text-lg">💄</span><span>Daftar MUA (Saat ini)</span>
                </button>

                <button @click="navOpen = false; window.location='{{ url('hubungikami') }}'"
                    class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
                    <span class="text-lg">✉️</span><span>Hubungi Kami</span>
                </button>

                @auth
                    @php $userNav = auth()->user(); @endphp

                    @if (strtolower($userNav->role ?? '') === 'pengguna')
                        <button @click="navOpen = false; window.location='{{ route('pengguna.pesanan.index') }}'"
                            class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
                            <span class="text-lg">📦</span><span>Pesanan Saya</span>
                        </button>
                    @endif

                    <button @click="navOpen = false; profileModal = true"
                        class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
                        <span class="text-lg">👤</span><span>Profil Saya</span>
                    </button>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-red-50 text-red-600 mt-2 border-t border-amber-50 pt-2">
                            <span class="text-lg">🚪</span><span>Logout</span>
                        </button>
                    </form>
                @else
                    <button @click="navOpen = false; window.location='{{ route('auth') }}'"
                        class="mt-2 flex w-full items-center gap-2 py-2 rounded-lg bg-amber-500 text-white justify-center font-semibold hover:bg-amber-600">
                        <span class="text-lg">🔐</span><span>Sign In</span>
                    </button>
                @endauth
            </div>
        </div>
    </div>

    {{-- HERO KECIL / BANNER --}}
    <section class="bg-gradient-to-r from-[#fff7e1] via-[#f4d890] to-[#f1c25a] border-b border-amber-100/70">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 flex flex-col md:flex-row items-center justify-between gap-5 sm:gap-6">
            <div class="w-full md:w-2/3">
                <p class="text-[11px] sm:text-xs font-semibold text-amber-800/80 uppercase tracking-wide mb-1">
                    Daftar MUA Terdaftar
                </p>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold text-[#5c2b33] mb-2">
                    Temukan MUA terbaik untuk acara adatmu
                </h1>
                <p class="text-xs sm:text-sm md:text-[15px] text-amber-900/80 max-w-xl">
                    Pilih dari berbagai penyedia jasa rias, busana adat, dan paket lengkap
                    yang sudah bergabung di <span class="font-semibold">AdatKu</span>.
                </p>
            </div>

            <div class="w-full md:w-auto soft-float">
                <div
                    class="bg-white/90 rounded-2xl shadow-lg border border-amber-100 px-4 sm:px-5 py-3 sm:py-4 flex items-center gap-3 sm:gap-4 max-w-sm mx-auto md:mx-0">
                    <div
                        class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-[#f7e07b] via-[#eab308] to-[#c98a00] flex items-center justify-center text-white text-lg sm:text-xl">
                        ✨
                    </div>
                    <div class="text-xs sm:text-sm">
                        <p class="text-[10px] sm:text-[11px] text-gray-500">MUA Terdaftar</p>
                        <p class="text-base sm:text-lg font-semibold text-amber-800">
                            {{ $muas->count() }} <span class="text-[11px] sm:text-[12px] font-normal">MUA aktif</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- KONTEN UTAMA --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-10 flex flex-col lg:flex-row gap-6 lg:gap-7">

        {{-- SIDEBAR --}}
        <aside class="lg:w-64 w-full">
            <div
                class="bg-white shadow-md rounded-2xl border border-yellow-200/70 px-4 sm:px-5 py-5 sm:py-6 sticky top-24 space-y-4">
                <div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800">Filter & Info</h2>
                    <p class="text-[11px] sm:text-xs text-gray-500 mt-1">
                        Gunakan pencarian dan kategori untuk menemukan MUA yang sesuai dengan kebutuhanmu.
                    </p>
                </div>

                <div class="space-y-2 text-[11px] sm:text-xs">
                    <p class="font-semibold text-gray-700 mb-1">Kategori cepat</p>
                    <div class="flex flex-wrap gap-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-[11px]">
                            🌟 Rias Pengantin
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-50 text-yellow-800 border border-yellow-200 text-[11px]">
                            🎓 Wisuda
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-800 border border-rose-200 text-[11px]">
                            💍 Lamaran / Akad
                        </span>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-3 sm:pt-4 text-[11px] sm:text-xs text-gray-500 leading-relaxed">
                    Tips: kamu bisa mencari berdasarkan
                    <span class="font-semibold">nama usaha</span> atau
                    <span class="font-semibold">alamat</span> (contoh: “Duri”, “Siak Kecil”, “Bengkalis”).
                </div>
            </div>
        </aside>

        {{-- DAFTAR MUA --}}
        <section
            class="flex-1 bg-white rounded-2xl shadow-md border border-gray-200 px-4 sm:px-6 py-5 sm:py-6 min-h-[300px]">

            {{-- HEADER LIST + SEARCH --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 sm:gap-4 mb-5 sm:mb-6">
                <div class="w-full md:w-auto">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Pilih MUA Terdaftar</h2>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Ditemukan
                        <span class="font-semibold text-[#c98a00]">
                            {{ $muas->count() }}
                        </span>
                        MUA yang siap membantu acara adatmu.
                    </p>
                </div>

                <form method="GET" action="{{ url()->current() }}" class="w-full md:w-1/2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari MUA berdasarkan nama usaha atau alamat..." class="w-full rounded-full border border-gray-300 bg-white/80 px-4 pr-24 py-2.5 text-xs sm:text-sm
                                      outline-none focus:ring-2 focus:ring-[#f5d547] focus:border-[#eab308]">
                        <button type="submit" class="absolute right-1 top-1 bottom-1 px-3 sm:px-4 rounded-full text-[11px] sm:text-xs font-semibold
                                       bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                       text-white shadow hover:brightness-105">
                            Cari
                        </button>
                    </div>
                    <p class="text-[10px] sm:text-[11px] text-gray-400 mt-1">
                        Contoh: “Fetty”, “Pakning” dll.
                    </p>
                </form>
            </div>

            {{-- LIST / EMPTY STATE --}}
            @if ($muas->isEmpty())
                <div
                    class="border border-dashed border-gray-300 rounded-2xl py-8 sm:py-10 px-4 text-center text-gray-500 text-xs sm:text-sm">
                    Belum ada MUA yang mendaftar di AdatKu.<br>
                    Silakan kembali lagi nanti ya ✨
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach ($muas as $mua)
                        <a href="{{ route('public.mua.show', $mua->id) }}"
                            class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden
                                                          hover:shadow-xl hover:-translate-y-1 transition-transform duration-200 flex flex-col">

                            {{-- FOTO --}}
                            <div class="relative">
                                <img src="{{ $mua->foto ? asset('storage/' . $mua->foto) : 'https://placehold.co/400x400?text=MUA' }}"
                                    alt="{{ $mua->nama_usaha }}" class="w-full h-48 sm:h-56 object-cover">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/15 to-transparent opacity-0 group-hover:opacity-100 transition">
                                </div>
                                <div class="absolute bottom-3 left-3 flex items-center gap-2 text-[10px] sm:text-[11px]">
                                    <span class="px-3 py-1 rounded-full bg-black/60 text-white backdrop-blur-sm">
                                        MUA Terdaftar
                                    </span>
                                </div>
                            </div>

                            {{-- ISI CARD --}}
                            <div class="p-3 sm:p-4 flex flex-col flex-1">
                                <h3
                                    class="text-sm sm:text-base md:text-lg font-semibold text-gray-800 mb-1 truncate group-hover:text-[#c98a00]">
                                    {{ $mua->nama_usaha }}
                                </h3>

                                @if ($mua->deskripsi)
                                    <p class="text-[11px] sm:text-xs text-gray-500 mb-2">
                                        {{ \Illuminate\Support\Str::limit($mua->deskripsi, 70) }}
                                    </p>
                                @endif

                                @if ($mua->alamat)
                                    <p class="text-[11px] sm:text-xs text-gray-400 flex items-center gap-1 mb-3">
                                        <span>📍</span>
                                        <span class="truncate">{{ $mua->alamat }}</span>
                                    </p>
                                @endif

                                <div class="mt-auto flex items-center justify-between gap-2">
                                    <div class="flex flex-wrap gap-1">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] sm:text-[10px]
                                                                           bg-yellow-50 text-[#c98a00] border border-yellow-200">
                                            Makeup & Hairdo
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] sm:text-[10px]
                                                                           bg-amber-50 text-amber-700 border border-amber-200">
                                            Baju Adat
                                        </span>
                                    </div>
                                    <span
                                        class="text-[10px] sm:text-[11px] font-semibold text-[#c98a00] group-hover:underline whitespace-nowrap">
                                        Lihat detail →
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    {{-- ============ MODAL PROFIL & EDIT ============ --}}
    @auth
        {{-- modal Profil Saya --}}
        <div x-show="profileModal" x-cloak x-transition.opacity
            class="fixed inset-0 z-[9998] flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
            <div @click.outside="profileModal=false"
                class="bg-white rounded-3xl shadow-xl border border-yellow-200/70 w-full max-w-xl p-6 sm:p-7 relative">

                <button type="button" @click="profileModal=false"
                    class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500">
                    ✕
                </button>

                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#c98a00] mb-4 sm:mb-5">
                    Profil Saya
                </h1>

                <div class="relative flex flex-col sm:flex-row items-center gap-5 sm:gap-6">
                    <span class="hidden sm:block absolute -left-4 -top-4 text-yellow-200 text-3xl">❖</span>
                    <span class="hidden sm:block absolute -right-4 bottom-0 text-yellow-200 text-3xl rotate-45">✦</span>

                    <div
                        class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-[3px] border-[#f5d547] shadow-lg">
                        <img src="{{ $avatarUrl }}" alt="Foto Profil" class="object-cover w-full h-full">
                    </div>

                    <div class="text-center sm:text-left">
                        <p class="text-slate-600 text-[11px] sm:text-xs">Nama</p>
                        <p class="text-lg sm:text-xl font-semibold">{{ $user->name }}</p>

                        <p class="text-slate-600 text-[11px] sm:text-xs mt-3">Email</p>
                        <p class="text-xs sm:text-sm font-medium break-all">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="flex justify-end mt-5 sm:mt-6 gap-2 sm:gap-3">
                    <button type="button" @click="profileModal=false"
                        class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-xs sm:text-sm hover:bg-slate-200 transition">
                        Tutup
                    </button>

                    <button type="button" @click="profileModal=false; editModal=true" class="px-4 sm:px-5 py-2 rounded-lg text-xs sm:text-sm text-white shadow-md
                                               bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                               hover:opacity-90 transition">
                        Edit Profil
                    </button>
                </div>
            </div>
        </div>

        {{-- modal Edit Profil --}}
        <div x-show="editModal" x-cloak x-transition.opacity
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/45 backdrop-blur-sm px-4">
            <div @click.outside="editModal=false" class="bg-white rounded-[32px] shadow-2xl border border-yellow-200/70
                                    w-full max-w-3xl p-6 sm:p-8 md:p-10 relative">

                <button type="button" @click="editModal=false" class="absolute top-4 sm:top-5 right-4 sm:right-5 w-8 sm:w-9 h-8 sm:h-9 rounded-full bg-slate-100
                                           hover:bg-slate-200 flex items-center justify-center text-slate-500">
                    ✕
                </button>

                <span class="absolute -left-3 top-10 text-yellow-100 text-3xl sm:text-4xl">❋</span>
                <span class="absolute right-6 sm:right-8 -bottom-3 text-yellow-100 text-3xl sm:text-4xl rotate-45">✦</span>

                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#c98a00] mb-5 sm:mb-7">
                    Edit Profil
                </h2>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5 sm:space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col sm:flex-row items-center gap-5 sm:gap-6 md:gap-8">
                        <div class="relative flex items-center justify-center
                                               w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32
                                               rounded-full p-[3px]
                                               bg-gradient-to-br from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                               shadow-xl">
                            <div class="w-full h-full rounded-full overflow-hidden bg-slate-100">
                                <img src="{{ $avatarUrl }}" alt="Foto Profil" class="w-full h-full object-cover">
                            </div>
                            <span class="absolute -bottom-3 -right-1 text-yellow-100 text-xl sm:text-2xl">❁</span>
                        </div>

                        <div class="w-full">
                            <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">
                                Ganti Foto
                            </label>
                            <input type="file" name="profile" class="block w-full text-xs sm:text-sm text-slate-600
                                                      file:mr-3 file:rounded-lg file:px-4 file:py-2
                                                      file:border file:border-yellow-200 file:bg-white
                                                      file:text-slate-700 file:cursor-pointer
                                                      hover:file:bg-yellow-50">
                            <p class="text-[11px] sm:text-xs text-slate-500 mt-1">
                                jpg/jpeg/png, maks 2MB
                            </p>
                        </div>
                    </div>

                    <div class="pt-1">
                        <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">
                            Nama
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-slate-200 px-3 sm:px-4 py-2.5 sm:py-3
                                                  text-sm md:text-base
                                                  focus:outline-none focus:ring-2 focus:ring-[#f5d547]
                                                  focus:border-[#c98a00]">
                    </div>

                    <div class="flex justify-end gap-2 sm:gap-3 pt-3 sm:pt-4">
                        <button type="button" @click="editModal=false" class="px-4 sm:px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs sm:text-sm md:text-base
                                                   hover:bg-slate-200 transition">
                            Batal
                        </button>

                        <button type="submit" class="px-5 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm md:text-base text-white font-semibold shadow-md
                                                   bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                                   hover:opacity-90 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endauth

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

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>