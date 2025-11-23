<!DOCTYPE html>
<html lang="id" x-data="{ openSidebar: true, userMenu:false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AdatKu Admin — Panel')</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* ===== BACKGROUND AREA KONTEN (TERANG CREAM/GOLD) ===== */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff9f5;
            background-image:
                linear-gradient(135deg,
                    #fff5ea 0%,
                    #fffaf0 45%,
                    #fff6e4 100%);
            background-attachment: fixed;
        }

        /* CARD STYLE UNTUK DASHBOARD */
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
    </style>
</head>

<body class="text-slate-800" x-cloak>
<div class="min-h-screen flex">

    {{-- ===================== SIDEBAR (TETAP DARK) ===================== --}}
    <aside :class="openSidebar ? 'w-64' : 'w-20'"
           class="bg-[#151019] border-r border-[#271b33] sticky top-0 h-screen transition-all duration-200 flex flex-col shadow-[0_0_35px_rgba(0,0,0,0.9)]">

        {{-- Brand --}}
        <div class="px-4 py-4 flex items-center gap-3 border-b border-[#271b33]">
            <button @click="openSidebar = !openSidebar"
                    class="p-2 rounded-xl hover:bg-[#241726] text-[#f6c86c] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                     viewBox="0 0 24 24">
                    <path d="M4 6h16v2H4V6Zm0 5h16v2H4v-2Zm0 5h16v2H4v-2Z"/>
                </svg>
            </button>

            <div x-show="openSidebar" class="flex items-center gap-2">
                <div
                    class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#facc6b] via-[#f59f63] to-[#f97373] flex items-center justify-center text-[#231616] font-semibold shadow-md border border-[#f6d18b]">
                    Ak
                </div>
                <div>
                    <p class="text-sm font-semibold text-[#fef3d8] leading-tight">AdatKu Admin</p>
                    <p class="text-[11px] text-[#f6c86c] leading-tight">Panel Pengelola</p>
                </div>
            </div>
        </div>

        {{-- Menu --}}
        <nav class="px-3 pt-4 flex-1 overflow-y-auto space-y-2 text-sm">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                    @if(request()->routeIs('admin.dashboard'))
                        bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f] text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
                    @else
                        text-slate-100 hover:bg-[#231729]
                    @endif">
                <span
                    class="w-8 h-8 rounded-xl flex items-center justify-center border
                        @if(request()->routeIs('admin.dashboard'))
                            bg-white text-[#f59f0b] border-[#f9c66e]
                        @else
                            bg-[#1d1426] text-[#facc6b] border-[#2d1b38]
                        @endif">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path d="M12 3 2 12h3v8h6v-6h2v6h6v-8h3z"/>
                    </svg>
                </span>
                <span x-show="openSidebar">Dashboard</span>
            </a>

            {{-- Users --}}
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                    @if(request()->routeIs('users.*'))
                        bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f] text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
                    @else
                        text-slate-100 hover:bg-[#231729]
                    @endif">
                <span
                    class="w-8 h-8 rounded-xl flex items-center justify-center border
                        @if(request()->routeIs('users.*'))
                            bg-white text-[#f59f0b] border-[#f9c66e]
                        @else
                            bg-[#1d1426] text-[#facc6b] border-[#2d1b38]
                        @endif">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-3.33 0-6 1.34-6 4v2h12v-2c0-2.66-2.67-4-6-4Z"/>
                    </svg>
                </span>
                <span x-show="openSidebar">Users</span>
            </a>

            {{-- Pesan Kontak --}}
            <a href="{{ route('admin.contact.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                    @if(request()->routeIs('admin.contact.*'))
                        bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f] text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
                    @else
                        text-slate-100 hover:bg-[#231729]
                    @endif">
                <span
                    class="w-8 h-8 rounded-xl flex items-center justify-center border
                        @if(request()->routeIs('admin.contact.*'))
                            bg-white text-[#f59f0b] border-[#f9c66e]
                        @else
                            bg-[#1d1426] text-[#facc6b] border-[#2d1b38]
                        @endif">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 3.5-8 5-8-5V6l8 5 8-5Z"/>
                    </svg>
                </span>
                <span x-show="openSidebar">Pesan Kontak</span>
            </a>

            {{-- Request MUA --}}
            <a href="{{ route('admin.mua-requests.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                    @if(request()->routeIs('admin.mua-requests.*'))
                        bg-gradient-to-r from-[#f2b044] via-[#ffd369] to-[#f9b44f] text-[#201317] font-semibold shadow-[0_6px_18px_rgba(0,0,0,0.6)]
                    @else
                        text-slate-100 hover:bg-[#231729]
                    @endif">
                <span
                    class="w-8 h-8 rounded-xl flex items-center justify-center border
                        @if(request()->routeIs('admin.mua-requests.*'))
                            bg-white text-[#f59f0b] border-[#f9c66e]
                        @else
                            bg-[#1d1426] text-[#facc6b] border-[#2d1b38]
                        @endif">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            d="M4 4h16a1 1 0 0 1 1 1v4H3V5a1 1 0 0 1 1-1Zm-1 7h8v8H4a1 1 0 0 1-1-1v-7Zm10 0h8v3h-8v-3Zm0 5h6v3h-6v-3Z"/>
                    </svg>
                </span>
                <span x-show="openSidebar">Request MUA</span>
            </a>
        </nav>

        {{-- Footer sidebar --}}
        <div class="px-4 py-3 border-t border-[#271b33] text-[11px] text-[#f2d49a]" x-show="openSidebar">
            © {{ date('Y') }} AdatKu Admin <br>
            <span class="text-[#e9c27f]">Sentuhan adat, rasa modern.</span>
        </div>
    </aside>

    {{-- ===================== TOPBAR + CONTENT (TERANG) ===================== --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR TERANG --}}
        <header class="bg-[#fff7ed]/95 border-b border-amber-100 shadow-[0_6px_20px_rgba(190,120,40,0.15)] sticky top-0 z-30 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <div>
                    <p class="text-[11px] tracking-[0.22em] uppercase text-amber-500 font-semibold">
                        AdatKu Admin
                    </p>
                    <h1 class="text-lg md:text-xl font-semibold text-slate-900">
                        @yield('page_title', 'Dashboard')
                        <span
                            class="align-middle ml-2 inline-flex items-center px-2 py-[2px] rounded-full text-[11px] bg-amber-100 text-amber-800 border border-amber-200">
                            Panel
                        </span>
                    </h1>
                    <p class="text-xs md:text-sm text-slate-500 mt-0.5">
                        @yield('page_desc')
                    </p>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="max-w-7xl mx-auto w-full p-4 md:p-6">
            @yield('content')
        </main>

    </div>
</div>
</body>
</html>
