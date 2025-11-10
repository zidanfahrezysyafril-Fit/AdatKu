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

<body class="text-slate-800 min-h-screen overflow-x-hidden">
    <div x-data="{ open: true }" class="min-h-screen flex flex-col">

        <!-- HEADER -->
        <header class="fixed top-0 left-0 right-0 z-40 bg-white shadow-sm border-b border-rose-100">
            <div class="w-full px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button @click="open = !open"
                        class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 hover:bg-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-amber-400 flex items-center justify-center text-white font-semibold shadow">
                            M
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-rose-600">MUA Panel</p>
                            <h1 class="text-lg font-semibold">Dashboard</h1>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <p class="hidden md:block text-sm">Halo, <span
                            class="font-medium text-rose-600">{{ auth()->user()->name ?? 'Admin' }}</span></p>
                    <div class="w-9 h-9 rounded-full overflow-hidden border border-rose-100">
                        <img src="https://i.pravatar.cc/72" class="object-cover w-full h-full" alt="avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1 pt-16">

            <!-- SIDEBAR -->
            <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="w-64 bg-[#2a2330] text-white transition-transform duration-200 flex-shrink-0 h-[calc(100vh-4rem)] fixed lg:static">
                <div class="flex flex-col h-full">
                    <div class="px-6 py-6 border-b border-white/10">
                        <h2 class="text-lg font-semibold">MUA Panel</h2>
                    </div>
                    <nav x-data="{ openMua:false, openKatalog:false }" class="flex-1 px-4 py-3 space-y-1 text-sm">
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 rounded-lg bg-white/10 hover:bg-white/15 transition">Dashboard</a>

                        <!-- MUA (dropdown) -->
                        <button @click="openMua = !openMua"
                            class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-white/10 transition">
                            <span>MUA</span>
                            <svg :class="openMua ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="openMua" x-collapse class="ml-2 pl-3 border-l border-white/10 space-y-1">
                            <a href="{{ route('panelmua.index') }}"
                                class="block px-3 py-2 rounded-md hover:bg-white/10">
                                Profil MUA
                            </a>

                            <!-- Katalog Layanan (sub dropdown) -->
                            <button @click="openKatalog = !openKatalog"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-md hover:bg-white/10">
                                <span>Katalog Layanan</span>
                                <svg :class="openKatalog ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="openKatalog" x-collapse class="ml-2 pl-3 border-l border-white/10 space-y-1">
                                <a href="{{ route('dashboard') }}"
                                    class="block px-3 py-2 rounded-md hover:bg-white/10">Baju Adat</a>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-3 py-2 rounded-md hover:bg-white/10">Makeup</a>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-3 py-2 rounded-md hover:bg-white/10">Pelamin</a>
                            </div>
                        </div>
                    </nav>

                    <div class="p-4 border-t border-white/10 text-xs text-white/80">
                        <p>29°C — Cerah Berawan</p>
                    </div>
                </div>
            </aside>


<!-- MAIN CONTENT -->
<main class="flex-1 p-8 bg-[#fff9f7] min-h-screen overflow-y-auto">
    <div class="max-w-4xl mx-auto">

        <!-- Kotak Panel -->
        <div class="bg-white shadow-lg rounded-xl p-6">

            <h2 class="text-2xl font-bold text-rose-700 mb-6">Profil MUA Anda</h2>

            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-6 items-start">
                <div class="w-32 h-32 rounded-xl overflow-hidden border bg-slate-100">
                    <img src="{{ ($mua && $mua->foto) ? asset('storage/' . $mua->foto) : 'https://placehold.co/200x200?text=Belum+Ada' }}"
                        alt="Foto MUA" class="object-cover w-full h-full">
                </div>
                <div>
                    <h3 class="text-xl font-bold text-rose-700">{{ $mua->nama_usaha ?? 'Belum diisi' }}</h3>
                    <p class="text-slate-600 text-sm mt-1">WA: {{ $mua->kontak_wa ?? '-' }}</p>
                    <p class="text-slate-600 text-sm">Alamat: {{ $mua->alamat ?? '-' }}</p>
                </div>
            </div>

            <hr class="my-4 border-rose-100">

            <div>
                <h4 class="text-lg font-semibold text-rose-700 mb-2">Deskripsi Singkat</h4>
                <p class="text-slate-700 leading-relaxed">
                    {{ $mua->deskripsi ?? 'Belum ada deskripsi yang diisi.' }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mt-4">
                <div>
                    <h4 class="font-semibold text-rose-700 mb-2">Instagram</h4>
                    <a href="{{ $mua->instagram ?? '#' }}" target="_blank"
                        class="text-rose-600 hover:underline">{{ $mua->instagram ?? 'Belum diisi' }}</a>
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
                        class="px-5 py-2 rounded-lg bg-amber-500 text-white hover:bg-amber-600">Edit Profil</a>
                @endif
            </div>

            <p class="text-xs text-slate-500 mt-4">
                Data ini akan ditampilkan di halaman publik <span class="font-medium">Pilih MUA</span>.
            </p>
        </div>
        <!-- END Kotak Panel -->

        <footer class="mt-10 text-xs text-slate-500 text-center pb-8">
            © {{ date('Y') }} AdatKu — MUA Panel
        </footer>
    </div>
</main>


        </div>
    </div>
</body>

</html>