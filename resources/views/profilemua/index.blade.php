<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MUA Panel — Profil MUA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            background-color: #fff9f7;
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
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-amber-400 flex items-center justify-center text-white font-semibold shadow">
                        M</div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-rose-600">MUA Panel</p>
                        <h1 class="text-lg font-semibold">Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <p class="hidden md:block text-sm">Halo, <span
                        class="font-medium text-rose-600">{{ auth()->user()->name ?? 'Admin' }}</span></p>
                <img src="https://i.pravatar.cc/72" class="w-9 h-9 rounded-full border border-rose-100 object-cover"
                    alt="avatar">
            </div>
        </div>
    </header>

    <!-- SIDEBAR -->
    <aside class="fixed z-30 top-16 left-0 w-72 h-[calc(100vh-4rem)] bg-[#231b27] text-white border-r border-white/10"
        :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" x-transition.opacity
        x-transition.duration.200ms>
        <div class="flex flex-col h-full">
            <div class="px-6 py-4 border-b border-white/10">
                <h2 class="text-base font-semibold tracking-wide text-white/90">MUA Panel</h2>
            </div>

            <!-- NAV -->
            <nav class="flex-1 px-3 py-4 text-sm space-y-1">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                  hover:bg-white/10 transition
                  {{ request()->routeIs('dashboard') ? 'bg-white/10 ring-1 ring-white/10' : '' }}">
                    <svg class="w-4 h-4 opacity-80 group-hover:opacity-100" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3l9 8h-3v10H6V11H3l9-8z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <div x-data="{ openMua: {{ request()->routeIs('panelmua.*') ? 'true' : 'false' }} }" class="pt-1">
                    <button @click="openMua = !openMua"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl hover:bg-white/10 transition">
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
                        <a href="{{ route('panelmua.index') }}" class="block px-3 py-2 rounded-lg hover:bg-white/10
                      {{ request()->routeIs('panelmua.index') ? 'bg-white/10 ring-1 ring-white/10' : '' }}">
                            Profil MUA
                        </a>
                        <a href="#" class="block px-3 py-2 rounded-lg hover:bg-white/10">Katalog</a>
                        <a href="#" class="block px-3 py-2 rounded-lg hover:bg-white/10">Pesanan</a>
                    </div>
                </div>
            </nav>

            <div class="mt-auto p-4 border-t border-white/10 text-xs text-white/70">
                29°C — Cerah Berawan
            </div>
        </div>
    </aside>

    <!-- PAGE CONTENT WRAPPER -->
    <main class="pt-16 lg:pl-72">
        <div class="max-8xl mx-auto px-8 py-8">
            <!-- MAIN CONTENT -->
            <main class="flex-1 p-8 bg-[#fff9f7] min-h-screen overflow-y-auto">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white shadow-lg rounded-xl p-6">
                        <h2 class="text-2xl font-bold text-rose-700 mb-6">Profil MUA Anda</h2>

                        @if(session('success'))
                            <div class="mb-4 bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- FOTO | NAMA & DESKRIPSI -->
                        <div class="flex flex-col md:flex-row items-start gap-6">
                            <figure
                                class="shrink-0 w-28 md:w-36 aspect-[3/4] rounded-xl overflow-hidden border bg-slate-100">
                                <img src="{{ ($mua && $mua->foto) ? asset('storage/' . $mua->foto) : 'https://placehold.co/240x320?text=Belum+Ada' }}"
                                    alt="Foto MUA" class="w-full h-full object-cover">
                            </figure>

                            <div class="flex-1 min-w-0">
                                <h3 class="text-2xl md:text-3xl font-bold text-rose-700 leading-tight truncate">
                                    {{ $mua->nama_usaha ?? 'Belum diisi' }}
                                </h3>
                                <p class="mt-2 text-slate-700 leading-relaxed">
                                    {{ $mua->deskripsi ?? 'Belum ada deskripsi yang diisi.' }}
                                </p>
                            </div>
                        </div>


                        <hr class="my-4 border-rose-100">

                        <div>
                            <h4 class="font-semibold text-rose-700 mb-2">Informasi Kontak</h4>
                            <p class="text-rose-600 text-sm mt-1">WA: {{ $mua->kontak_wa ?? '-' }}</p>
                            <p class="text-rose-600 text-sm">Alamat: {{ $mua->alamat ?? '-' }}</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <h4 class="font-semibold text-rose-700 mb-2">Instagram</h4>
                                <a href="{{ $mua->instagram ? 'https://instagram.com/' . ltrim($mua->instagram, '@') : '#' }}"
                                    target="_blank" class="text-rose-600 hover:underline">
                                    {{ $mua->instagram ?? 'Belum diisi' }}
                                </a>
                            </div>
                            <div>
                                <h4 class="font-semibold text-rose-700 mb-2">TikTok</h4>
                                <a href="{{ $mua->tiktok ?? '#' }}" target="_blank"
                                    class="text-rose-600 hover:underline">{{ $mua->tiktok ?? 'Belum diisi' }}</a>
                            </div>
                        </div>

                        <div class="pt-6 flex gap-2">
                            <a href="{{ route('panelmua.create') }}"
                                class="px-5 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700">Buat Profil</a>
                            @if(isset($mua))
                                <a href="{{ route('panelmua.edit', $mua->id) }}"
                                    class="px-5 py-2 rounded-lg bg-amber-500 text-white hover:bg-amber-600">
                                    Edit Profil
                                </a>
                            @endif
                        </div>

                        <p class="text-xs text-slate-500 mt-4">
                            Data ini akan ditampilkan di halaman publik <span class="font-medium">Pilih MUA</span>.
                        </p>
                    </div>

                    <footer class="mt-10 text-xs text-slate-500 text-center pb-8">
                        © {{ date('Y') }} AdatKu — MUA Panel
                    </footer>
                </div>
            </main>
        </div>
        </div>
</body>

</html>