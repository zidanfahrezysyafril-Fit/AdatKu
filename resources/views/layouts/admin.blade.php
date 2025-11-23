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
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #fff9fb;

            /* LAYER 1: gradasi lembut cream + pink */
            /* LAYER 2: motif kotak batik rose-gold */
            background-image:
                linear-gradient(
                    135deg,
                    rgba(255, 246, 251, 0.97),
                    rgba(255, 246, 238, 0.97)
                ),
                repeating-linear-gradient(
                    45deg,
                    #f2c3c9 0px,
                    #f2c3c9 8px,
                    #ffe3d9 8px,
                    #ffe3d9 16px
                );
            background-size: cover, 110px 110px;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="text-slate-800" x-cloak>
<div class="min-h-screen flex">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside :class="openSidebar ? 'w-64' : 'w-20'"
           class="bg-white/92 backdrop-blur-xl border-r border-rose-100 sticky top-0 h-screen transition-all duration-200 flex flex-col shadow-[0_10px_30px_rgba(244,114,182,0.15)]">

        {{-- Brand / Logo --}}
        <div class="px-4 py-4 flex items-center gap-3 border-b border-rose-50/80">
            <button @click="openSidebar = !openSidebar"
                    class="p-2 rounded-xl hover:bg-rose-50 text-rose-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                     fill="currentColor">
                    <path d="M4 6h16v2H4V6Zm0 5h16v2H4v-2Zm0 5h16v2H4v-2Z"/>
                </svg>
            </button>

            <div x-show="openSidebar" class="flex items-center gap-2">
                <div
                    class="w-10 h-10 rounded-2xl bg-gradient-to-br from-rose-300 via-rose-400 to-amber-300 flex items-center justify-center text-white font-semibold shadow-md border border-rose-200">
                    Ak
                </div>
                <div>
                    <p class="text-sm font-semibold text-rose-700 leading-tight">AdatKu Admin</p>
                    <p class="text-[11px] text-rose-400 leading-tight">Panel Pengelola</p>
                </div>
            </div>
        </div>

        {{-- Menu --}}
        <nav class="px-2 pt-4 space-y-1 flex-1">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                @if(request()->routeIs('admin.dashboard'))
                    bg-gradient-to-r from-rose-50 via-amber-50 to-rose-50 text-rose-700 font-semibold shadow-sm
                @else
                    hover:bg-rose-50/80 text-slate-700
                @endif">
                <span
                    class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 border border-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path d="M12 3 2 12h3v8h6v-6h2v6h6v-8h3z"/>
                    </svg>
                </span>
                <span x-show="openSidebar">Dashboard</span>
            </a>

            {{-- Users --}}
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                @if(request()->routeIs('users.*'))
                    bg-gradient-to-r from-rose-50 via-amber-50 to-rose-50 text-rose-700 font-semibold shadow-sm
                @else
                    hover:bg-rose-50/80 text-slate-700
                @endif">
                <span
                    class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 border border-rose-100">
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
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                @if(request()->routeIs('admin.contact.*'))
                    bg-gradient-to-r from-rose-50 via-amber-50 to-rose-50 text-rose-700 font-semibold shadow-sm
                @else
                    hover:bg-rose-50/80 text-slate-700
                @endif">
                <span
                    class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 border border-rose-100">
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
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                @if(request()->routeIs('admin.mua-requests.*'))
                    bg-gradient-to-r from-rose-50 via-amber-50 to-rose-50 text-rose-700 font-semibold shadow-sm
                @else
                    hover:bg-rose-50/80 text-slate-700
                @endif">
                <span
                    class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 border border-rose-100">
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
        <div class="px-4 py-3 border-t border-rose-50/80" x-show="openSidebar">
            <p class="text-[11px] text-rose-400">
                © {{ date('Y') }} AdatKu Admin<br>
                <span class="text-[10px]">Sentuhan adat, rasa modern.</span>
            </p>
        </div>
    </aside>

    {{-- ===================== MAIN AREA ===================== --}}
    <div class="flex-1 flex flex-col">

        {{-- Topbar --}}
        <header
            class="bg-white/95 backdrop-blur-xl border-b border-rose-100 sticky top-0 z-30 shadow-[0_6px_20px_rgba(244,114,182,0.12)]">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <div>
                    <p class="text-[11px] tracking-[0.22em] uppercase text-rose-400 font-semibold">
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

                <div class="relative flex items-center gap-3">
                    <div class="hidden sm:flex flex-col items-end mr-1">
                        <span class="text-[11px] text-slate-500">Role</span>
                        <span
                            class="text-[11px] px-2 py-[2px] rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Admin
                        </span>
                    </div>

                    <button @click="userMenu = !userMenu"
                            class="flex items-center gap-2 px-3 py-2 rounded-xl border border-rose-100 hover:bg-rose-50/70 transition bg-white/90">
                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded-full ring-2 ring-rose-100"
                             alt="Admin">
                        <div class="hidden sm:block text-left">
                            <p class="text-xs font-semibold text-slate-800">Admin</p>
                            <p class="text-[11px] text-slate-500">admin@adatku</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                    <div x-show="userMenu" @click.outside="userMenu=false" x-transition.opacity
                         class="absolute right-0 top-12 w-48 bg-white border border-rose-100 rounded-2xl shadow-lg p-2 z-40">
                        <a href="#"
                           class="block px-3 py-2 rounded-xl text-sm text-slate-700 hover:bg-rose-50">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full mt-1 px-3 py-2 rounded-xl text-sm text-white
                                           bg-gradient-to-r from-rose-400 via-amber-400 to-orange-400 hover:opacity-95 shadow-md">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="max-w-7xl mx-auto w-full p-4 md:p-6">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
