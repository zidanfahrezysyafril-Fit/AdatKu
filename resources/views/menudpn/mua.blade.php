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
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff9fb;
            background-image:
                linear-gradient(135deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
                linear-gradient(225deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
                linear-gradient(315deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
                linear-gradient(45deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%);
            background-size: 24px 24px;
            background-position: 0 0, 0 12px, 12px -12px, -12px 0;
        }

        .logo-font {
            font-family: 'Perfecto Kaligrafi', 'Great Vibes', cursive;
        }
    </style>
</head>

<body class="bg-[rgba(255,242,213,0.08)] text-gray-900" x-data="{ open:false, profileModal:false, editModal:false }">

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
                        class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white px-5 py-2 rounded-full shadow-md hover:shadow-lg hover:brightness-105 transition">
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
                            class="hidden md:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-100 hover:bg-yellow-200 text-[#b48a00] font-semibold text-sm shadow-md">
                            📦 Pesanan Saya
                        </a>
                    @endif

                    {{-- dropdown user --}}
                    <div class="relative">
                        <button @click="open = !open"
                            class="w-11 h-11 rounded-full overflow-hidden border-2 border-[#f5d547] shadow focus:outline-none">
                            <img src="{{ $avatar }}" alt="Profile" class="w-full h-full object-cover"
                                onerror="this.onerror=null;this.src='{{ asset('default-avatar.png') }}'">
                        </button>

                        <div x-show="open" x-cloak x-transition @click.outside="open=false"
                            class="absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-lg ring-1 ring-black/5 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                            <ul class="py-1 text-sm">
                                <li>
                                    <button type="button" @click="profileModal = true; open=false"
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
    </header>

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
                </nav>

                <div class="border-t border-gray-200 pt-4 text-xs text-gray-500">
                    Tips: gunakan kolom pencarian di kanan untuk mencari berdasarkan
                    <span class="font-semibold">nama usaha</span> atau <span class="font-semibold">alamat</span>.
                </div>
            </div>
        </aside>

        <section class="flex-1 bg-white rounded-2xl shadow-md border border-gray-200 px-6 py-6 min-h-[300px]">
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
                        Contoh: “mytia”, “Siak Kecil”, “Duri”, dll.
                    </p>
                </form>
            </div>

            @if ($muas->isEmpty())
                <div class="border border-dashed border-gray-300 rounded-2xl py-10 px-4 text-center text-gray-500 text-sm">
                    Belum ada MUA yang mendaftar. Silakan kembali lagi nanti ya ✨
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($muas as $mua)
                        <a href="{{ route('public.mua.show', $mua->id) }}"
                            class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden
                                                               hover:shadow-xl hover:-translate-y-1 transition-transform duration-200 flex flex-col">

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
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px]
                                                                               bg-yellow-50 text-[#c98a00] border border-yellow-200">
                                            Makeup & Hairdo
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px]
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

    {{-- ================= MODAL PROFIL & EDIT ================= --}}
    @auth
        {{-- modal Profil Saya --}}
        <div x-show="profileModal" x-cloak x-transition.opacity
            class="fixed inset-0 z-[9998] flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div @click.outside="profileModal=false"
                class="bg-white rounded-3xl shadow-xl border border-yellow-200/70 w-[90%] max-w-xl p-7 relative">

                <button type="button" @click="profileModal=false"
                    class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500">
                    ✕
                </button>

                <h1 class="text-2xl md:text-3xl font-bold text-[#c98a00] mb-5">
                    Profil Saya
                </h1>

                <div class="relative flex flex-col sm:flex-row items-center gap-6">
                    <span class="hidden sm:block absolute -left-4 -top-4 text-yellow-200 text-3xl">❖</span>
                    <span class="hidden sm:block absolute -right-4 bottom-0 text-yellow-200 text-3xl rotate-45">✦</span>

                    <div
                        class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-[3px] border-[#f5d547] shadow-lg">
                        <img src="{{ $avatarUrl }}" alt="Foto Profil" class="object-cover w-full h-full">
                    </div>

                    <div class="text-center sm:text-left">
                        <p class="text-slate-600 text-xs sm:text-sm">Nama</p>
                        <p class="text-lg sm:text-xl font-semibold">{{ $user->name }}</p>

                        <p class="text-slate-600 text-xs sm:text-sm mt-3">Email</p>
                        <p class="text-sm sm:text-base font-medium break-all">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <button type="button" @click="profileModal=false"
                        class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-sm hover:bg-slate-200 transition">
                        Tutup
                    </button>

                    <button type="button" @click="profileModal=false; editModal=true" class="px-5 py-2 rounded-lg text-sm text-white shadow-md
                                   bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                   hover:opacity-90 transition">
                        Edit Profil
                    </button>
                </div>
            </div>
        </div>

        {{-- modal Edit Profil --}}
        <div x-show="editModal" x-cloak x-transition.opacity
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/45 backdrop-blur-sm">
            <div @click.outside="editModal=false" class="bg-white rounded-[32px] shadow-2xl border border-yellow-200/70
                            w-[92%] max-w-3xl p-8 md:p-10 relative">

                <button type="button" @click="editModal=false" class="absolute top-5 right-5 w-9 h-9 rounded-full bg-slate-100
                                 hover:bg-slate-200 flex items-center justify-center text-slate-500">
                    ✕
                </button>

                <span class="absolute -left-3 top-10 text-yellow-100 text-4xl">❋</span>
                <span class="absolute right-8 -bottom-3 text-yellow-100 text-4xl rotate-45">✦</span>

                <h2 class="text-3xl md:text-4xl font-bold text-[#c98a00] mb-7">
                    Edit Profil
                </h2>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col sm:flex-row items-center gap-6 md:gap-8">
                        <div class="relative flex items-center justify-center
                                  w-28 h-28 sm:w-32 sm:h-32
                                  rounded-full p-[3px]
                                  bg-gradient-to-br from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                  shadow-xl">
                            <div class="w-full h-full rounded-full overflow-hidden bg-slate-100">
                                <img src="{{ $avatarUrl }}" alt="Foto Profil" class="w-full h-full object-cover">
                            </div>
                            <span class="absolute -bottom-3 -right-1 text-yellow-100 text-2xl">❁</span>
                        </div>

                        <div class="w-full">
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Ganti Foto
                            </label>
                            <input type="file" name="profile" class="block w-full text-sm text-slate-600
                                      file:mr-3 file:rounded-lg file:px-4 file:py-2
                                      file:border file:border-yellow-200 file:bg-white
                                      file:text-slate-700 file:cursor-pointer
                                      hover:file:bg-yellow-50">
                            <p class="text-xs text-slate-500 mt-1">
                                jpg/jpeg/png, maks 2MB
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Nama
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3
                                    text-sm md:text-base
                                    focus:outline-none focus:ring-2 focus:ring-[#f5d547]
                                    focus:border-[#c98a00]">
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="editModal=false" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-sm md:text-base
                                     hover:bg-slate-200 transition">
                            Batal
                        </button>

                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm md:text-base text-white font-semibold shadow-md
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
        <div class="relative bg-gradient-to-br from-[#3b2128] via-[#4a2e38] to-[#351b27] text-[wheat] pt-10 pb-6 px-5">
            <div
                class="absolute inset-0 opacity-[0.09] bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]">
            </div>

            <div class="relative max-w-6xl mx-auto text-center">
                <h1
                    class="logo-font text-4xl bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent drop-shadow-[0_2px_6px_rgba(0,0,0,0.4)]">
                    AdatKu
                </h1>

                <p class="text-sm mt-2 text-[#f5e9df] max-w-xl mx-auto leading-relaxed">
                    Platform penyewaan MUA & busana adat untuk mempercantik acara istimewa kamu.
                    Budaya tetap hidup, tampil tetap elegan ✨
                </p>

                <div class="mt-4 flex justify-center gap-5 text-sm font-medium">
                    <a href="/" class="hover:text-[#f7e07b] transition">Beranda</a>
                    <a href="#" class="hover:text-[#f7e07b] transition">Tentang Kami</a>
                    <a href="{{ route('hubungikami') }}" class="hover:text-[#f7e07b] transition">Hubungi Kami</a>
                </div>

                <p class="mt-6 text-xs text-[#e2c9bf]">
                    &copy; 2025 <span class="font-semibold">AdatKu</span> — Semua Hak Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>