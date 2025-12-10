<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AdatKu</title>

  {{-- Fonts & Tailwind --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    [x-cloak] {
      display: none !important;
    }

    html {
      scroll-behavior: smooth;
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

    @keyframes soft-float {
      0% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-10px);
      }

      100% {
        transform: translateY(0);
      }
    }

    .floating-badge {
      animation: soft-float 5s ease-in-out infinite;
    }

    @keyframes slide-gallery {

      0%,
      20% {
        transform: translateX(0);
      }

      25%,
      45% {
        transform: translateX(-25%);
      }

      50%,
      70% {
        transform: translateX(-50%);
      }

      75%,
      95% {
        transform: translateX(-75%);
      }

      100% {
        transform: translateX(0);
      }
    }

    .animate-gallery {
      animation: slide-gallery 16s infinite ease-in-out;
    }

    .text-justify {
      text-align: justify;
      text-justify: inter-word;
    }

    .floating-icon {
      position: fixed;
      font-weight: bold;
      color: rgba(255, 255, 255, 0.9);
      z-index: 30;
      pointer-events: none;
    }

    .icon-md {
      font-size: 22px;
    }

    .icon-lg {
      font-size: 30px;
    }

    .icon-xl {
      font-size: 38px;
    }

    @keyframes float-up {
      0% {
        transform: translateY(0);
        opacity: 0;
      }

      10% {
        opacity: 1;
      }

      100% {
        transform: translateY(-140vh);
        opacity: 0;
      }
    }

    .from-bottom {
      bottom: -10%;
      animation-name: float-up;
      animation-timing-function: linear;
      animation-iteration-count: infinite;
    }

    @keyframes float-down {
      0% {
        transform: translateY(0);
        opacity: 0;
      }

      10% {
        opacity: 1;
      }

      100% {
        transform: translateY(140vh);
        opacity: 0;
      }
    }

    .from-top {
      top: -10%;
      animation-name: float-down;
      animation-timing-function: linear;
      animation-iteration-count: infinite;
    }

    /* ANIMASI TOMBOL FLOATING CTA */
    @keyframes cta-pop {
      0% {
        opacity: 0;
        transform: translateY(30px) scale(0.9);
      }

      60% {
        opacity: 1;
        transform: translateY(-4px) scale(1.03);
      }

      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    @keyframes cta-glow {

      0%,
      100% {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.28);
      }

      50% {
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.40);
      }
    }

    .cta-mua-floating {
      animation:
        cta-pop 0.9s ease-out forwards,
        cta-glow 2.8s ease-in-out infinite;
      transform-origin: center;
    }
  </style>

</head>

<body class="text-gray-900" x-data="{
      navOpen:false,
      userMenuOpen:false,
      profileModal:false,
      editModal:false,
      applyMuaModal: {{ session('open_mua') ? 'true' : 'false' }},
      verifyModal: {{ (session('show_verify_modal') && auth()->check() && is_null(optional(auth()->user())->email_verified_at)) ? 'true' : 'false' }},
      mustVerifyEmail: {{ auth()->check() && is_null(optional(auth()->user())->email_verified_at) ? 'true' : 'false' }}
  }" x-cloak>

  {{-- FLASH MESSAGE --}}
  @if (session('success') || session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2600)" x-show="show" x-transition
      class="fixed left-1/2 -translate-x-1/2 top-6 z-[9999]">
      <div
        class="flex items-center gap-3 px-5 py-3 rounded-full shadow-xl text-[13px] md:text-[14px] font-medium text-white
                                                                    backdrop-blur-md border border-white/40
                                                                    @if (session('success')) bg-gradient-to-r from-[#f9e88b] via-[#eab308] to-[#c98a00]
                                                                    @else bg-gradient-to-r from-[#ef4444] via-[#dc2626] to-[#b91c1c] @endif">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          @if (session('success'))
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          @else
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          @endif
        </svg>
        <span>{{ session('success') ?? session('error') }}</span>
      </div>
    </div>
  @endif

  {{-- POPUP VERIFIKASI EMAIL (BISA DIPANGGIL KAPAN SAJA) --}}
  @auth
    @if (is_null(auth()->user()->email_verified_at))
      <div x-show="verifyModal" x-cloak x-transition.opacity
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div @click.outside="verifyModal = false" class="bg-[#fffdf7]/95 w-full max-w-lg mx-4 rounded-[28px]
                           shadow-[0_18px_55px_rgba(190,143,43,0.35)]
                           border border-[#f4ddab] px-6 py-7 md:px-8 md:py-8 relative">

          {{-- Tombol close kecil --}}
          <button type="button" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200
                             flex items-center justify-center text-slate-500 text-sm" @click="verifyModal = false">
            ✕
          </button>

          {{-- Logo --}}
          <div class="flex justify-center mb-4 mt-2">
            <div class="flex items-center justify-center w-28 h-10 rounded-full
                                  border border-[#f4c970] bg-white shadow-md">
              <img src="{{ asset('logos3.jpg') }}" class="h-8 object-contain" alt="AdatKu">
            </div>
          </div>

          <h1 class="text-center text-xl md:text-2xl font-bold text-[#d68e00] mb-2">
            Verifikasi Email Kamu Dulu, ya ✉️
          </h1>

          <p class="text-sm text-gray-700 leading-relaxed text-justify mb-3">
            Kami sudah mengirimkan link verifikasi ke alamat email:
            <span class="font-semibold text-[#c27b00]">{{ auth()->user()->email }}</span>.
            Silakan buka email tersebut, lalu klik tombol atau link
            <span class="font-semibold">"Verifikasi Email"</span>.
          </p>

          <p class="text-xs text-gray-500 mb-4 text-justify">
            Setelah terverifikasi, kamu bisa menggunakan fitur penting seperti pemesanan layanan
            dan pengajuan MUA. Belum menerima email? Coba cek folder
            <span class="font-semibold">Spam</span> atau <span class="font-semibold">Promosi</span>.
          </p>

          {{-- Form kirim ulang --}}
          <form method="POST" action="{{ route('verification.send') }}" class="space-y-3">
            @csrf
            <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-[#f5c052] to-[#d09212]
                               text-white font-semibold text-sm shadow-lg hover:brightness-110 transition">
              Kirim Ulang Email Verifikasi
            </button>
          </form>

          <div class="mt-4 flex items-center justify-between text-[12px] text-gray-700">
            <button type="button" class="text-[#b57400] hover:underline" @click="verifyModal = false">
              Nanti dulu
            </button>

            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="text-red-600 hover:underline">
                Ganti akun / logout
              </button>
            </form>
          </div>
        </div>
      </div>
    @endif
  @endauth

  {{-- HEADER --}}
  <header class="sticky top-0 z-40">
    <div class="backdrop-blur-md bg-white/80 border-b border-amber-100/60 shadow-sm">
      <div class="max-w-7xl mx-auto px-5 md:px-8 py-3.5 flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
          <div
            class="w-11 h-11 rounded-full bg-white flex items-center justify-center shadow-md border border-amber-200 overflow-hidden">
            <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu" class="w-full h-full object-cover">
          </div>
          <div class="leading-tight">
            <div
              class="logo-font text-2xl bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
              AdatKu
            </div>
            <p class="text-[11px] text-amber-700/80 hidden sm:block">
              Sentuhan adat, pengalaman modern
            </p>
          </div>
        </a>

        {{-- Nav desktop --}}
        <nav class="hidden md:flex items-center gap-6 text-[14px] font-medium text-amber-900/80">
          <a href="{{ route('home') }}" class="hover:text-amber-600 transition">Beranda</a>
          <a href="#tentang" class="hover:text-amber-600 transition">Tentang</a>
          <a href="#galeri" class="hover:text-amber-600 transition">Galeri</a>
          <a href="#tim" class="hover:text-amber-600 transition">Tim</a>
          <a href="#faq" class="hover:text-amber-600 transition">FAQ</a>
          <a href="{{ route('hubungikami') }}" class="hover:text-amber-600 transition">Hubungi Kami</a>

          @auth
            @php
              $navUser = auth()->user();
              $roleNavDesktop = strtolower($navUser->role ?? '');
            @endphp

            <a href="{{ route('public.mua.index') }}" class="hover:text-amber-600 transition">
              Daftar MUA
            </a>

            @if ($roleNavDesktop === 'mua')
              <a href="{{ route('mua.panel') }}" class="hover:text-amber-600 transition">
                Dashboard MUA
              </a>
            @elseif ($roleNavDesktop === 'admin')
              <a href="{{ route('dashboard_a') }}" class="hover:text-amber-600 transition">
                Dashboard Admin
              </a>
            @endif
          @endauth
        </nav>

        {{-- Aksi kanan --}}
        <div class="flex items-center gap-3">

          {{-- HAMBURGER (HANYA MOBILE) --}}
          <button @click="navOpen = true" class="md:hidden inline-flex items-center gap-2 px-3 py-2 rounded-full border border-amber-200/70 bg-white/80
             shadow-sm hover:bg-amber-50 hover:border-amber-300 transition text-xs md:text-sm text-amber-800">
            <span class="relative flex flex-col justify-between w-3.5 h-3">
              <span class="block h-[2px] rounded-full bg-amber-500"></span>
              <span class="block h-[2px] rounded-full bg-amber-400"></span>
              <span class="block h-[2px] rounded-full bg-amber-500 w-2/3 self-end"></span>
            </span>
            <span class="hidden sm:inline">Menu</span>
          </button>

          {{-- TOMBOL LOGIN (HANYA SAAT BELUM LOGIN) --}}
          @guest
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs sm:text-sm font-semibold
                                             bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] border border-amber-300 text-[white] shadow-sm
                                             hover:bg-amber-500 hover:brightness-105
                                                        transition text-sm font-semibold">
              Masuk
            </a>
          @endguest

          {{-- AVATAR / MENU USER (SETELAH LOGIN) --}}
          @auth
            @php
              $user = auth()->user();
              $avatar = $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png');
            @endphp

            @if (strtolower($user->role ?? '') === 'pengguna')
              <a href="{{ route('pengguna.pesanan.index') }}"
                class="hidden lg:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 hover:bg-amber-100 text-amber-800 text-xs font-semibold shadow-sm border border-amber-200 mr-2">
                📦 Pesanan Saya
              </a>
            @endif
            <div class="relative">
              {{-- Tombol avatar --}}
              <button @click="userMenuOpen = !userMenuOpen"
                class="w-10 h-10 rounded-full overflow-hidden border-2 border-amber-300 shadow focus:outline-none relative z-50">
                <img src="{{ $avatar }}" alt="Profile" class="w-full h-full object-cover"
                  onerror="this.onerror=null;this.src='{{ asset('default-avatar.png') }}'">
              </button>

              {{-- Dropdown user --}}
              <div x-show="userMenuOpen" x-transition.origin.top.right x-cloak @click.outside="userMenuOpen = false"
                class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-lg border border-amber-100/80 z-[80]">

                {{-- Header: nama & email --}}
                <div class="px-4 pt-3 pb-2 border-b border-slate-100">
                  <p class="text-sm font-semibold text-slate-800">
                    {{ $user->name }}
                  </p>
                  <p class="text-xs text-slate-500 truncate">
                    {{ $user->email }}
                  </p>
                </div>

                {{-- Item: Profil Saya --}}
                <button type="button" @click="userMenuOpen = false; profileModal = true"
                  class="w-full text-left px-4 py-2.5 text-sm text-slate-700 hover:bg-amber-50">
                  Profil Saya
                </button>

                {{-- Item: Logout --}}
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit"
                    class="w-full text-left px-4 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50">
                    Logout
                  </button>
                </form>
              </div>
            </div>
          @endauth
        </div>
      </div>
    </div>
  </header>

  {{-- ALERT EMAIL BELUM TERVERIFIKASI --}}
  @auth
    @if (is_null(auth()->user()->email_verified_at))
      <div class="bg-amber-50 border-b border-amber-200">
        <div
          class="max-w-7xl mx-auto px-5 md:px-8 py-2.5 flex flex-col md:flex-row md:items-center md:justify-between gap-2 text-xs md:text-sm text-amber-900">

          <div class="flex items-start gap-2">
            <div
              class="mt-[2px] inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 text-amber-700 text-sm">
              !
            </div>
            <p>
              <span class="font-semibold">Email kamu belum terverifikasi.</span><br class="hidden md:block">
              Cek inbox / folder spam untuk mencari email verifikasi dari <span class="font-semibold">AdatKu</span>.
              Kalau belum menerima, kamu bisa kirim ulang lewat tombol di samping.
            </p>
          </div>

          <form method="POST" action="{{ route('verification.send') }}" class="flex-shrink-0">
            @csrf
            <button type="submit"
              class="inline-flex items-center px-3 py-1.5 rounded-full bg-amber-600 text-white text-[11px] md:text-xs font-semibold shadow-sm hover:bg-amber-700 transition">
              Kirim Ulang Email Verifikasi
            </button>
          </form>
        </div>
      </div>
    @endif
  @endauth

  {{-- NAV DRAWER (SLIDE DARI KANAN, SMOOTH) --}}
  <div class="fixed inset-0 z-[9998] flex justify-end items-stretch transition-opacity duration-300" x-cloak
    :class="navOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'"
    @keydown.escape.window="navOpen = false">

    {{-- overlay --}}
    <div class="flex-1 h-full bg-black/40 backdrop-blur-sm" @click="navOpen = false"></div>

    {{-- PANEL KANAN --}}
    <div class="relative h-full w-[80%] max-w-xs sm:max-w-sm bg-white
                shadow-[0_0_40px_rgba(0,0,0,0.4)] border-l border-amber-100
                flex flex-col transform transition-transform duration-300 ease-out"
      :class="navOpen ? 'translate-x-0' : 'translate-x-full'">

      {{-- HEADER DRAWER --}}
      <div
        class="px-4 py-3 bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div
            class="w-9 h-9 rounded-full bg-white/95 flex items-center justify-center shadow-md border border-amber-100">
            <span class="logo-font text-xl text-[#c98a00]">A</span>
          </div>
          <div class="leading-tight text-white">
            <p class="text-[11px] uppercase tracking-[0.2em] opacity-90">Navigasi</p>
            <p class="text-sm font-semibold">AdatKu</p>
          </div>
        </div>

        <button type="button" @click="navOpen = false"
          class="w-8 h-8 rounded-full bg-white/95 flex items-center justify-center text-amber-700 shadow-sm hover:bg-amber-50">
          ✕
        </button>
      </div>

      {{-- MENU LIST --}}
      <div class="flex-1 overflow-y-auto px-4 py-3 text-sm text-slate-800 space-y-1">
        <button @click="navOpen = false; window.location='{{ route('home') }}'"
          class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
          <span class="text-lg">🏠</span><span>Beranda</span>
        </button>

        <button @click="navOpen = false; document.getElementById('tentang').scrollIntoView({behavior:'smooth'})"
          class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
          <span class="text-lg">📜</span><span>Tentang</span>
        </button>

        <button @click="navOpen = false; document.getElementById('galeri').scrollIntoView({behavior:'smooth'})"
          class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
          <span class="text-lg">🖼️</span><span>Galeri</span>
        </button>

        <button @click="navOpen = false; document.getElementById('tim').scrollIntoView({behavior:'smooth'})"
          class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
          <span class="text-lg">👥</span><span>Tim Pengembang</span>
        </button>

        {{-- FAQ MOBILE --}}
        <button @click="navOpen = false; document.getElementById('faq').scrollIntoView({behavior:'smooth'})"
          class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
          <span class="text-lg">❓</span><span>FAQ</span>
        </button>

        <button @click="navOpen = false; window.location='{{ route('hubungikami') }}'"
          class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
          <span class="text-lg">✉️</span><span>Hubungi Kami</span>
        </button>

        @auth
          @php
            $userNav = auth()->user();
            $roleNav = strtolower($userNav->role ?? '');
          @endphp

          <button @click="navOpen = false; window.location='{{ route('public.mua.index') }}'"
            class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
            <span class="text-lg">💄</span><span>Daftar MUA</span>
          </button>

          @if ($roleNav === 'pengguna')
            <button @click="navOpen = false; window.location='{{ route('pengguna.pesanan.index') }}'"
              class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
              <span class="text-lg">📦</span><span>Pesanan Saya</span>
            </button>
          @endif

          {{-- DASHBOARD SESUAI ROLE --}}
          @if ($roleNav === 'mua')
            <button @click="navOpen = false; window.location='{{ route('mua.panel') }}'"
              class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
              <span class="text-lg">📊</span><span>Dashboard MUA</span>
            </button>
          @elseif ($roleNav === 'admin')
            <button @click="navOpen = false; window.location='{{ route('dashboard_a') }}'"
              class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
              <span class="text-lg">🛡️</span><span>Dashboard Admin</span>
            </button>
          @endif

          <button @click="navOpen = false; profileModal = true"
            class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
            <span class="text-lg">👤</span><span>Profil Saya</span>
          </button>
        @endauth

      </div>

      {{-- CTA BAWAH DALAM DRAWER --}}
      @auth
        @php
          $userSheet = auth()->user();
          $isMuaSheet = strtolower($userSheet->role ?? '') === 'mua';
        @endphp

        @if (!$isMuaSheet)
          <div class="px-4 pb-4 pt-2 border-t border-amber-50 bg-amber-50/60">
            <button @click="
                            navOpen = false;
                            if (mustVerifyEmail) {
                              verifyModal = true;
                            } else {
                              applyMuaModal = true;
                            }
                          " class="w-full inline-flex items-center justify-center px-5 py-2.5 rounded-full text-sm font-semibold
                                 bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                 text-white shadow-md hover:brightness-110">
              Daftarkan jasa MUA kamu di sini
            </button>

          </div>
        @endif
      @else
        <div class="px-4 pb-4 pt-2 border-t border-amber-50 bg-amber-50/60">
          <button @click="navOpen = false; window.location='{{ route('login') }}'"
            class="w-full inline-flex items-center justify-center px-5 py-2.5 rounded-full text-sm font-semibold
                                                                               bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                                                               text-white shadow-md hover:brightness-110">
            Daftarkan jasa MUA kamu di sini
          </button>
        </div>
      @endauth
    </div>
  </div>

  {{-- HERO --}}
  <section class="relative overflow-hidden">
    <div class="relative h-[520px] md:h-[560px]">
      {{-- NOTE: pastikan nama file tidak ada spasi di folder public --}}
      <img src="{{ asset('logoss3 .jpg') }}" alt="AdatKu Hero" class="w-full h-full object-cover brightness-[0.55]">
      <div
        class="absolute inset-0 bg-gradient-to-br from-black/40 via-black/35 to-black/55 mix-blend-multiply pointer-events-none">
      </div>

      <div class="absolute inset-0 flex items-center">
        <div class="max-w-6xl mx-auto px-6 md:px-10 grid md:grid-cols-[1.4fr,1fr] gap-10 items-center">
          <div class="text-white">
            <p
              class="inline-flex items-center gap-2 text-xs md:text-sm px-3 py-1 rounded-full bg-white/15 border border-amber-200/50 mb-4">
              ✨ Platform penyewaan adat modern
            </p>
            <h1 class="text-3xl md:text-5xl font-semibold leading-tight mb-4">
              Rayakan momen adatmu
              <span class="logo-font text-4xl md:text-6xl block text-amber-300">dengan AdatKu</span>
            </h1>
            <p class="text-sm md:text-base text-amber-100/90 max-w-xl">
              Satu tempat untuk mencari MUA, busana adat, dan pelaminan pilihan.
              Proses mudah, tampilan tetap anggun dan penuh makna budaya.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
              <a href="{{ route('public.mua.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold
                       bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                       text-white shadow-lg hover:brightness-110 transition">
                Jelajahi MUA & Busana
              </a>

              @guest
                <a href="{{ route('login') }}"
                  class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-sm font-semibold
                                                                                     bg-white/10 border border-amber-200/60 text-amber-50 hover:bg-white/20 transition">
                  Masuk / Daftar
                </a>
              @endguest
            </div>
          </div>

          {{-- kartu info hero - DESKTOP --}}
          <div class="hidden md:block relative h-full">
            <div class="absolute top-10 right-0 w-[380px]
              bg-white/5 backdrop-blur-xl
              rounded-[32px] shadow-[0_18px_45px_rgba(0,0,0,0.55)]
              border border-amber-200/60 px-7 py-6
              floating-badge">

              <p class="text-[11px] font-semibold text-amber-300 mb-2 uppercase tracking-[0.18em]">
                Kenapa AdatKu?
              </p>

              <p class="text-sm text-slate-100 leading-relaxed mb-5">
                Kami membantu menghubungkanmu dengan penyedia jasa adat yang
                terpercaya di daerahmu, tanpa ribet dan tetap elegan.
              </p>

              <div class="grid grid-cols-4 gap-3 text-center text-sm">
                {{-- MUA --}}
                <div class="rounded-3xl bg-[#fff6dd] px-3 py-4 flex flex-col items-center justify-center
                  shadow-[0_10px_30px_rgba(248,220,140,0.45)]">
                  <span class="text-xl mb-1">✨</span>
                  <p class="text-2xl font-extrabold text-[#c98a00] mb-0.5">
                    +{{ $totalMua ?? 0 }}
                  </p>
                  <p class="text-[10px] font-semibold uppercase tracking-wide text-amber-800">
                    Mua Terdaftar
                  </p>
                </div>

                {{-- BUSANA --}}
                <div class="rounded-3xl bg-[#fff6dd] px-3 py-4 flex flex-col items-center justify-center
                  shadow-[0_10px_30px_rgba(248,220,140,0.45)]">
                  <span class="text-xl mb-1">👗</span>
                  <p class="text-2xl font-extrabold text-[#c98a00] mb-0.5">
                    +{{ $totalBusana ?? 0 }}
                  </p>
                  <p class="text-[10px] font-semibold uppercase tracking-wide text-amber-800">
                    Busana Adat
                  </p>
                </div>

                {{-- MAKEUP --}}
                <div class="rounded-3xl bg-[#fff6dd] px-3 py-4 flex flex-col items-center justify-center
                  shadow-[0_10px_30px_rgba(248,220,140,0.45)]">
                  <span class="text-xl mb-1">💄</span>
                  <p class="text-2xl font-extrabold text-[#c98a00] mb-0.5">
                    +{{ $totalMakeup ?? 0 }}
                  </p>
                  <p class="text-[10px] font-semibold uppercase tracking-wide text-amber-800">
                    Make Up
                  </p>
                </div>

                {{-- PELAMINAN --}}
                <div class="rounded-3xl bg-[#fff6dd] px-3 py-4 flex flex-col items-center justify-center
                  shadow-[0_10px_30px_rgba(248,220,140,0.45)]">
                  <span class="text-xl mb-1">💍</span>
                  <p class="text-2xl font-extrabold text-[#c98a00] mb-0.5">
                    +{{ $totalPelaminan ?? 0 }}
                  </p>
                  <p class="text-[10px] font-semibold uppercase tracking-wide text-amber-800">
                    Pelaminan
                  </p>
                </div>
              </div>

              <p class="mt-4 text-[10px] text-amber-200">
                *Data otomatis diambil dari sistem AdatKu dan bisa disesuaikan lewat dashboard admin.
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- KARTU STAT – MOBILE --}}
    <div class="md:hidden px-5 -mt-10 pb-4 relative z-20">
      <div class="mx-auto max-w-md bg-[#1f2933]/95 backdrop-blur-xl rounded-[28px] border border-amber-200/70
                shadow-[0_12px_40px_rgba(0,0,0,0.55)] px-5 py-5">
        <p class="text-[11px] font-semibold text-amber-300 mb-1 uppercase tracking-[0.18em]">
          Kenapa AdatKu?
        </p>
        <p class="text-[13px] text-slate-100 leading-relaxed mb-4">
          Kami membantu menghubungkanmu dengan penyedia jasa adat yang terpercaya di daerahmu, tanpa ribet dan tetap
          elegan.
        </p>

        <div class="grid grid-cols-2 gap-3 text-center text-sm">
          {{-- MUA --}}
          <div class="rounded-2xl bg-[#fff8dd] px-3 py-3 flex flex-col items-center justify-center
                    shadow-[0_8px_24px_rgba(248,220,140,0.5)]">
            <span class="text-lg mb-0.5">✨</span>
            <p class="text-xl font-extrabold text-[#c98a00]">
              +{{ $totalMua ?? 0 }}
            </p>
            <p class="text-[10px] font-semibold uppercase tracking-wide text-amber-800">
              Mua Terdaftar
            </p>
          </div>

          {{-- BUSANA --}}
          <div class="rounded-2xl bg-[#fff8dd] px-3 py-3 flex flex-col items-center justify-center
                    shadow-[0_8px_24px_rgba(248,220,140,0.5)]">
            <span class="text-lg mb-0.5">👗</span>
            <p class="text-xl font-extrabold text-[#c98a00]">
              +{{ $totalBusana ?? 0 }}
            </p>
            <p class="text-[10px] font-semibold uppercase tracking-wide text-amber-800">
              Busana Adat
            </p>
          </div>

          {{-- MAKEUP --}}
          <div class="rounded-2xl bg-[#fff8dd] px-3 py-3 flex flex-col items-center justify-center
                    shadow-[0_8px_24px_rgba(248,220,140,0.5)]">
            <span class="text-lg mb-0.5">💄</span>
            <p class="text-xl font-extrabold text-[#c98a00]">
              +{{ $totalMakeup ?? 0 }}
            </p>
            <p class="text-[10px] font-semibold uppercase tracking-wide text-amber-800">
              Make Up
            </p>
          </div>

          {{-- PELAMINAN --}}
          <div class="rounded-2xl bg-[#fff8dd] px-3 py-3 flex flex-col items-center justify-center
                    shadow-[0_8px_24px_rgba(248,220,140,0.5)]">
            <span class="text-lg mb-0.5">💍</span>
            <p class="text-xl font-extrabold text-[#c98a00]">
              +{{ $totalPelaminan ?? 0 }}
            </p>
            <p class="text-[10px] font-semibold uppercase tracking-wide text-amber-800">
              Pelaminan
            </p>
          </div>
        </div>

        <p class="mt-3 text-[10px] text-amber-200 text-center">
          *Data diambil otomatis dari sistem AdatKu.
        </p>
      </div>
    </div>
  </section>

  {{-- TENTANG ADATKU --}}
  <section id="tentang" class="max-w-5xl mx-auto px-6 md:px-10 py-14 scroll-mt-24 md:scroll-mt-32">
    <div class="text-center mb-7 items-center justify-center">
      <h2 class="logo-font text-4xl text-[#5c2b33] mb-2">Sekilas Tentang AdatKu</h2>
      <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto">
        AdatKu hadir sebagai jembatan antara tradisi dan teknologi,
        membuat pemesanan layanan adat menjadi lebih mudah, teratur, dan menyenangkan.
      </p>
    </div>
    <div
      class="bg-white/90 rounded-3xl shadow-md border border-amber-100/70 px-6 md:px-8 py-6 text-justify text-gray-700 leading-relaxed text-[14px] md:text-[15px]">
      AdatKu adalah platform berbasis website yang dirancang untuk membantu masyarakat dalam
      menemukan dan memesan layanan adat secara online. Mulai dari baju adat, jasa make up (MUA),
      hingga pelaminan, semua dikemas dalam satu sistem yang rapi dan mudah digunakan.
      <br><br>
      Dengan tampilan yang modern namun tetap membawa nuansa tradisional, AdatKu berupaya ikut
      melestarikan budaya Indonesia sekaligus memberikan pengalaman pemesanan yang praktis
      dan transparan bagi pengguna maupun penyedia jasa.
    </div>
  </section>


  {{-- KATEGORI LAYANAN --}}
  <section class="max-w-6xl mx-auto px-6 md:px-10 pb-16">
    <h2 class="text-center text-2xl md:text-3xl font-semibold text-[#5c2b33] mb-8">
      Layanan yang Tersedia di <span class="logo-font text-4xl text-amber-700">AdatKu</span>
    </h2>

    <div class="grid md:grid-cols-3 gap-6">
      {{-- Baju Adat --}}
      <div
        class="bg-white/95 rounded-3xl shadow hover:shadow-lg border border-amber-100/80 p-6 flex flex-col gap-3 transition-transform hover:-translate-y-1">
        <span class="text-3xl">👘</span>
        <h3 class="font-semibold text-lg text-amber-800">Baju Adat</h3>
        <p class="text-sm text-gray-600 text-justify">
          Pilihan busana adat dari berbagai daerah yang siap disewa untuk acara pernikahan, wisuda,
          hingga prosesi adat lainnya.
        </p>
      </div>

      {{-- Make Up --}}
      <div
        class="bg-white/95 rounded-3xl shadow hover:shadow-lg border border-amber-100/80 p-6 flex flex-col gap-3 transition-transform hover:-translate-y-1">
        <span class="text-3xl">💄</span>
        <h3 class="font-semibold text-lg text-amber-800">Make Up (MUA)</h3>
        <p class="text-sm text-gray-600 text-justify">
          MUA profesional yang memahami riasan adat maupun modern, siap membantu di hari spesialmu.
        </p>
      </div>

      {{-- Pelaminan --}}
      <div
        class="bg-white/95 rounded-3xl shadow hover:shadow-lg border border-amber-100/80 p-6 flex flex-col gap-3 transition-transform hover:-translate-y-1">
        <span class="text-3xl">💍</span>
        <h3 class="font-semibold text-lg text-amber-800">Pelaminan</h3>
        <p class="text-sm text-gray-600 text-justify">
          Berbagai dekorasi pelaminan bernuansa adat yang megah dan elegan, membuat momen akad dan resepsi
          terasa semakin sakral.
        </p>
      </div>
    </div>
  </section>

  {{-- GALERI --}}
  <section id="galeri" class="pb-20 scroll-mt-24 md:scroll-mt-32">
    <h2 class="text-center logo-font text-4xl text-[#5c2b33] mb-6">
      Galeri AdatKu
    </h2>

    <main class="space-y-16 max-w-6xl mx-auto px-6 md:px-10">

      {{-- Baju Adat --}}
      <section class="flex flex-col md:flex-row items-center gap-10">
        <div class="relative w-full md:w-[460px] h-[320px] overflow-hidden rounded-3xl shadow-lg">
          <div class="flex w-[400%] animate-gallery">
            @php
              $itemsBaju = $galleryBaju ?? collect();
            @endphp

            @if ($itemsBaju->isNotEmpty())
              @foreach ($itemsBaju as $item)
                <img src="{{ asset('storage/' . $item->image_path) }}" class="w-1/4 h-[320px] object-cover"
                  alt="{{ $item->judul }}">
              @endforeach
            @else
              <img src="{{ asset('bajuminang.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Baju Minang">
              <img src="{{ asset('bajumelayu.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Baju Melayu">
              <img src="{{ asset('bajujawa.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Baju Jawa">
              <img src="{{ asset('bajusunda.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Baju Sunda">
            @endif
          </div>
        </div>
        <div class="md:w-[420px]">
          <h3 class="logo-font text-3xl text-[#c98a00] mb-3 text-center md:text-left">Baju Adat</h3>
          <p class="text-sm md:text-base text-gray-600 text-justify leading-relaxed">
            Setiap baju adat menyimpan cerita dan makna filosofis. Melalui AdatKu,
            kamu dapat memilih busana adat yang sesuai dengan adat daerah dan konsep acaramu.
          </p>
        </div>
      </section>

      {{-- Make Up --}}
      <section class="flex flex-col md:flex-row-reverse items-center gap-10">
        <div class="relative w-full md:w-[460px] h-[320px] overflow-hidden rounded-3xl shadow-lg">
          <div class="flex w-[400%] animate-gallery">
            @php
              $itemsMakeup = $galleryMakeup ?? collect();
            @endphp

            @if ($itemsMakeup->isNotEmpty())
              @foreach ($itemsMakeup as $item)
                <img src="{{ asset('storage/' . $item->image_path) }}" class="w-1/4 h-[320px] object-cover"
                  alt="{{ $item->judul }}">
              @endforeach
            @else
              <img src="{{ asset('makeupjawa.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Makeup Jawa">
              <img src="{{ asset('makeupnikah.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Makeup Nikah">
              <img src="{{ asset('makeuplamaran.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Makeup Lamaran">
              <img src="{{ asset('makeupwisuda.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Makeup Wisuda">
            @endif
          </div>
        </div>
        <div class="md:w-[420px]">
          <h3 class="logo-font text-3xl text-[#c98a00] mb-3 text-center md:text-right">Make Up</h3>
          <p class="text-sm md:text-base text-gray-600 text-justify leading-relaxed">
            Riasan yang tepat dapat mempertegas karakter adat maupun modern.
            MUA di AdatKu siap menyesuaikan gaya rias dengan kebutuhan acara: lamaran, akad, resepsi, atau wisuda.
          </p>
        </div>
      </section>

      {{-- Pelaminan --}}
      <section class="flex flex-col md:flex-row items-center gap-10">
        <div class="relative w-full md:w-[460px] h-[320px] overflow-hidden rounded-3xl shadow-lg">
          <div class="flex w-[400%] animate-gallery">
            @php
              $itemsPelamin = $galleryPelaminan ?? collect();
            @endphp

            @if ($itemsPelamin->isNotEmpty())
              @foreach ($itemsPelamin as $item)
                <img src="{{ asset('storage/' . $item->image_path) }}" class="w-1/4 h-[320px] object-cover"
                  alt="{{ $item->judul }}">
              @endforeach
            @else
              <img src="{{ asset('pelamin1.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Pelamin 1">
              <img src="{{ asset('pelamin2.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Pelamin 2">
              <img src="{{ asset('pelamin3.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Pelamin 3">
              <img src="{{ asset('pelamin4.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Pelamin 4">
            @endif
          </div>
        </div>
        <div class="md:w-[420px]">
          <h3 class="logo-font text-3xl text-[#c98a00] mb-3 text-center md:text-left">Pelaminan</h3>
          <p class="text-sm md:text-base text-gray-600 text-justify leading-relaxed">
            Pelaminan menjadi pusat perhatian dalam sebuah pesta adat.
            Dengan pilihan dekorasi yang variatif, kamu bisa menyesuaikan tema pelaminan dengan adat dan selera pribadi.
          </p>
        </div>
      </section>
    </main>
  </section>

  {{-- TIM PENGEMBANG --}}
  <section id="tim" class="bg-white/70 border-y border-amber-100/60 py-14 scroll-mt-24 md:scroll-mt-32">
    <div class="max-w-6xl mx-auto px-6 md:px-10">
      <div class="text-center mb-8">
        <p class="text-xs font-semibold tracking-[0.2em] text-amber-700/80 uppercase mb-1">TIM PENGEMBANG</p>
        <h2 class="logo-font text-4xl text-[#5c2b33] mb-2">Di Balik AdatKu</h2>
        <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto">
          AdatKu dikembangkan oleh mahasiswa yang peduli pada pelestarian budaya dan kemudahan teknologi
          untuk masyarakat sekitar.
        </p>
      </div>

      @php
        $teamToShow = $team ?? collect();

        if ($teamToShow->isEmpty()) {
          $teamToShow = collect([
            (object) [
              'name' => 'Cahyani Putri Sofari',
              'role' => 'Frontend & Dokumentasi',
              'division' => 'UI/UX & Penulisan Laporan',
              'photo' => null,
            ],
            (object) [
              'name' => 'Zidan Fahrezy Syafril',
              'role' => 'Koordinator & Fullstack Developer',
              'division' => 'Database & Integrasi Sistem',
              'photo' => null,
            ],
            (object) [
              'name' => 'Fetty Ratna Dewi',
              'role' => 'Frontend & Dokumentasi',
              'division' => 'UI/UX & Penulisan Laporan',
              'photo' => null,
            ],
          ]);
        }
      @endphp

      <div class="grid md:grid-cols-3 gap-6 md:gap-8 items-stretch">
        @foreach ($teamToShow as $index => $member)
          @php
            $isCenter = $loop->count >= 3 && $loop->iteration == 2;
            $photoUrl = $member->photo
              ? asset('storage/' . $member->photo)
              : 'https://placehold.co/600x400?text=Tim';
          @endphp

          <div
            class="bg-white rounded-3xl border px-5 md:px-6 pt-5 pb-6 md:pb-7 flex flex-col
                                                                        {{ $isCenter ? 'shadow-lg border-amber-200 md:scale-105 md:-translate-y-2' : 'shadow-md border-amber-100/80' }}">
            <div class="w-full h-40 md:h-48 rounded-2xl overflow-hidden mb-4 border border-amber-100/70 bg-slate-100">
              <img src="{{ $photoUrl }}" alt="{{ $member->name }}" class="w-full h-full object-cover"
                onerror="this.onerror=null;this.src='https://placehold.co/600x400?text=Tim';">
            </div>

            <div class="flex-1 flex flex-col items-center text-center">
              <h3 class="font-semibold text-amber-800 text-sm md:text-base">
                {{ $member->name }}
              </h3>

              @if (!empty($member->role))
                <p class="text-[12px] text-gray-500 mt-1">
                  {{ $member->role }}
                </p>
              @endif

              @if (!empty($member->division))
                <p class="text-[12px] text-gray-500 mt-1">
                  {{ $member->division }}
                </p>
              @endif
            </div>
          </div>
        @endforeach
      </div>

      <p class="text-[11px] text-center text-gray-500 mt-5">
        *Tim Pengembang di Balik website Adatku✨.
      </p>
    </div>
  </section>

  {{-- CTA STRIP --}}
  <section class="py-10">
    <div class="max-w-6xl mx-auto px-6 md:px-10 py-7 rounded-3xl bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
             shadow-lg flex flex-col md:flex-row items-center justify-between gap-4">
      <div>
        <p class="text-xs font-semibold tracking-[0.18em] text-white/80 uppercase mb-1">SIAP MULAI?</p>
        <h3 class="text-lg md:text-2xl font-semibold text-white">
          Mulai kelola pemesanan adatmu dengan AdatKu sekarang.
        </h3>
        <p class="text-[13px] md:text-sm text-white/90 mt-1">
          Daftarkan jasa MUA, busana adat, atau pelaminanmu dan jangkau lebih banyak pelanggan lokal.
        </p>
      </div>
      <div class="flex flex-wrap gap-3">
        @auth
          <button type="button" @click="
                      if (mustVerifyEmail) {
                        verifyModal = true;
                      } else {
                        window.location = '{{ route('mua.entry') }}';
                      }
                    "
            class="inline-flex items-center px-4 py-2.5 rounded-full text-sm font-semibold bg-white text-[#c98a00] shadow-md hover:bg-amber-50">
            Daftarkan Jasa Sekarang
          </button>
        @else
          <a href="{{ route('login') }}"
            class="inline-flex items-center px-4 py-2.5 rounded-full text-sm font-semibold bg-white text-[#c98a00] shadow-md hover:bg-amber-50">
            Daftarkan Jasa Sekarang
          </a>
        @endauth

        <a href="{{ route('hubungikami') }}"
          class="inline-flex items-center px-4 py-2.5 rounded-full text-sm font-semibold border border-white/70 text-white hover:bg-white/10">
          Tanya Tim AdatKu
        </a>
      </div>
    </div>
  </section>

  {{-- MODAL PROFIL & EDIT --}}
  @auth
    @php
      $user = auth()->user();
      $avatarUrl = ($user->avatar ?? null)
        ? asset('storage/' . $user->avatar)
        : 'https://placehold.co/300x300?text=Profile';
    @endphp

    {{-- Modal Profil --}}
    <div x-show="profileModal" x-cloak x-transition.opacity
      class="fixed inset-0 z-[9998] flex items-center justify-center bg-black/40 backdrop-blur-sm">
      <div @click.outside="profileModal=false"
        class="bg-white rounded-3xl shadow-xl border border-amber-100 w-[90%] max-w-xl p-7 relative">
        <button type="button" @click="profileModal=false"
          class="absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500">
          ✕
        </button>

        <h1 class="text-2xl md:text-3xl font-bold text-[#c98a00] mb-5">
          Profil Saya
        </h1>

        <div class="flex flex-col sm:flex-row items-center gap-6">
          <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-[3px] border-[#f5d547] shadow-lg">
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

    {{-- Modal Edit Profil --}}
    <div x-show="editModal" x-cloak x-transition.opacity
      class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/45 backdrop-blur-sm">
      <div @click.outside="editModal = false" class="bg-white rounded-[32px] shadow-2xl border border-amber-100
                                                                           w-[92%] max-w-3xl p-8 md:p-10 relative">

        <button type="button" @click="editModal = false"
          class="absolute top-5 right-5 w-9 h-9 rounded-full bg-slate-100
                                                                             hover:bg-slate-200 flex items-center justify-center text-slate-500">
          ✕
        </button>

        <h2 class="text-3xl md:text-4xl font-bold text-[#c98a00] mb-7">
          Edit Profil
        </h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @method('PUT')

          <div class="flex flex-col sm:flex-row items-center gap-6 md:gap-8">
            <div class="relative flex items-center justify-center w-28 h-28 sm:w-32 sm:h-32
                                                                                 rounded-full p-[3px]
                                                                                 bg-gradient-to-br from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                                                                 shadow-xl">
              <div class="w-full h-full rounded-full overflow-hidden bg-slate-100">
                <img src="{{ $avatarUrl }}" alt="Foto Profil" class="w-full h-full object-cover">
              </div>
            </div>

            <div class="w-full">
              <label class="block text-sm font-medium text-slate-700 mb-1">
                Ganti Foto
              </label>
              <input type="file" name="profile" class="block w-full text-sm text-slate-600
                                                                                   file:mr-3 file:rounded-lg file:px-4 file:py-2
                                                                                   file:border file:border-amber-200 file:bg-white
                                                                                   file:text-slate-700 file:cursor-pointer
                                                                                   hover:file:bg-amber-50">
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
            <button type="button" @click="editModal = false" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-sm md:text-base
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

  {{-- MODAL AJUKAN SEBAGAI MUA --}}
  @auth
    @php
      $requestMua = $requestMua ?? null;
      $userForRequest = $user ?? Auth::user();
      $isMuaReq = strtolower($userForRequest->role ?? '') === 'mua';
      $isDisabledReq = $isMuaReq ? 'disabled' : '';
    @endphp

    <div x-show="applyMuaModal" x-cloak x-transition.opacity
      class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/45 backdrop-blur-sm">
      <div @click.outside="applyMuaModal = false"
        class="bg-white rounded-[28px] shadow-2xl border border-amber-100
                                                                           w-[92%] max-w-2xl max-h-[90vh] overflow-y-auto p-6 md:p-8 relative">

        <button type="button" @click="applyMuaModal = false"
          class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-100
                                                                             hover:bg-slate-200 flex items-center justify-center text-slate-500">
          ✕
        </button>

        <h1 class="text-2xl md:text-3xl font-bold text-amber-500 mb-4">
          Ajukan Sebagai MUA
        </h1>

        @if (session('success'))
          <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm">
            {{ session('success') }}
          </div>
        @endif

        @if (session('error'))
          <div class="mb-4 px-4 py-3 rounded-xl bg-rose-50 text-rose-700 text-sm">
            {{ session('error') }}
          </div>
        @endif

        @if ($requestMua)
          <div class="mb-6 bg-white rounded-2xl shadow border border-amber-100 p-4 text-sm">
            <p class="font-semibold text-slate-700">Status pengajuan kamu:</p>
            <p class="mt-1">
              <span class="font-bold capitalize">{{ $requestMua->status }}</span>
              @if ($requestMua->catatan_admin)
                - <span class="text-slate-600">{{ $requestMua->catatan_admin }}</span>
              @endif
            </p>
          </div>
        @endif

        <form action="{{ route('mua.request.store') }}" method="POST"
          class="bg-white rounded-2xl shadow p-6 space-y-4 border border-rose-100">
          @csrf

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Usaha / Studio</label>
            <input type="text" name="nama_usaha" {{ $isDisabledReq }}
              value="{{ old('nama_usaha', $requestMua->nama_usaha ?? '') }}"
              class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMuaReq) bg-slate-100 cursor-not-allowed @endif">
            @error('nama_usaha')
              <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kontak WhatsApp</label>

            @php
              // ambil nilai lama / dari pengajuan yang sudah ada
              $rawWa = old('kontak_wa', $requestMua->kontak_wa ?? '');
              $digits = preg_replace('/\D/', '', $rawWa);   // buang selain angka

              $waWithoutPrefix = '';

              if ($digits !== '') {
                if ($digits[0] === '0') {
                  // kalau tersimpan 08... -> tampilkan tanpa 0 di depan
                  $waWithoutPrefix = substr($digits, 1);
                } elseif (substr($digits, 0, 2) === '62') {
                  // kalau tersimpan 62... -> tampilkan tanpa 62
                  $waWithoutPrefix = substr($digits, 2);
                } else {
                  // kasus lain: langsung pakai
                  $waWithoutPrefix = $digits;
                }
              }
            @endphp

            <div class="flex gap-2">
              {{-- prefix bendera +62 --}}
              <div class="inline-flex items-center rounded-xl border border-rose-100 bg-rose-50/60 px-3">
                <span class="text-lg mr-1">🇮🇩</span>
                <span class="text-sm font-semibold text-slate-700">+62</span>
              </div>

              {{-- input angka belakangnya saja --}}
              <input type="tel" name="kontak_wa" {{ $isDisabledReq }} value="{{ $waWithoutPrefix }}"
                class="flex-1 border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMuaReq) bg-slate-100 cursor-not-allowed @endif"
                placeholder="81234567890" inputmode="numeric" pattern="[0-9]{8,13}">
            </div>
            @error('kontak_wa')
              <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
            <textarea name="alamat" rows="2" {{ $isDisabledReq }}
              class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMuaReq) bg-slate-100 cursor-not-allowed @endif">{{ old('alamat', $requestMua->alamat ?? '') }}</textarea>
            @error('alamat')
              <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Usaha</label>
            <textarea name="deskripsi" rows="3" {{ $isDisabledReq }}
              class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMuaReq) bg-slate-100 cursor-not-allowed @endif">{{ old('deskripsi', $requestMua->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
              <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Instagram (opsional)</label>
              <input type="text" name="instagram" {{ $isDisabledReq }}
                value="{{ old('instagram', $requestMua->instagram ?? '') }}"
                class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMuaReq) bg-slate-100 cursor-not-allowed @endif">
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">TikTok (opsional)</label>
              <input type="text" name="tiktok" {{ $isDisabledReq }} value="{{ old('tiktok', $requestMua->tiktok ?? '') }}"
                class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMuaReq) bg-slate-100 cursor-not-allowed @endif">
            </div>
          </div>

          @if ($isMuaReq)
            <div class="mt-6 text-center">
              <a href="{{ route('mua.panel') }}"
                class="inline-block px-5 py-2.5 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm font-semibold">
                ← Kembali
              </a>
            </div>
          @else
            {{-- TOMBOL AKSI RESPONSIVE --}}
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">

              {{-- tombol kirim --}}
              <button type="submit" class="w-full sm:w-auto px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white
                                                               font-semibold text-sm shadow-md">
                Kirim Pengajuan
              </button>

              {{-- tombol kembali --}}
              <button type="button" @click="applyMuaModal = false" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300
                                                               text-sm font-semibold">
                ← Kembali
              </button>
            </div>
          @endif
        </form>
      </div>
    </div>
  @endauth

  {{-- FAQ --}}
  <section id="faq" class="max-w-6xl mx-auto px-6 md:px-10 py-14">
    <div class="text-center mb-5">
      <p class="text-xs font-semibold tracking-[0.2em] text-amber-700/80 uppercase mb-1">
        FAQ ADATKU
      </p>
      <h2 class="logo-font text-4xl text-[#5c2b33] mb-2">
        Pertanyaan yang Sering Diajukan
      </h2>
      <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto">
        Masih bingung cara pakainya? Berikut beberapa pertanyaan yang sering ditanyain
        seputar pemesanan di AdatKu.
      </p>
    </div>

    <div x-data="{ open: 1 }" class="space-y-3">
      {{-- Q1 --}}
      <div class="bg-white/95 rounded-2xl border border-amber-100/80 shadow-sm overflow-hidden">
        <button type="button" class="w-full flex items-center justify-between gap-3 px-5 md:px-6 py-4 text-left"
          @click="open = open === 1 ? null : 1">
          <div>
            <p class="text-sm md:text-base font-semibold text-[#5c2b33]">
              Bagaimana cara memesan layanan di AdatKu?
            </p>
            <p class="text-[11px] text-amber-600 uppercase tracking-[0.18em]">
              PEMESANAN LAYANAN
            </p>
          </div>
          <span class="text-amber-600 text-xl" x-text="open === 1 ? '−' : '+'"></span>
        </button>
        <div x-show="open === 1" x-collapse class="px-5 md:px-6 pb-4 text-sm text-gray-600 leading-relaxed">
          1. Pilih <span class="font-semibold">MUA / layanan</span> yang kamu suka di menu Daftar MUA. <br>
          2. Klik <span class="font-semibold">“Keranjang”</span> atau <span class="font-semibold">“Pesan Layanan
            Ini”</span>. <br>
          3. Isi detail pesanan di halaman keranjang, lalu konfirmasi pemesanan. <br>
          4. Kamu juga bisa menghubungi MUA lewat tombol <span class="font-semibold">WhatsApp</span> untuk finalisasi.
        </div>
      </div>

      {{-- Q2 --}}
      <div class="bg-white/95 rounded-2xl border border-amber-100/80 shadow-sm overflow-hidden">
        <button type="button" class="w-full flex items-center justify-between gap-3 px-5 md:px-6 py-4 text-left"
          @click="open = open === 2 ? null : 2">
          <div>
            <p class="text-sm md:text-base font-semibold text-[#5c2b33]">
              Apakah harus punya akun untuk memesan?
            </p>
            <p class="text-[11px] text-amber-600 uppercase tracking-[0.18em]">
              AKUN PENGGUNA
            </p>
          </div>
          <span class="text-amber-600 text-xl" x-text="open === 2 ? '−' : '+'"></span>
        </button>
        <div x-show="open === 2" x-collapse class="px-5 md:px-6 pb-4 text-sm text-gray-600 leading-relaxed">
          Iya, kamu perlu <span class="font-semibold">mendaftar / login</span> dulu supaya data pesananmu
          bisa tercatat dengan rapi dan riwayat pemesanan dapat kamu lihat di menu
          <span class="font-semibold">“Pesanan Saya”</span>.
        </div>
      </div>

      {{-- Q3 --}}
      <div class="bg-white/95 rounded-2xl border border-amber-100/80 shadow-sm overflow-hidden">
        <button type="button" class="w-full flex items-center justify-between gap-3 px-5 md:px-6 py-4 text-left"
          @click="open = open === 3 ? null : 3">
          <div>
            <p class="text-sm md:text-base font-semibold text-[#5c2b33]">
              Pembayarannya lewat AdatKu atau langsung ke MUA?
            </p>
            <p class="text-[11px] text-amber-600 uppercase tracking-[0.18em]">
              PEMBAYARAN
            </p>
          </div>
          <span class="text-amber-600 text-xl" x-text="open === 3 ? '−' : '+'"></span>
        </button>
        <div x-show="open === 3" x-collapse class="px-5 md:px-6 pb-4 text-sm text-gray-600 leading-relaxed">
          Saat ini sistem AdatKu fokus sebagai <span class="font-semibold">platform penghubung</span>.
          Detail pembayaran (DP, pelunasan, dan lain-lain) akan disepakati
          langsung antara kamu dan pihak MUA / penyedia jasa melalui WhatsApp.
        </div>
      </div>

      {{-- Q4 --}}
      <div class="bg-white/95 rounded-2xl border border-amber-100/80 shadow-sm overflow-hidden">
        <button type="button" class="w-full flex items-center justify-between gap-3 px-5 md:px-6 py-4 text-left"
          @click="open = open === 4 ? null : 4">
          <div>
            <p class="text-sm md:text-base font-semibold text-[#5c2b33]">
              Apakah AdatKu punya jasa sendiri atau hanya penghubung?
            </p>
            <p class="text-[11px] text-amber-600 uppercase tracking-[0.18em]">
              TENTANG PLATFORM
            </p>
          </div>
          <span class="text-amber-600 text-xl" x-text="open === 4 ? '−' : '+'"></span>
        </button>
        <div x-show="open === 4" x-collapse class="px-5 md:px-6 pb-4 text-sm text-gray-600 leading-relaxed">
          AdatKu berperan sebagai <span class="font-semibold">platform penghubung</span> antara pengguna
          dan penyedia jasa (MUA, busana adat, pelaminan). Tim AdatKu membantu
          mengkurasi dan mengelola data penyedia jasa supaya kamu lebih mudah
          menemukan layanan yang tepat.
        </div>
      </div>

      {{-- Q5 --}}
      <div class="bg-white/95 rounded-2xl border border-amber-100/80 shadow-sm overflow-hidden">
        <button type="button" class="w-full flex items-center justify-between gap-3 px-5 md:px-6 py-4 text-left"
          @click="open = open === 5 ? null : 5">
          <div>
            <p class="text-sm md:text-base font-semibold text-[#5c2b33]">
              Kenapa saya tidak menerima email ganti password?
            </p>
            <p class="text-[11px] text-amber-600 uppercase tracking-[0.18em]">
              RESET PASSWORD
            </p>
          </div>
          <span class="text-amber-600 text-xl" x-text="open === 5 ? '−' : '+'"></span>
        </button>
        <div x-show="open === 5" x-collapse class="px-5 md:px-6 pb-4 text-sm text-gray-600 leading-relaxed">
          Untuk mendapatkan email ganti password, kamu harus memastikan
          <span class="font-semibold">alamat email yang dimasukkan adalah email yang benar-benar terdaftar di
            Google</span>.
          <br><br>
          Jika kamu registrasi akun secara manual (tanpa login menggunakan Google),
          kamu dapat menghubungi admin website AdatKu melalui menu
          <span class="font-semibold">Hubungi Kami</span> untuk meminta pergantian password.
          Dengan catatan, alamat email yang kamu kirim ke admin harus
          <span class="font-semibold">email yang terdaftar di Google</span>
          agar pesan kamu bisa terkirim dengan baik.
          <br><br>
          Setelah itu, silakan tunggu email dari admin AdatKu berisi
          <span class="font-semibold">password barumu</span>.
        </div>
      </div>

      {{-- Q6 --}}
      <div class="bg-white/95 rounded-2xl border border-amber-100/80 shadow-sm overflow-hidden">
        <button type="button" class="w-full flex items-center justify-between gap-3 px-5 md:px-6 py-4 text-left"
          @click="open = open === 6 ? null : 6">
          <div>
            <p class="text-sm md:text-base font-semibold text-[#5c2b33]">
              Kenapa email Verifikasi tidak terkirim ke email saya?
            </p>
            <p class="text-[11px] text-amber-600 uppercase tracking-[0.18em]">
              Email VERIFIKASI
            </p>
          </div>
          <span class="text-amber-600 text-xl" x-text="open === 6 ? '−' : '+'"></span>
        </button>
        <div x-show="open === 6" x-collapse class="px-5 md:px-6 pb-4 text-sm text-gray-600 leading-relaxed">
          Untuk mendapatkan <span class="font-semibold">Email verifikasi</span> pastikan Email yang kamu
          terdaftar di Google dan verifikasi email kamu sudah dikonfirmasi.
                  <br><br>
                  Jika sudah memastikan hal tersebut, silakan klik tombol
                  <span class="font-semibold">"Kirim Ulang Email Verifikasi"</span>
                  di bagian atas halaman dan jika tidak bisa juga terkirim emailnya kamu dapat hubungi admin melalui menu
                  <span class="font-semibold">Hubungi Kami</span>. 
        </div>
      </div>
    </div>
  </section>

  {{-- FOOTER --}}
  <footer class="mt-10">
    <div class="relative bg-gradient-to-br from-[#3b2128] via-[#4a2e38] to-[#351b27] text-[wheat] pt-12 pb-8 px-5">

      {{-- TEXTURE --}}
      <div
        class="absolute inset-0 opacity-[0.08] bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')]">
      </div>

      <div class="relative max-w-7xl mx-auto">
        <div class="grid md:grid-cols-4 gap-10">

          {{-- BRAND --}}
          <div>
            <h1 class="logo-font text-4xl bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                        bg-clip-text text-transparent drop-shadow">
              AdatKu
            </h1>

            <p class="text-sm mt-3 text-[#f5e9df] leading-relaxed">
              Platform penyewaan MUA, busana adat, dan pelaminan untuk mempercantik acara istimewa kamu.
              Budaya tetap hidup, tampilan tetap elegan ✨
            </p>

            {{-- SOCIAL MEDIA --}}
            <div class="flex items-center gap-3 mt-4">
              <a href="https://www.instagram.com/_.adatku" target="_blank"
                class="w-24 h-6 rounded-full bg-[#c98a00]/20 flex items-center justify-center text-[#f7e07b] hover:bg-[#c98a00]/30">
                Instagram
              </a>
              <a href="mailto:adatku11@gmail.com"
                class="w-24 h-6 rounded-full bg-[#c98a00]/20 flex items-center justify-center text-[#f7e07b] hover:bg-[#c98a00]/30">
                adatku11
              </a>
            </div>
          </div>

          {{-- NAVIGASI --}}
          <div class="text-sm">
            <h3 class="font-semibold text-[#f7e07b] mb-3">Navigasi</h3>
            <ul class="space-y-2">
              <li><a href="{{ route('home') }}" class="hover:text-[#f7e07b] transition">Beranda</a></li>
              <li><a href="#tentang" class="hover:text-[#f7e07b] transition">Tentang AdatKu</a></li>
              <li><a href="#galeri" class="hover:text-[#f7e07b] transition">Galeri</a></li>
              <li><a href="#tim" class="hover:text-[#f7e07b] transition">Tim Pengembang</a></li>
              <li><a href="{{ route('hubungikami') }}" class="hover:text-[#f7e07b] transition">Hubungi
                  Kami</a></li>
              <li><a href="{{ route('mua.entry') }}" class="hover:text-[#f7e07b] transition">Daftar Jadi
                  MUA</a></li>
            </ul>
          </div>

          {{-- INFO & OPERASIONAL --}}
          <div class="text-sm">
            <h3 class="font-semibold text-[#f7e07b] mb-3">Informasi</h3>
            <p class="text-[#f5e9df] text-[13px] leading-relaxed">
              📍 Bengkalis, Riau, Indonesia<br>
              ⏰ Layanan: 08:00 — 23:00<br>
              💬 WhatsApp: <a href="https://wa.me/6282284886932" target="_blank"
                class="hover:text-[#f7e07b]">082284886932</a>
            </p>

            <div class="mt-4 text-[12px] space-y-1">
              <a href="#" class="hover:text-[#f7e07b]">Kebijakan Privasi</a><br>
              <a href="#" class="hover:text-[#f7e07b]">Syarat & Ketentuan</a>
            </div>
          </div>

          {{-- DEVELOPER --}}
          <div class="text-sm">
            <h3 class="font-semibold text-[#f7e07b] mb-3">Dikembangkan oleh</h3>
            <p class="text-[13px] text-[#e2c9bf] leading-relaxed">
              <span class="font-semibold">Zidan Fahrezy Syafril</span> — Fullstack & Koordinator<br>
              <span class="font-semibold">Cahyani Putri Sofari</span> — Frontend & Dokumentasi<br>
              <span class="font-semibold">Fetty Ratna Dewi</span> — Frontend & Dokumentasi
            </p>

            <p class="mt-3 text-[11px] text-[#c9b3aa]">
              Versi Platform: 1.0.0<br>
              Dibuat dengan ❤️ oleh Team 3
            </p>
          </div>
        </div>

        {{-- COPYRIGHT --}}
        <p class="mt-8 text-xs text-center text-[#f7e07b] opacity-90">
          &copy; 2025 <span class="font-semibold">AdatKu</span> — Semua Hak Dilindungi.
        </p>
      </div>
    </div>
  </footer>

  {{-- FLOATING CTA: Daftarkan jasa MUA (pojok kiri bawah, hanya desktop) --}}
  @auth
    @php
      $userFloat = auth()->user();
      $isMuaFloat = strtolower($userFloat->role ?? '') === 'mua';
    @endphp

    @if (!$isMuaFloat)
      <button type="button" @click="
                      if (mustVerifyEmail) {
                        verifyModal = true;
                      } else {
                        applyMuaModal = true;
                      }
                    " class="hidden md:inline-flex fixed bottom-6 left-6 z-[60]
                           items-center justify-center px-6 py-2.5 rounded-full
                           text-sm font-semibold
                           bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                           text-white hover:brightness-110 transition
                           hover:-translate-y-0.5 hover:scale-[1.02]
                           cta-mua-floating">
        Daftarkan jasa MUA kamu di sini
      </button>
    @endif

  @else
    <a href="{{ route('login') }}" class="hidden md:inline-flex fixed bottom-6 left-6 z-[60]
                                                           items-center justify-center px-6 py-2.5 rounded-full
                                                           text-sm font-semibold
                                                           bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                                           text-white hover:brightness-110 transition
                                                           hover:-translate-y-0.5 hover:scale-[1.02]
                                                           cta-mua-floating">
      Daftarkan jasa MUA kamu di sini
    </a>
  @endauth

  {{-- ICON MELAYANG --}}
  <span class="floating-icon from-bottom icon-lg"
    style="left: 10%; animation-duration: 22s; animation-delay: 0s;">❖</span>
  <span class="floating-icon from-bottom icon-md"
    style="left: 32%; animation-duration: 24s; animation-delay: 3s;">✿</span>
  <span class="floating-icon from-bottom icon-xl"
    style="left: 58%; animation-duration: 28s; animation-delay: 6s;">❁</span>
  <span class="floating-icon from-bottom icon-lg"
    style="left: 80%; animation-duration: 25s; animation-delay: 4s;">✥</span>

  <span class="floating-icon from-top icon-md" style="left: 15%; animation-duration: 23s; animation-delay: 2s;">✦</span>
  <span class="floating-icon from-top icon-lg" style="left: 42%; animation-duration: 27s; animation-delay: 5s;">❋</span>
  <span class="floating-icon from-top icon-xl" style="left: 68%; animation-duration: 30s; animation-delay: 8s;">◈</span>
  <span class="floating-icon from-top icon-md" style="left: 88%; animation-duration: 26s; animation-delay: 3s;">❂</span>

  {{-- ALPINE --}}
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  {{-- COUNT-UP ANIMATION --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const counters = document.querySelectorAll('.countup');
      if (!('IntersectionObserver' in window)) {
        counters.forEach(el => runCountUp(el));
        return;
      }

      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const el = entry.target;
            if (!el.dataset.counted) {
              el.dataset.counted = 'true';
              runCountUp(el);
            }
            observer.unobserve(el);
          }
        });
      }, { threshold: 0.4 });

      counters.forEach(el => observer.observe(el));

      function runCountUp(el) {
        const target = parseInt(el.dataset.target || '0', 10);
        let current = 0;
        const duration = 1400;
        const start = performance.now();

        function update(now) {
          const progress = Math.min((now - start) / duration, 1);
          current = Math.floor(progress * target);
          el.textContent = current.toString();
          if (progress < 1) requestAnimationFrame(update);
          else el.textContent = target.toString();
        }

        requestAnimationFrame(update);
      }
    });
  </script>
</body>

</html>