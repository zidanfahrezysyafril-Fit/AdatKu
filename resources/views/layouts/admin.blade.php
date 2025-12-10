<!DOCTYPE html>
<html lang="id" x-data="{ openSidebar: false, userMenu:false }" x-init="
    if (window.innerWidth >= 768) { openSidebar = true }
">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AdatKu Admin — Panel')</title>
    <link rel="icon" type="image/png" href="/logo_1.png?v=1">
    <link rel="shortcut icon" type="image/png" href="/logo_1.png?v=1">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* ===== BACKGROUND AREA KONTEN (TERANG CREAM/GOLD) ===== */
        body {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #fff9f5;
            background-image:
                linear-gradient(135deg,
                    #fff5ea 0%,
                    #fffaf0 45%,
                    #fff6e4 100%);
            background-attachment: fixed;
            color: #0f172a;
        }

        /* CARD STYLE UNTUK DASHBOARD (BISA DIPAKAI DI CHILD VIEW) */
        .card-soft {
            background: #ffffffee;
            border-radius: 18px;
            border: 1px solid rgba(250, 200, 140, 0.45);
            box-shadow: 0 10px 24px rgba(200, 140, 70, 0.18);
            backdrop-filter: blur(3px);
        }

        .card-table {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid rgba(250, 200, 140, 0.4);
            box-shadow: 0 8px 22px rgba(200, 140, 70, 0.15);
            overflow: hidden;
        }

        /* SCROLLBAR SIDEBAR BIAR LEBIH HALUS */
        aside nav::-webkit-scrollbar {
            width: 6px;
        }

        aside nav::-webkit-scrollbar-track {
            background: transparent;
        }

        aside nav::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.5);
            border-radius: 999px;
        }
    </style>
</head>

<body class="text-slate-800" x-cloak>

    <div class="min-h-screen flex bg-transparent">

        {{-- ====== OVERLAY MOBILE (saat sidebar kebuka) ====== --}}
        <div class="fixed inset-0 bg-black/40 z-30 md:hidden" x-show="openSidebar" x-cloak @click="openSidebar = false">
        </div>

        {{-- ===================== SIDEBAR (DARK) ===================== --}}
        <aside class="bg-[#151019] border-r border-[#271b33] shadow-[0_0_35px_rgba(0,0,0,0.9)]
                   fixed inset-y-0 left-0 z-40 transform transition-transform duration-200
                   flex flex-col md:static md:translate-x-0" :class="openSidebar
                ? 'translate-x-0 w-64'
                : '-translate-x-full w-64 md:translate-x-0 md:w-20'">

            {{-- Brand --}}
            <div class="px-4 py-4 flex items-center gap-3 border-b border-[#271b33]">

                {{-- Tombol garis 3 (selalu ada di sidebar) --}}
                <button @click="openSidebar = !openSidebar"
                    class="p-2 rounded-xl hover:bg-[#241726] text-[#f6c86c] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16v2H4V6Zm0 5h16v2H4v-2Zm0 5h16v2H4v-2Z" />
                    </svg>
                </button>

                {{-- Logo + teks (teks hanya muncul ketika sidebar lebar / openSidebar=true) --}}
                <div class="flex items-center gap-3" x-show="openSidebar" x-cloak>
                    <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center shadow-md
                               border border-amber-200 overflow-hidden">
                        <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu" class="object-contain scale-[2.65]">
                    </div>
                    <div>
                        <p class="text-[11px] tracking-[0.20em] uppercase text-amber-300 font-semibold">
                            AdatKu Admin
                        </p>
                        <p class="text-xs font-semibold text-[#fef3d8] leading-tight">
                            Panel Pengelola
                        </p>
                    </div>
                </div>
            </div>

            {{-- Menu --}}
            <nav class="px-3 pt-4 flex-1 overflow-y-auto space-y-3 text-sm">

                {{-- Label grup menu --}}
                <p class="px-3 text-[10px] tracking-[0.18em] uppercase text-slate-400/80 mb-1" x-show="openSidebar"
                    x-cloak>
                    Navigasi Utama
                </p>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard_a') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition
               @if(request()->routeIs('dashboard_a'))
                   bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f]
                   text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
               @else
                   text-slate-100 hover:bg-[#231729]
               @endif">

                    <span class="w-8 h-8 rounded-xl flex items-center justify-center border text-xs transition
                    @if(request()->routeIs('dashboard_a'))
                        bg-white text-[#f59f0b] border-[#f9c66e]
                    @else
                        bg-[#1d1426] text-[#facc6b] border-[#2d1b38] group-hover:border-[#facc6b]
                    @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3 2 12h3v8h6v-6h2v6h6v-8h3z" />
                        </svg>
                    </span>
                    <span x-show="openSidebar" x-cloak>Dashboard</span>
                </a>

                {{-- Users --}}
                <a href="{{ route('users.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition
                   @if(request()->routeIs('users.*'))
                       bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f]
                       text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
                   @else
                       text-slate-100 hover:bg-[#231729]
                   @endif">
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center border text-xs transition
                        @if(request()->routeIs('users.*'))
                            bg-white text-[#f59f0b] border-[#f9c66e]
                        @else
                            bg-[#1d1426] text-[#facc6b] border-[#2d1b38] group-hover:border-[#facc6b]
                        @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-3.33 0-6 1.34-6 4v2h12v-2c0-2.66-2.67-4-6-4Z" />
                        </svg>
                    </span>
                    <span x-show="openSidebar" x-cloak>Users</span>
                </a>

                {{-- Label grup menu ke-2 --}}
                <p class="px-3 pt-3 text-[10px] tracking-[0.18em] uppercase text-slate-400/80" x-show="openSidebar"
                    x-cloak>
                    Manajemen Data
                </p>

                {{-- Pesan Kontak --}}
                <a href="{{ route('admin.contact.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition
                   @if(request()->routeIs('admin.contact.*'))
                       bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f]
                       text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
                   @else
                       text-slate-100 hover:bg-[#231729]
                   @endif">
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center border text-xs transition
                        @if(request()->routeIs('admin.contact.*'))
                            bg-white text-[#f59f0b] border-[#f9c66e]
                        @else
                            bg-[#1d1426] text-[#facc6b] border-[#2d1b38] group-hover:border-[#facc6b]
                        @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 3.5-8 5-8-5V6l8 5 8-5Z" />
                        </svg>
                    </span>
                    <span x-show="openSidebar" x-cloak>Pesan Kontak</span>
                </a>

                {{-- Request MUA --}}
                <a href="{{ route('admin.mua-requests.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition
                   @if(request()->routeIs('admin.mua-requests.*'))
                       bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f]
                       text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
                   @else
                       text-slate-100 hover:bg-[#231729]
                   @endif">
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center border text-xs transition
                        @if(request()->routeIs('admin.mua-requests.*'))
                            bg-white text-[#f59f0b] border-[#f9c66e]
                        @else
                            bg-[#1d1426] text-[#facc6b] border-[#2d1b38] group-hover:border-[#facc6b]
                        @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M4 4h16a1 1 0 0 1 1 1v4H3V5a1 1 0 0 1 1-1Zm-1 7h8v8H4a1 1 0 0 1-1-1v-7Zm10 0h8v3h-8v-3Zm0 5h6v3h-6v-3Z" />
                        </svg>
                    </span>
                    <span x-show="openSidebar" x-cloak>Request MUA</span>
                </a>

                {{-- Galeri --}}
                <a href="{{ route('admin.galleries.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition
                   @if(request()->routeIs('admin.galleries.*'))
                       bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f]
                       text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
                   @else
                       text-slate-100 hover:bg-[#231729]
                   @endif">
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center border text-xs transition
                        @if(request()->routeIs('admin.galleries.*'))
                            bg-white text-[#f59f0b] border-[#f9c66e]
                        @else
                            bg-[#1d1426] text-[#facc6b] border-[#2d1b38] group-hover:border-[#facc6b]
                        @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v11a1 1 0 0 1-1 1H5a3 3 0 0 1-3-3Zm4 1a2 2 0 1 0 2 2 2 2 0 0 0-2-2Zm3.5 4.5-2.9 3.63A1 1 0 0 0 9.5 16h7a1 1 0 0 0 .82-1.57l-2.3-3.22a1 1 0 0 0-1.62-.02l-.93 1.24Z" />
                        </svg>
                    </span>
                    <span x-show="openSidebar" x-cloak>Galeri Beranda</span>
                </a>

                {{-- Team --}}
                <a href="{{ route('admin.team-members.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition
                   @if(request()->routeIs('admin.team-members.*'))
                       bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f]
                       text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
                   @else
                       text-slate-100 hover:bg-[#231729]
                   @endif">
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center border text-xs transition
                        @if(request()->routeIs('admin.team-members.*'))
                            bg-white text-[#f59f0b] border-[#f9c66e]
                        @else
                            bg-[#1d1426] text-[#facc6b] border-[#2d1b38] group-hover:border-[#facc6b]
                        @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v11a1 1 0 0 1-1 1H5a3 3 0 0 1-3-3Zm4 1a2 2 0 1 0 2 2 2 2 0 0 0-2-2Zm3.5 4.5-2.9 3.63A1 1 0 0 0 9.5 16h7a1 1 0 0 0 .82-1.57l-2.3-3.22a1 1 0 0 0-1.62-.02l-.93 1.24Z" />
                        </svg>
                    </span>
                    <span x-show="openSidebar" x-cloak>Team Members</span>
                </a>

                {{-- ====== AKUN: BERANDA + LOGOUT ====== --}}
                @auth
                    <div class="mt-4 pt-3 border-t border-[#271b33] space-y-1">
                        <p class="px-3 text-[10px] tracking-[0.18em] uppercase text-slate-400/80" x-show="openSidebar"
                            x-cloak>
                            Akun
                        </p>
                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition
                                               text-slate-100 hover:bg-[#3b151b]">
                                <span class="w-8 h-8 rounded-xl flex items-center justify-center border text-xs
                                               bg-[#1d1426] text-[#fecaca] border-[#7f1d1d] group-hover:border-[#fecaca]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path
                                            d="M10 4a1 1 0 0 1 1 1v3h5a1 1 0 0 1 .8 1.6L14.5 12l2.3 2.4A1 1 0 0 1 16 16h-5v3a1 1 0 0 1-2 0V5a1 1 0 0 1 1-1Z" />
                                    </svg>
                                </span>
                                <span x-show="openSidebar" x-cloak class="font-semibold text-rose-100">
                                    Logout
                                </span>
                            </button>
                        </form>
                    </div>
                @endauth
            </nav>

            {{-- Footer sidebar (desktop only, & saat open) --}}
            <div class="px-4 py-3 border-t border-[#271b33] text-[11px] text-[#f2d49a] hidden md:block"
                x-show="openSidebar" x-cloak>
                © {{ date('Y') }} AdatKu Admin <br>
                <span class="text-[#e9c27f]">Sentuhan adat, rasa modern.</span>
            </div>
        </aside>

        {{-- ===================== TOPBAR + CONTENT ===================== --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- TOPBAR TERANG --}}
            <header class="bg-[#fff7ed]/95 border-b border-amber-100 shadow-[0_6px_20px_rgba(190,120,40,0.15)]
                       sticky top-0 z-20 backdrop-blur">
                <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">

                    {{-- kiri: burger + title --}}
                    <div class="flex items-start gap-3">
                        {{-- burger (hanya di mobile) --}}
                        <button
                            class="md:hidden mt-1 p-2 rounded-xl border border-amber-200 bg-white text-amber-600 shadow-sm"
                            @click="openSidebar = !openSidebar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M4 6h16v2H4V6Zm0 5h16v2H4v-2Zm0 5h16v2H4v-2Z" />
                            </svg>
                        </button>

                        <div>
                            <p class="text-[11px] tracking-[0.22em] uppercase text-amber-500 font-semibold">
                                AdatKu Admin
                            </p>
                            <h1 class="text-base md:text-xl font-semibold text-slate-900 flex items-center gap-2">
                                @yield('page_title', 'Dashboard')
                                <span class="inline-flex items-center px-2 py-[2px] rounded-full text-[11px]
                                       bg-amber-100 text-amber-800 border border-amber-200">
                                    Panel
                                </span>
                            </h1>
                            <p class="text-[11px] md:text-sm text-slate-500 mt-0.5">
                                @yield('page_desc')
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Dashboard (khusus MOBILE) --}}
                    <div class="flex md:hidden items-center gap-2">
                        @auth
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[11px] font-semibold
                                          bg-amber-50 text-amber-800 border border-amber-200 shadow-sm
                                          hover:bg-amber-100 hover:border-amber-300 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M10 19a1 1 0 0 0 1-1v-4h8v-4h-8V6a1 1 0 0 0-1.64-.77l-7 6a1 1 0 0 0 0 1.54l7 6A1 1 0 0 0 10 19Z" />
                                </svg>
                                <span>Kembali ke Beranda</span>
                            </a>
                        @endauth
                    </div>

                    {{-- slot kanan (desktop) --}}
                    <div class="hidden md:flex items-center gap-3">
                        @auth
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold
                                          bg-amber-50 text-amber-800 border border-amber-200 shadow-sm
                                          hover:bg-amber-100 hover:border-amber-300 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M10 19a1 1 0 0 0 1-1v-4h8v-4h-8V6a1 1 0 0 0-1.64-.77l-7 6a1 1 0 0 0 0 1.54l7 6A1 1 0 0 0 10 19Z" />
                                </svg>
                                <span>Kembali ke Beranda</span>
                            </a>
                        @endauth

                        @yield('page_actions')
                    </div>
                </div>
            </header>

            {{-- CONTENT --}}
            <main class="max-w-7xl mx-auto w-full p-4 md:p-6 space-y-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>