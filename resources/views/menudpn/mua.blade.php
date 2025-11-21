<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar MUA - AdatKu</title>

    {{-- FONTS & TAILWIND --}}
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
        z-index: 20;          /* biar di atas background */
        pointer-events: none;
    }

    .icon-md { font-size: 22px; }
    .icon-lg { font-size: 30px; }
    .icon-xl { font-size: 38px; }

    @keyframes float-up {
        0%   { transform: translateY(0);   opacity: 0; }
        10%  { opacity: 1; }
        100% { transform: translateY(-140vh); opacity: 0; }
    }

    .from-bottom {
        bottom: -10%;
        animation-name: float-up;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    @keyframes float-down {
        0%   { transform: translateY(0);   opacity: 0; }
        10%  { opacity: 1; }
        100% { transform: translateY(140vh); opacity: 0; }
    }

    .from-top {
        top: -10%;
        animation-name: float-down;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    /* animasi kartu kecil di banner */
    @keyframes soft-float {
        0% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
        100% { transform: translateY(0); }
    }
    .soft-float {
        animation: soft-float 5s ease-in-out infinite;
    }
</style>

</head>

<body class="bg-[rgba(255,242,213,0.08)] text-gray-900" x-data="{ open:false, profileModal:false, editModal:false }">

    {{-- HEADER --}}
    <header class="sticky top-0 z-40">
        <div class="backdrop-blur-md bg-white/90 border-b border-amber-100/70 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-3.5 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ url('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                            class="w-12 h-12 rounded-full object-cover shadow-md border border-amber-200">
                        <div class="leading-tight">
                            <h1
                                class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent tracking-wide">
                                AdatKu
                            </h1>
                            <p class="text-[11px] text-amber-800/80 hidden sm:block">
                                Sentuhan adat, pengalaman modern
                            </p>
                        </div>
                    </a>
                </div>

                <nav class="hidden md:flex items-center gap-6 text-[14px] font-medium text-[#b48a00]">
                    <a href="{{ url('home') }}" class="hover:text-[#eab308]">Beranda</a>
                    <a href="#" class="text-[#eab308] font-semibold border-b-2 border-[#eab308] pb-0.5">
                        Daftar MUA
                    </a>
                    <a href="{{ url('hubungikami') }}" class="hover:text-[#eab308]">Hubungi Kami</a>
                </nav>

                <div class="flex items-center gap-3">
                    @guest
                        <a href="{{ route('auth') }}"
                            class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                      text-white px-4 md:px-5 py-2 rounded-full shadow-md hover:shadow-lg hover:brightness-105 transition text-sm font-semibold">
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
                            <button @click="open = !open"
                                class="w-10 h-10 rounded-full overflow-hidden border-2 border-[#f5d547] shadow focus:outline-none">
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
        </div>
    </header>

    {{-- HERO KECIL / BANNER --}}
    <section class="bg-gradient-to-r from-[#fff7e1] via-[#f4d890] to-[#f1c25a] border-b border-amber-100/70">
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <p class="text-xs font-semibold text-amber-800/80 uppercase tracking-wide mb-1">
                    Daftar MUA Terdaftar
                </p>
                <h1 class="text-2xl md:text-3xl font-semibold text-[#5c2b33] mb-2">
                    Temukan MUA terbaik untuk acara adatmu
                </h1>
                <p class="text-sm md:text-[15px] text-amber-900/80 max-w-xl">
                    Pilih dari berbagai penyedia jasa rias, busana adat, dan paket lengkap
                    yang sudah bergabung di <span class="font-semibold">AdatKu</span>.
                </p>
            </div>

            <div class="soft-float">
                <div
                    class="bg-white/90 rounded-2xl shadow-lg border border-amber-100 px-5 py-4 flex items-center gap-4">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-[#f7e07b] via-[#eab308] to-[#c98a00] flex items-center justify-center text-white text-xl">
                        ✨
                    </div>
                    <div class="text-sm">
                        <p class="text-[11px] text-gray-500">MUA Terdaftar</p>
                        <p class="text-lg font-semibold text-amber-800">
                            {{ $muas->count() }} <span class="text-[12px] font-normal">MUA aktif</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- KONTEN UTAMA --}}
    <main class="max-w-7xl mx-auto px-6 py-10 flex flex-col lg:flex-row gap-7">

        {{-- SIDEBAR --}}
        <aside class="lg:w-64 w-full">
            <div class="bg-white shadow-md rounded-2xl border border-yellow-200/70 px-5 py-6 sticky top-24 space-y-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Filter & Info</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Gunakan pencarian dan kategori untuk menemukan MUA yang sesuai dengan kebutuhanmu.
                    </p>
                </div>

                <div class="space-y-2 text-xs">
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

                <div class="border-t border-gray-200 pt-4 text-xs text-gray-500 leading-relaxed">
                    Tips: kamu bisa mencari berdasarkan
                    <span class="font-semibold">nama usaha</span> atau
                    <span class="font-semibold">alamat</span> (contoh: “Duri”, “Siak Kecil”, “Bengkalis”).
                </div>
            </div>
        </aside>

        {{-- DAFTAR MUA --}}
        <section class="flex-1 bg-white rounded-2xl shadow-md border border-gray-200 px-6 py-6 min-h-[300px]">

            {{-- HEADER LIST + SEARCH --}}
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

            {{-- LIST / EMPTY STATE --}}
            @if ($muas->isEmpty())
                <div class="border border-dashed border-gray-300 rounded-2xl py-10 px-4 text-center text-gray-500 text-sm">
                    Belum ada MUA yang mendaftar di AdatKu.<br>
                    Silakan kembali lagi nanti ya ✨
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($muas as $mua)
                        <a href="{{ route('public.mua.show', $mua->id) }}"
                            class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden
                                          hover:shadow-xl hover:-translate-y-1 transition-transform duration-200 flex flex-col">

                            {{-- FOTO --}}
                            <div class="relative">
                                <img src="{{ $mua->foto ? asset('storage/' . $mua->foto) : 'https://placehold.co/400x400?text=MUA' }}"
                                    alt="{{ $mua->nama_usaha }}" class="w-full h-56 object-cover">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/15 to-transparent opacity-0 group-hover:opacity-100 transition">
                                </div>
                                <div class="absolute bottom-3 left-3 flex items-center gap-2 text-[11px]">
                                    <span class="px-3 py-1 rounded-full bg-black/60 text-white backdrop-blur-sm">
                                        MUA Terdaftar
                                    </span>
                                </div>
                            </div>

                            {{-- ISI CARD --}}
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

    {{-- ============ MODAL PROFIL & EDIT ============ --}}
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
    <footer class="mt-6">
        <div class="relative bg-gradient-to-br from-[#3b2128] via-[#4a2e38] to-[#351b27] text-[wheat] pt-10 pb-6 px-5">
            <div
                class="absolute inset-0 opacity-[0.09] bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]">
            </div>

            <div class="relative max-w-6xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 items-start">
                    {{-- Brand & intro --}}
                    <div>
                        <h1
                            class="logo-font text-4xl bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent drop-shadow-[0_2px_6px_rgba(0,0,0,0.4)]">
                            AdatKu
                        </h1>
                        <p class="text-sm mt-2 text-[#f5e9df] leading-relaxed">
                            Platform penyewaan MUA, busana adat, dan pelaminan untuk mempercantik acara istimewa kamu.
                            Budaya tetap hidup, tampilan tetap elegan ✨
                        </p>
                    </div>

                    {{-- Link cepat --}}
                    <div class="text-sm">
                        <h3 class="font-semibold text-[#f7e07b] mb-3">Navigasi</h3>
                        <ul class="space-y-1.5">
                            <li><a href="{{ route('home') }}" class="hover:text-[#f7e07b] transition">Beranda</a></li>
                            <li><a href="#tentang" class="hover:text-[#f7e07b] transition">Tentang AdatKu</a></li>
                            <li><a href="#galeri" class="hover:text-[#f7e07b] transition">Galeri</a></li>
                            <li><a href="#tim" class="hover:text-[#f7e07b] transition">Tim Pengembang</a></li>
                            <li><a href="{{ route('hubungikami') }}" class="hover:text-[#f7e07b] transition">Hubungi
                                    Kami</a></li>
                        </ul>
                    </div>

                    {{-- Kontak & kredit --}}
                    <div class="text-sm">
                        <h3 class="font-semibold text-[#f7e07b] mb-3">Kontak</h3>
                        <p class="text-[#f5e9df] text-[13px]">
                            Email: <a href="mailto:adatku11@gmail.com"
                                class="hover:text-[#f7e07b]">adatku11@gmail.com</a><br>
                            Instagram: <a href="https://www.instagram.com/_.adatku?igsh=Nm1mbWk2emx1cGZl"
                                target="_blank" class="hover:text-[#f7e07b]">@_.adatku</a>
                        </p>

                        <div class="mt-4 text-[11px] text-[#e2c9bf] leading-relaxed">
                            <p>Dikembangkan oleh:</p>
                            <p class="mt-1">
                                <span class="font-semibold">Zidan Fahrezy Syafril</span> (Koordinator & Fullstack)<br>
                                <span class="font-semibold">Cahyani Putri Sofari</span> (Frontend & Dokumentasi)<br>
                                <span class="font-semibold">Fetty Ratna Dewi</span> (Frontend & Dokumentasi)
                            </p>
                        </div>
                    </div>
                </div>

                <p class="mt-4 text-xs text-center text-[#e2c9bf] ">
                    Dikembangkan oleh
                    <span class="font-semibold">Zidan Fahrezy Syafril</span>,
                    <span class="font-semibold">Cahyani Putri Sofari</span>,
                    dan <span class="font-semibold">Fetty Ratna Dewi</span>.
                </p>
                <p class="mt-2 text-xs text-center text-[#f7e07b]">
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