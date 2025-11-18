<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdatKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', monospace, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }

        .logo-font {
            font-family: 'Perfecto Kaligrafi', 'Great Vibes', cursive;
        }
    </style>
</head>

<body class="bg-[rgba(255,242,213,0.08)] text-gray-900">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-opacity-1 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                        class="w-14 h-14 rounded-full object-cover shadow-md">
                    <h1
                        class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent tracking-wide">
                        AdatKu
                    </h1>
                </a>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-[18px] text-[#b48a00]">
                <a href="{{ 'home' }}" class="hover:text-[#eab308]">Beranda</a>
                <a href="#" class="hover:text-[#eab308]">Daftar MUA</a>
                <a href="{{ ('hubungikami') }}" class="hover:text-[#eab308]">Hubungi Kami</a>
            </nav>
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('auth') }}"
                        class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white px-5 py-2 rounded-full font-Arial shadow-md hover:shadow-lg hover:from-[#f8e48c] hover:to-[#e0a100] transition">
                        Sign In
                    </a>
                @endguest
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
                                <li>
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-50">Profil
                                        Saya</a>
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
    </header>

    <!-- HERO -->
    <section class="relative">
        <img src="{{ asset('logoss3 .jpg') }}" alt="Hero AdatKu" class="w-full h-[580px] object-cover brightness-75">
        <div
            class="absolute inset-0 flex flex-col justify-center items-center text-center bg-gradient-to-b from-black/30 via-black/20 to-black/30">
            <h1 class="text-5xl md:text-6xl font-semibold mb-3">
                <span
                    class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent drop-shadow-lg">
                    Selamat Datang di <span class="logo-font text-6xl md:text-7xl">AdatKu</span>
                </span>
            </h1>
            <p class="text-lg md:text-xl w-11/12 md:w-2/5">
                <span
                    class="bg-gradient-to-r from-[#fff3b0] via-[#f5d547] to-[#d4a017] bg-clip-text text-transparent drop-shadow-md">
                    Temukan keindahan budaya dan tradisi melalui koleksi busana adat, rias, dan pelaminan terbaik.
                </span>
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 py-10 flex flex-col lg:flex-row gap-6">
        <!-- SIDEBAR -->
        <aside class="lg:w-64 w-full">
            <div class="bg-white shadow-md rounded-2xl border border-yellow-200/70 px-5 py-6 sticky top-24 space-y-5">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Pilih</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Pilih menu untuk melihat daftar MUA yang sudah terdaftar di AdatKu.
                    </p>
                </div>

                <nav class="space-y-2 text-sm">
                    <button class="w-full text-left py-2.5 px-4 rounded-xl font-semibold
                           bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                           text-white shadow-md">
                        Daftar MUA
                    </button>
                    {{-- kalau nanti mau tambah filter tinggal aktifkan ini
                    <button class="w-full text-left py-2.5 px-4 rounded-xl text-gray-700 bg-gray-50 hover:bg-gray-100">
                        MUA Terdekat
                    </button>
                    --}}
                </nav>

                <div class="border-t border-gray-200 pt-4 text-xs text-gray-500">
                    Tips: gunakan kolom pencarian di kanan untuk mencari berdasarkan
                    <span class="font-semibold">nama usaha</span> atau <span class="font-semibold">alamat</span>.
                </div>
            </div>
        </aside>

        <!-- KONTEN DAFTAR MUA -->
        <section class="flex-1 bg-white rounded-2xl shadow-md border border-gray-200 px-6 py-6 min-h-[300px]">
            <!-- BAR ATAS: JUMLAH & SEARCH -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Pilih MUA Terdaftar</h2>
                    <p class="text-sm text-gray-500 mt-1">
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
                            placeholder="Cari MUA berdasarkan nama usaha atau alamat..." class="w-full rounded-full border border-gray-300 bg-white/80 px-4 py-2.5 text-sm
                               outline-none focus:ring-2 focus:ring-[#f5d547] focus:border-[#eab308]">
                        <button type="submit" class="absolute right-1 top-1 bottom-1 px-4 rounded-full text-xs font-semibold
                               bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                               text-white shadow hover:brightness-105">
                            Cari
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">
                        Contoh: “Tafisha”, “Siak Kecil”, “Duri”, dll.
                    </p>
                </form>
            </div>

            {{-- LIST MUA --}}
            @if ($muas->isEmpty())
                <div class="border border-dashed border-gray-300 rounded-2xl py-10 px-4 text-center text-gray-500 text-sm">
                    Belum ada MUA yang mendaftar. Silakan kembali lagi nanti ya ✨
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($muas as $mua)
                        <a href="{{ route('public.mua.show', $mua->id) }}" class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden
                                       hover:shadow-xl hover:-translate-y-1 transition-transform duration-200 flex flex-col">
                            <!-- FOTO -->
                            <div class="relative">
                                <img src="{{ $mua->foto ? asset('storage/' . $mua->foto) : 'https://placehold.co/400x400?text=MUA' }}"
                                    alt="{{ $mua->nama_usaha }}" class="w-full h-56 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent
                                               opacity-0 group-hover:opacity-100 transition"></div>
                                <span class="absolute bottom-3 left-3 text-[11px] px-3 py-1 rounded-full
                                               bg-black/60 text-white backdrop-blur-sm">
                                    MUA Terdaftar
                                </span>
                            </div>

                            <!-- INFO -->
                            <div class="p-4 flex flex-col flex-1">
                                <h3
                                    class="text-base md:text-lg font-semibold text-gray-800 mb-1 truncate group-hover:text-[#c98a00]">
                                    {{ $mua->nama_usaha }}
                                </h3>

                                @if ($mua->deskripsi)
                                    <p class="text-xs text-gray-500 mb-2">
                                        {{ \Illuminate\Support\Str::limit($mua->deskripsi, 70) }}
                                    </p>
                                @endif

                                @if ($mua->alamat)
                                    <p class="text-xs text-gray-400 flex items-center gap-1 mb-3">
                                        <span>📍</span>
                                        <span class="truncate">{{ $mua->alamat }}</span>
                                    </p>
                                @endif

                                <div class="mt-auto flex items-center justify-between">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px]
                                                       bg-yellow-50 text-[#c98a00] border border-yellow-200">
                                            Makeup & Hairdo
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px]
                                                       bg-amber-50 text-amber-700 border border-amber-200">
                                            Baju Adat
                                        </span>
                                    </div>
                                    <span class="text-[11px] font-semibold text-[#c98a00] group-hover:underline">
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


    <!-- FOOTER -->
    <footer class="bg-[rgb(57,40,50)] text-[wheat] text-center py-6 mt-10">
        <p class="text-lg">&copy; 2025 AdatKu. All rights reserved.</p>
        <div class="flex justify-center mt-4 gap-4">
            <a href="#"><img src="{{ asset('ig.png') }}" alt="Instagram"
                    class="w-10 h-10 rounded-full hover:scale-110 transition"></a>
            <a href="#"><img src="{{ asset('fb.png') }}" alt="Facebook"
                    class="w-10 h-10 rounded-full hover:scale-110 transition"></a>
            <a href="#"><img src="{{ asset('wa.png') }}" alt="WhatsApp"
                    class="w-10 h-10 rounded-full hover:scale-110 transition"></a>
        </div>
    </footer>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>