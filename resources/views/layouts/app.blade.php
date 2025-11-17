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
    </style>
</head>

<body class="text-slate-800 min-h-screen overflow-x-hidden" x-data="{ open: false }">

    <!-- HEADER -->
    <header class="fixed top-0 inset-x-0 z-40 bg-white shadow-sm border-b border-rose-100">
        <div class="px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button @click="open = !open"
                    class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 hover:bg-slate-100">
                    <!-- menu -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-amber-400 flex items-center justify-center text-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] font-semibold shadow">
                        M</div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-rose-600">MUA Panel</p>
                        <h1 class="text-lg font-semibold">Dashboard</h1>
                    </div>
                </div>
            </div>
            @auth
                @php
                    $user = auth()->user();
                    $avatar = $user->avatar
                        ? asset('storage/' . $user->avatar)
                        : asset('default-avatar.png');
                  @endphp

                <div x-data="{ open:false }" class="relative">
                    <button @click="open = !open"
                        class="w-11 h-11 rounded-full overflow-hidden border-2 border-[#f5d547] shadow focus:outline-none">
                        <img src="{{ $avatar }}" alt="Profile" class="w-full h-full object-cover"
                            onerror="this.onerror=null;this.src='{{ asset('default-avatar.png') }}'">
                    </button>

                    <div x-show="open" x-transition @click.outside="open=false"
                        class="absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-lg ring-1 ring-black/5 overflow-hidden z-50">
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                        </div>
                        <ul class="py-1 text-sm">
                            <li class="border-t">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth
        </div>
    </header>
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

    <aside class="fixed z-30 top-16 left-0 w-72 h-[calc(100vh-4rem)] bg-[#231b27] text-white border-r border-white/10"
        :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" x-transition.opacity
        x-transition.duration.200ms>
        <div class="flex flex-col h-full">
            <div class="px-6 py-4 border-b border-white/10">
                <h2 class="text-base font-semibold tracking-wide text-white/90">MUA Panel</h2>
            </div>

            <nav class="flex-1 px-3 py-4 text-sm space-y-1">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                  hover:bg-white/10 transition
                  {{ request()->routeIs('dashboard') ? 'bg-white/10 ring-1 ring-white/10' : '' }}">
                    <svg class="w-4 h-4 opacity-80 group-hover:opacity-100" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3l9 8h-3v10H6V11H3l9-8z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                @php $role = strtolower(auth()->user()->role ?? ''); @endphp
                @if ($role === 'mua')
                    <div x-data="{ openMua: {{ request()->routeIs('mua.*') || request()->routeIs('profilemua.*') ? 'true' : 'false' }} }"
                        class="pt-1">
                        <button @click="openMua = !openMua"
                            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl mb-2 hover:bg-white/10 transition">
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

                        <div x-show="openMua" x-collapse class="ml-2 pl-4 my-1 border-l border-white/10 space-y-1">
                            <a href="{{ route('mua.panel') }}"
                                class="block px-3 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('mua.panel') ? 'bg-white/10 ring-1 ring-white/10' : '' }}">
                                Profil MUA
                            </a>
                            <a href="{{ route('panelmua.layanan.index') }}"
                                class="block px-3 py-2 rounded-lg mb-2 hover:bg-white/10">
                                Layanan
                            </a>
                        </div>
                    </div>
                @endif
                <a href="{{ route('panelmua.pesanan.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                  hover:bg-white/10 transition
                  {{ request()->routeIs('panelmua.pesanan.index') ? 'bg-white/10 ring-1 ring-white/10' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-white/80 group-hover:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 14h2.5" />
                    </svg>
                    <span>Pesanan</span>
                </a>
                 <a href="{{ route('mua.panel') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                  hover:bg-white/10 transition
                  {{ request()->routeIs('mua.panel') ? 'bg-white/10 ring-1 ring-white/10' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-white/80 group-hover:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 14h2.5" />
                    </svg>
                    <span>Transaksi</span>
                </a>
            </nav>
            <div class="mt-auto p-4 border-t border-white/10 text-xs text-white/70">
                29°C — Cerah Berawan
            </div>
        </div>
    </aside>

    <main class="pt-21 lg:pl-72 ">
        <div class="w-full">
            @yield('content')
        </div>
    </main>

</html>