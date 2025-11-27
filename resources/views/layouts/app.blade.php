<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MUA Panel')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slideIn {
            animation: slideIn 0.4s ease-out;
        }

        /* 🎨 WARNA BRAND ADATKU */
        .adat-title {
            color: #b21f39;
        }

        .adat-gold {
            color: #c98a00;
        }

        .adat-text {
            color: #6d5f5b;
        }

        .adat-jade {
            color: #009f61;
        }

        /* ✨ Paksa background AdatKu di body, override bg-slate-50 Tailwind */
        body.bg-slate-50 {
            background-color: #fff9f7 !important;
            background-image:
                radial-gradient(circle at top left, rgba(249, 213, 213, 0.55) 0%, transparent 50%),
                radial-gradient(circle at bottom right, rgba(244, 219, 178, 0.55) 0%, transparent 55%);
            background-attachment: fixed;
        }

        /* ✨ BACKGROUND CANTIK ADATKU */
        body {
            background-color: #fff9f7;
            background-image:
                radial-gradient(circle at top left, rgba(249, 213, 213, 0.55) 0%, transparent 50%),
                radial-gradient(circle at bottom right, rgba(244, 219, 178, 0.55) 0%, transparent 55%);
            background-attachment: fixed;
        }

        /* === CARD STATISTIK STYLE ADATKU === */
        .stat-card {
            position: relative;
            border-radius: 1.25rem;
            padding: 1rem 1.25rem;
            border: 1px solid #f7e7c3;
            box-shadow: 0 4px 10px rgba(200, 150, 120, 0.1);
            transition: .2s ease;
            background-color: #ffffff;
        }

        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 12px;
            height: 100%;
            border-radius: 1.25rem 0 0 1.25rem;
            background: linear-gradient(180deg, #f9d67f, #e2b650);
            opacity: .85;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(200, 150, 120, 0.22);
        }
    </style>
</head>

<body class="text-slate-800 min-h-screen overflow-x-hidden bg-slate-50 transition-all duration-300"
    x-data="{ open: false }">

    <!-- HEADER -->
    <header class="fixed top-0 inset-x-0 z-40 bg-white/95 backdrop-blur shadow-sm border-b border-rose-100">
        <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

            {{-- Kiri: logo + judul --}}
            <div class="flex items-center gap-3">
                <!-- Burger (mobile) -->
                <button @click="open = !open"
                    class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 hover:bg-slate-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Logo + title -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                        class="w-12 h-12 rounded-full object-cover shadow-md border border-amber-200">
                </a>

                <div class="leading-tight hidden sm:block">
                    <p class="text-[11px] uppercase tracking-[0.16em] adat-gold font-semibold">
                        MUA Panel
                    </p>
                    <h1 class="text-base sm:text-lg font-semibold adat-title">
                        Dashboard
                    </h1>
                </div>
            </div>

            {{-- Kanan: tombol beranda saja (profil & logout dipindah ke sidebar) --}}
            @auth
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold
                               bg-amber-50 text-amber-800 border border-amber-200 shadow-sm
                               hover:bg-amber-100 hover:border-amber-300 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3 3 11h2v9h6v-6h2v6h6v-9h2z" />
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            @endauth

        </div>
    </header>

    <!-- ALERT -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition.opacity
            class="fixed top-20 right-5 z-50 bg-green-50 border border-green-300 text-green-700 px-5 py-3 rounded-xl shadow-lg">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- OVERLAY MOBILE (saat sidebar kebuka) --}}
    <div x-cloak x-show="open" x-transition.opacity class="fixed inset-0 bg-black/40 z-30 lg:hidden"
        @click="open = false">
    </div>

    {{-- ========= SIDEBAR MOBILE (SLIDE ANIM) ========= --}}
    <aside x-cloak x-show="open" x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-16 left-0 z-40 w-72 h-[calc(100vh-4rem)] bg-[#1e1723] text-white border-r border-white/10 lg:hidden">

        <div class="flex flex-col h-full">
            <!-- Brand / title -->
            <div class="px-6 py-4 border-b border-white/10">
                <h2 class="text-sm font-semibold tracking-[0.16em] uppercase text-white/70">
                    Menu Utama
                </h2>
            </div>

            <nav class="flex-1 px-3 py-4 text-sm space-y-1 overflow-y-auto">
                @php
                    $role = strtolower(auth()->user()->role ?? '');
                    $isMuaActive = request()->routeIs('mua.*') ||
                        request()->routeIs('profilemua.*') ||
                        request()->routeIs('panelmua.layanan.*');
                @endphp

                {{-- DASHBOARD --}}
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                        bg-white/5 border-l-4 border-[#e0ac33]/30
                        hover:bg-[#f2d2841a] hover:border-[#e0ac33] hover:shadow-sm transition
                        {{ request()->routeIs('dashboard') ? 'bg-[#f2d2841a] border-[#e0ac33]' : '' }}">
                    <svg class="w-4 h-4 opacity-80 group-hover:opacity-100" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3l9 8h-3v10H6V11H3l9-8z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- GROUP: MUA --}}
                @if ($role === 'mua')
                    <div x-data="{ openMua: {{ $isMuaActive ? 'true' : 'false' }} }" class="pt-2 space-y-1">
                        <button @click="openMua = !openMua" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl
                                                bg-white/5 border-l-4 border-[#e0ac33]/30
                                                hover:bg-[#f2d2841a] hover:border-[#e0ac33] hover:shadow-sm transition
                                                {{ $isMuaActive ? 'bg-[#f2d2841a] border-[#e0ac33]' : '' }}">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 opacity-80" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 0116 0H4z" />
                                </svg>
                                <span>MUA</span>
                            </span>
                            <svg :class="openMua ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="openMua" x-collapse class="ml-2 pl-4 my-1 border-l border-white/15 space-y-1">
                            <a href="{{ route('mua.panel') }}"
                                class="block px-3 py-2 rounded-lg hover:bg-white/10
                                                {{ request()->routeIs('mua.panel') ? 'bg-white/10 ring-1 ring-white/15' : '' }}">
                                Profil MUA
                            </a>

                            <a href="{{ route('panelmua.layanan.index') }}"
                                class="block px-3 py-2 rounded-lg hover:bg-white/10
                                                {{ request()->routeIs('panelmua.layanan.*') ? 'bg-white/10 ring-1 ring-white/15' : '' }}">
                                Layanan
                            </a>
                        </div>
                    </div>
                @endif

                {{-- TRANSAKSI --}}
                <div class="pt-2 space-y-1">
                    <p class="px-3 text-[11px] uppercase tracking-[0.18em] text-white/40">
                        Transaksi
                    </p>

                    {{-- PESANAN --}}
                    <a href="{{ route('panelmua.pesanan.index') }}"
                        class="group mt-1 flex items-center gap-3 px-3 py-2.5 rounded-xl
                            bg-white/5 border-l-4 border-[#e0ac33]/30
                            hover:bg-[#f2d2841a] hover:border-[#e0ac33] hover:shadow-sm transition
                            {{ request()->routeIs('panelmua.pesanan.index') ? 'bg-[#f2d2841a] border-[#e0ac33]' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-white/80 group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 14h2.5" />
                        </svg>
                        <span>Pesanan</span>
                    </a>

                    {{-- PEMBAYARAN --}}
                    <a href="{{ route('panelmua.pembayaran.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                            bg-white/5 border-l-4 border-[#e0ac33]/30
                            hover:bg-[#f2d2841a] hover:border-[#e0ac33] hover:shadow-sm transition
                            {{ request()->routeIs('panelmua.pembayaran.index') ? 'bg-[#f2d2841a] border-[#e0ac33]' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-white/80 group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 14h2.5" />
                        </svg>
                        <span>Pembayaran</span>
                    </a>
                </div>

                {{-- AKUN: BERANDA + LOGOUT --}}
                <div class="pt-3 mt-2 border-t border-white/10 space-y-1">
                    <p class="px-3 text-[11px] uppercase tracking-[0.18em] text-white/40">
                        Akun
                    </p>

                    {{-- Kembali ke beranda --}}
                    <a href="{{ route('home') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                               bg-white/5 border-l-4 border-[#e0ac33]/30
                               hover:bg-[#f2d2841a] hover:border-[#e0ac33] hover:shadow-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white/80 group-hover:text-white"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M10 19a1 1 0 0 0 1-1v-4h8v-4h-8V6a1 1 0 0 0-1.64-.77l-7 6a1 1 0 0 0 0 1.54l7 6A1 1 0 0 0 10 19Z" />
                        </svg>
                        <span>Beranda</span>
                    </a>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl
                                   bg-white/5 border-l-4 border-[#e3342f]/40
                                   hover:bg-[#f8717180] hover:border-[#fca5a5] hover:shadow-sm transition text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-200 group-hover:text-white"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M10 4a1 1 0 0 1 1 1v3h5a1 1 0 0 1 .8 1.6L14.5 12l2.3 2.4A1 1 0 0 1 16 16h-5v3a1 1 0 0 1-2 0V5a1 1 0 0 1 1-1Z" />
                            </svg>
                            <span class="text-red-100 group-hover:text-white font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- FOOTER SIDEBAR -->
            <div
                class="mt-auto px-4 py-3 border-t border-white/10 text-[11px] text-white/60 flex items-center justify-between">
                <span>29°C — Cerah Berawan</span>
                <span class="text-white/40">AdatKu</span>
            </div>
        </div>
    </aside>

    {{-- ========= SIDEBAR DESKTOP (SELALU TERBUKA) ========= --}}
    <aside
        class="hidden lg:flex lg:flex-col lg:fixed lg:z-30 lg:top-16 lg:left-0 lg:w-72 lg:h-[calc(100vh-4rem)] bg-[#1e1723] text-white border-r border-white/10">

        <div class="flex flex-col h-full">
            <!-- Brand / title -->
            <div class="px-6 py-4 border-b border-white/10">
                <h2 class="text-sm font-semibold tracking-[0.16em] uppercase text-white/70">
                    Menu Utama
                </h2>
            </div>

            <nav class="flex-1 px-3 py-4 text-sm space-y-1 overflow-y-auto">
                @php
                    $role = strtolower(auth()->user()->role ?? '');
                    $isMuaActive = request()->routeIs('mua.*') ||
                        request()->routeIs('profilemua.*') ||
                        request()->routeIs('panelmua.layanan.*');
                @endphp

                {{-- DASHBOARD --}}
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                        bg-white/5 border-l-4 border-[#e0ac33]/30
                        hover:bg-[#f2d2841a] hover:border-[#e0ac33] hover:shadow-sm transition
                        {{ request()->routeIs('dashboard') ? 'bg-[#f2d2841a] border-[#e0ac33]' : '' }}">
                    <svg class="w-4 h-4 opacity-80 group-hover:opacity-100" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3l9 8h-3v10H6V11H3l9-8z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- GROUP: MUA --}}
                @if ($role === 'mua')
                    <div x-data="{ openMua: {{ $isMuaActive ? 'true' : 'false' }} }" class="pt-2 space-y-1">
                        <button @click="openMua = !openMua" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl
                                                bg-white/5 border-l-4 border-[#e0ac33]/30
                                                hover:bg-[#f2d2841a] hover:border-[#e0ac33] hover:shadow-sm transition
                                                {{ $isMuaActive ? 'bg-[#f2d2841a] border-[#e0ac33]' : '' }}">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 opacity-80" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 0116 0H4z" />
                                </svg>
                                <span>MUA</span>
                            </span>
                            <svg :class="openMua ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="openMua" x-collapse class="ml-2 pl-4 my-1 border-l border-white/15 space-y-1">
                            <a href="{{ route('mua.panel') }}"
                                class="block px-3 py-2 rounded-lg hover:bg-white/10
                                                {{ request()->routeIs('mua.panel') ? 'bg-white/10 ring-1 ring-white/15' : '' }}">
                                Profil MUA
                            </a>

                            <a href="{{ route('panelmua.layanan.index') }}"
                                class="block px-3 py-2 rounded-lg hover:bg-white/10
                                                {{ request()->routeIs('panelmua.layanan.*') ? 'bg-white/10 ring-1 ring-white/15' : '' }}">
                                Layanan
                            </a>
                        </div>
                    </div>
                @endif

                {{-- TRANSAKSI --}}
                <div class="pt-2 space-y-1">
                    <p class="px-3 text-[11px] uppercase tracking-[0.18em] text-white/40">
                        Transaksi
                    </p>

                    {{-- PESANAN --}}
                    <a href="{{ route('panelmua.pesanan.index') }}"
                        class="group mt-1 flex items-center gap-3 px-3 py-2.5 rounded-xl
                            bg-white/5 border-l-4 border-[#e0ac33]/30
                            hover:bg-[#f2d2841a] hover:border-[#e0ac33] hover:shadow-sm transition
                            {{ request()->routeIs('panelmua.pesanan.index') ? 'bg-[#f2d2841a] border-[#e0ac33]' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-white/80 group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 14h2.5" />
                        </svg>
                        <span>Pesanan</span>
                    </a>

                    {{-- PEMBAYARAN --}}
                    <a href="{{ route('panelmua.pembayaran.index') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                            bg-white/5 border-l-4 border-[#e0ac33]/30
                            hover:bg-[#f2d2841a] hover:border-[#e0ac33] hover:shadow-sm transition
                            {{ request()->routeIs('panelmua.pembayaran.index') ? 'bg-[#f2d2841a] border-[#e0ac33]' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-white/80 group-hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 14h2.5" />
                        </svg>
                        <span>Pembayaran</span>
                    </a>
                </div>

                {{-- AKUN: BERANDA + LOGOUT --}}
                <div class="pt-3 mt-2 border-t border-white/10 space-y-1">
                    <p class="px-3 text-[11px] uppercase tracking-[0.18em] text-white/40">
                        Akun
                    </p>
                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl
                                   bg-white/5 border-l-4 border-[#e3342f]/40
                                   hover:bg-[#f8717180] hover:border-[#fca5a5] hover:shadow-sm transition text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-200 group-hover:text-white"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M10 4a1 1 0 0 1 1 1v3h5a1 1 0 0 1 .8 1.6L14.5 12l2.3 2.4A1 1 0 0 1 16 16h-5v3a1 1 0 0 1-2 0V5a1 1 0 0 1 1-1Z" />
                            </svg>
                            <span class="text-red-100 group-hover:text-white font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- FOOTER SIDEBAR -->
            <div
                class="mt-auto px-4 py-3 border-t border-white/10 text-[11px] text-white/60 flex items-center justify-between">
                <span>29°C — Cerah Berawan</span>
                <span class="text-white/40">AdatKu</span>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="lg:pl-72 pt-20">
        <div class="px-4 sm:px-6 lg:px-8 pb-8">
            @yield('content')
        </div>
    </main>

</body>

</html>