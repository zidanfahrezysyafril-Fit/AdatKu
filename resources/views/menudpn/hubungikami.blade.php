<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hubungi Kami - AdatKu</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- FONTS & TAILWIND --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
      background-size: 24px 24px;
    }

    .logo-font {
      font-family: 'Perfecto Kaligrafi', 'Great Vibes', cursive;
    }

    .justify-teks {
      text-align: justify;
      text-justify: inter-word;
    }

    /* ICON MELAYANG */
    .floating-icon {
      position: fixed;
      font-weight: bold;
      color: rgba(255, 255, 255, 0.9);
      z-index: 20;
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

    /* animasi kartu naik halus */
    @keyframes slide-up-soft {
      from {
        opacity: 0;
        transform: translateY(12px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-soft {
      animation: slide-up-soft 0.4s ease-out;
    }

    /* ANIMASI POPUP SUKSES */
    @keyframes popup-bounce {
      0% {
        transform: scale(0.8) translateY(10px);
        opacity: 0;
      }

      60% {
        transform: scale(1.03) translateY(0);
        opacity: 1;
      }

      100% {
        transform: scale(1);
        opacity: 1;
      }
    }

    .popup-success-card {
      animation: popup-bounce 0.32s ease-out;
    }

    @keyframes float-bubble {
      0% {
        transform: translateY(0px) translateX(0px);
        opacity: 0;
      }

      20% {
        opacity: 1;
      }

      50% {
        transform: translateY(-14px) translateX(6px);
      }

      80% {
        opacity: 1;
      }

      100% {
        transform: translateY(-26px) translateX(-4px);
        opacity: 0;
      }
    }

    .floating-emoji {
      animation: float-bubble 3.5s ease-in-out infinite;
    }
  </style>
</head>

<body class="bg-[rgba(255,242,213,0.08)] text-gray-900"
  x-data="{ navOpen:false, userMenuOpen:false, profileModal:false, editModal:false }">

  {{-- FLASH SESSION (atas kecil) --}}
  @if (session('success') || session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2500)" x-show="show" x-transition
      class="fixed left-1/2 -translate-x-1/2 top-20 z-[60]">
      <div class="flex items-center gap-3 px-6 py-3 rounded-lg shadow-xl text-[15px] font-semibold text-white
                              backdrop-blur-md border border-[#fff3b0]/40
                              @if (session('success')) bg-gradient-to-r from-[#f9e88b] via-[#eab308] to-[#c98a00]
                              @else bg-gradient-to-r from-[#ef4444] via-[#dc2626] to-[#b91c1c] @endif">
        <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
  @endauth

  {{-- NAVBAR --}}
  <header class="sticky top-0 z-50">
    <div class="bg-white/80 backdrop-blur-md border-b border-amber-100/70">
      <div class="max-w-7xl mx-auto px-5 md:px-6 py-3.5 flex items-center justify-between gap-4">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
          <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
            class="w-12 h-12 rounded-full object-cover shadow-md border border-amber-200">
          <div>
            <h1
              class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
              AdatKu
            </h1>
            <p class="hidden sm:block text-[11px] text-amber-900/80">Hubungi kami kapan saja</p>
          </div>
        </a>

        {{-- NAV DESKTOP --}}
        <nav class="hidden md:flex items-center gap-6 text-[14px] font-medium text-[#b48a00]">
          <a href="{{ route('home') }}" class="hover:text-[#eab308]">Beranda</a>

          @auth
            <a href="{{ url('daftarmua') }}" class="hover:text-[#eab308]">Daftar MUA</a>
          @endauth

          <a href="{{ route('hubungikami') }}" class="text-[#eab308] font-semibold border-b-2 pb-0.5 border-[#eab308]">
            Hubungi Kami
          </a>
        </nav>

        {{-- ACTION KANAN --}}
        <div class="flex items-center gap-3">
          {{-- HAMBURGER MOBILE --}}
          <button @click="navOpen = true" class="md:hidden inline-flex items-center gap-2 px-3 py-2 rounded-full border border-amber-200/70 bg-white/80
                   shadow-sm hover:bg-amber-50 hover:border-amber-300 transition text-xs text-amber-800">
            <span class="relative flex flex-col justify-between w-3.5 h-3">
              <span class="block h-[2px] rounded-full bg-amber-500"></span>
              <span class="block h-[2px] rounded-full bg-amber-400"></span>
              <span class="block h-[2px] rounded-full bg-amber-500 w-2/3 self-end"></span>
            </span>
            <span class="hidden sm:inline">Menu</span>
          </button>

          @guest
            {{-- tombol login (desktop & mobile) --}}
            <a href="{{ route('pengguna.home') }}" class="hidden md:inline-flex bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                  text-white px-4 py-2 rounded-full shadow-md hover:shadow-lg hover:brightness-105
                                  transition text-sm font-semibold">
              Masuk
            </a>
          @endguest

          @auth
            {{-- AVATAR USER (desktop & mobile) --}}
            <div class="relative hidden md:block">
              <button @click="userMenuOpen = !userMenuOpen"
                class="w-11 h-11 rounded-full overflow-hidden border-2 border-[#f5d547] shadow focus:outline-none">
                <img src="{{ $avatar }}" alt="Profile" class="w-full h-full object-cover"
                  onerror="this.onerror=null;this.src='{{ asset('default-avatar.png') }}'">
              </button>

              <div x-show="userMenuOpen" x-cloak x-transition @click.outside="userMenuOpen=false"
                class="absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-lg ring-1 ring-black/5 overflow-hidden z-50">
                <div class="px-4 py-3 border-b">
                  <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                  <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                </div>
                <ul class="py-1 text-sm">
                  <li>
                    <button type="button" @click="profileModal = true; userMenuOpen=false"
                      class="w-full text-left px-4 py-2 hover:bg-gray-50">
                      Profil Saya
                    </button>
                  </li>
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
      </div>
    </div>
  </header>

  {{-- NAV DRAWER MOBILE --}}
  <div class="fixed inset-0 z-40 flex justify-end items-stretch transition-opacity duration-300" x-cloak
    :class="navOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'"
    @keydown.escape.window="navOpen = false">

    {{-- overlay --}}
    <div class="flex-1 h-full bg-black/40 backdrop-blur-sm" @click="navOpen = false"></div>

    {{-- panel kanan --}}
    <div class="relative h-full w-[78%] max-w-xs sm:max-w-sm bg-white
                shadow-[0_0_40px_rgba(0,0,0,0.4)] border-l border-amber-100
                flex flex-col transform transition-transform duration-300 ease-out"
      :class="navOpen ? 'translate-x-0' : 'translate-x-full'">

      {{-- header drawer --}}
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

      {{-- menu list --}}
      <div class="flex-1 overflow-y-auto px-4 py-3 text-sm text-slate-800 space-y-1">
        <button @click="navOpen = false; window.location='{{ route('home') }}'"
          class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
          <span class="text-lg">🏠</span><span>Beranda</span>
        </button>

        @auth
          <button @click="navOpen = false; window.location='{{ url('daftarmua') }}'"
            class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700">
            <span class="text-lg">💄</span><span>Daftar MUA</span>
          </button>
        @endauth

        <button @click="navOpen = false; window.location='{{ route('hubungikami') }}'"
          class="flex w-full items-center gap-2 py-2 rounded-lg bg-amber-50 text-amber-700 font-semibold">
          <span class="text-lg">✉️</span><span>Hubungi Kami</span>
        </button>

        @auth
          <button @click="navOpen = false; profileModal = true"
            class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700 mt-1.5">
            <span class="text-lg">👤</span><span>Profil Saya</span>
          </button>

          <form method="POST" action="{{ route('logout') }}" class="mt-1.5">
            @csrf
            <button type="submit" class="flex w-full items-center gap-2 py-2 rounded-lg hover:bg-red-50 text-red-600">
              <span class="text-lg">⎋</span><span>Logout</span>
            </button>
          </form>
        @else
          <button @click="navOpen = false; window.location='{{ route('pengguna.home') }}'"
            class="mt-3 flex w-full items-center justify-center gap-2 py-2.5 rounded-full bg-gradient-to-r
                             from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white font-semibold shadow-md hover:brightness-110">
            Sign In
          </button>
        @endauth
      </div>
    </div>
  </div>

  {{-- HERO --}}
  <section class="relative min-h-[380px] sm:min-h-[420px] md:min-h-[480px]">
    {{-- Background image + overlay --}}
    <div class="absolute inset-0 -z-10">
      <img src="{{ asset('logoss3 .jpg') }}" alt="Hero AdatKu" class="w-full h-full object-cover" />
      <div class="absolute inset-0 bg-gradient-to-b from-black/65 via-black/35 to-black/60"></div>
    </div>

    {{-- Konten hero --}}
    <div class="max-w-6xl mx-auto px-5 sm:px-6 py-10 sm:py-12 md:py-16">
      <div class="max-w-xl text-left text-white space-y-4">

        <span
          class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-semibold tracking-[0.18em] uppercase bg-white/10 border border-[#f7e07b]/60 text-[#ffeaa5]">
          <span class="text-xs">📮</span>
          Butuh bantuan AdatKu?
        </span>

        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-semibold leading-tight">
          <span
            class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent drop-shadow-[0_4px_14px_rgba(0,0,0,0.55)]">
            Hubungi Kami, cerita kendalamu di sini ✨
          </span>
        </h1>

        <p class="text-sm md:text-base text-[#fdf6d8] leading-relaxed">
          Ada pertanyaan seputar pemesanan MUA, busana adat, atau kerja sama kampus?
          Kirim pesan lewat formulir di bawah. Tim AdatKu siap membantu kamu dengan ramah dan cepat.
        </p>

        <div class="grid gap-3 mt-3 text-sm sm:grid-cols-3">
          <div class="rounded-2xl bg-white/10 border border-white/20 px-4 py-3 backdrop-blur-sm flex items-start gap-2">
            <span class="text-lg">💬</span>
            <div>
              <p class="font-semibold text-[#ffeaa5] text-xs uppercase tracking-wide mb-0.5">
                Pertanyaan Umum
              </p>
              <p class="text-[11px] leading-snug text-[#fefce8]">
                Tanya fitur AdatKu, cara daftar, dan alur pemesanan.
              </p>
            </div>
          </div>

          <div class="rounded-2xl bg-white/10 border border-white/20 px-4 py-3 backdrop-blur-sm flex items-start gap-2">
            <span class="text-lg">🤝</span>
            <div>
              <p class="font-semibold text-[#ffeaa5] text-xs uppercase tracking-wide mb-0.5">
                Kerja Sama
              </p>
              <p class="text-[11px] leading-snug text-[#fefce8]">
                Kolaborasi dengan MUA, studio foto, atau event organizer.
              </p>
            </div>
          </div>

          <div class="rounded-2xl bg-white/10 border border-white/20 px-4 py-3 backdrop-blur-sm flex items-start gap-2">
            <span class="text-lg">🛠️</span>
            <div>
              <p class="font-semibold text-[#ffeaa5] text-xs uppercase tracking-wide mb-0.5">
                Kendala Teknis
              </p>
              <p class="text-[11px] leading-snug text-[#fefce8]">
                Laporkan bug, error website, atau masalah login.
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- FORM & INFO KONTAK --}}
  <main x-data="contactForm()" class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">

    {{-- FORM --}}
    <section class="md:col-span-2">
      <div class="bg-white rounded-3xl shadow-xl p-8 border border-yellow-100/80 animate-soft">

        {{-- NOTIFIKASI FORM (JS) --}}
        <div x-show="notification.show" x-transition x-cloak class="mb-5 rounded-xl px-4 py-3 text-sm font-medium"
          :class="notification.type === 'success'
                    ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                    : 'bg-red-50 text-red-700 border border-red-200'">
          <span x-text="notification.message"></span>
        </div>

        <h2 class="text-2xl font-bold text-[#c98a00] mb-2">
          Sampaikan Pesanmu
        </h2>
        <p class="text-slate-600 mb-6 justify-teks text-sm md:text-[15px]">
          Isi formulir ini untuk menghubungi kami terkait pertanyaan, saran, atau kendala yang kamu alami
          saat menggunakan AdatKu.
        </p>

        <form @submit.prevent="submitForm" class="space-y-5">
          {{-- Nama & Telepon --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm mb-2 font-semibold text-slate-700">
                Nama Lengkap <span class="text-red-500">*</span>
              </label>
              <input type="text" x-model="formData.nama" required placeholder="Masukkan nama lengkap kamu" class="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm
                            focus:outline-none focus:ring-2 focus:ring-[#eab308] focus:border-[#eab308] transition">
            </div>
            <div>
              <label class="block text-sm mb-2 font-semibold text-slate-700">
                Nomor Telepon
              </label>

              <div class="w-full rounded-xl border-2 border-slate-200 flex items-stretch overflow-hidden
           focus-within:ring-2 focus-within:ring-[#eab308] focus-within:border-[#eab308] transition">

                {{-- Prefix negara: ID +62 --}}
                <div class="flex items-center gap-1 px-3 bg-slate-50 border-r border-slate-200 text-xs">
                  <span class="px-1.5 py-0.5 rounded-full bg-white text-slate-600 font-semibold">ID</span>
                  <span class="text-slate-700 font-semibold text-sm">+62</span>
                </div>

                {{-- Input nomor (tanpa +62) --}}
                <input id="contact-phone" type="tel" x-model="formData.telepon" placeholder="812 3456 7890"
                  class="flex-1 px-3 py-3 text-sm bg-transparent border-none focus:outline-none focus:ring-0" />
              </div>

              <p class="mt-1 text-[11px] text-slate-400">
                Tulis nomor tanpa 0 di depan. Contoh: <span class="font-semibold">81234567890</span>
              </p>
            </div>

          </div>

          {{-- Email --}}
          <div>
            <label class="block text-sm mb-2 font-semibold text-slate-700">
              Alamat Email <span class="text-red-500">*</span>
            </label>
            <input type="email" x-model="formData.email" required placeholder="contoh@email.com" class="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm
                          focus:outline-none focus:ring-2 focus:ring-[#eab308] focus:border-[#eab308] transition">
          </div>

          {{-- Subjek --}}
          <div>
            <label class="block text-sm mb-2 font-semibold text-slate-700">
              Subjek Pesan <span class="text-red-500">*</span>
            </label>
            <input type="text" x-model="formData.subjek" required placeholder="Contoh: Kendala saat melakukan pemesanan"
              class="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm
                          focus:outline-none focus:ring-2 focus:ring-[#eab308] focus:border-[#eab308] transition">
          </div>

          {{-- Pesan --}}
          <div>
            <label class="block text-sm mb-2 font-semibold text-slate-700">
              Pesan / Pertanyaan <span class="text-red-500">*</span>
            </label>
            <textarea x-model="formData.pesan" rows="6" required
              placeholder="Jelaskan pertanyaan, saran, atau kendala kamu secara detail..."
              class="w-full rounded-xl border-2 border-slate-200 px-4 py-3 text-sm
                             focus:outline-none focus:ring-2 focus:ring-[#eab308] focus:border-[#eab308] transition resize-none"></textarea>
          </div>

          {{-- Tombol Kirim --}}
          <button type="submit" :disabled="loading" class="w-full md:w-auto px-8 py-3.5 text-white font-semibold rounded-xl shadow-lg
                         bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                         hover:shadow-xl hover:scale-[1.02]
                         disabled:opacity-50 disabled:cursor-not-allowed
                         transition-all duration-300 flex items-center justify-center gap-2">
            <span x-show="!loading">Kirim Pesan</span>
            <span x-show="loading" class="flex items-center gap-2">
              <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 
                         1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Mengirim...
            </span>
          </button>
        </form>
      </div>
    </section>

    {{-- SIDEBAR KONTAK --}}
    <aside class="md:pl-2">
      <div class="bg-white rounded-3xl shadow-xl p-6 border border-yellow-100/80 sticky top-24 animate-soft">
        <h2 class="text-xl font-bold text-[#c98a00] mb-5 flex items-center gap-2">
          <span>📞</span> Informasi Kontak
        </h2>

        <ul class="space-y-5 text-slate-700 text-sm">
          {{-- Lokasi / IG --}}
          <li class="flex items-start gap-3 p-3 rounded-xl hover:bg-yellow-50/70 transition">
            <span class="text-2xl">📍</span>
            <div>
              <p class="font-semibold text-xs text-slate-500 mb-1">Lokasi & Media Sosial</p>
              <p class="font-medium">AdatKu Indonesia</p>
              <a href="https://www.instagram.com/_.adatku?igsh=Nm1mbWk2emx1cGZl" target="_blank"
                class="inline-flex items-center gap-2 text-[#c98a00] hover:text-[#eab308] font-medium mt-2 text-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                  <path
                    d="M7.75 2A5.75 5.75 0 002 7.75v8.5A5.75 5.75 0 007.75 22h8.5A5.75 5.75 0 0022 16.25v-8.5A5.75 5.75 0 0016.25 2h-8.5zM12 7a5 5 0 110 10 5 5 0 010-10zm0 2a3 3 0 100 6 3 3 0 000-6zm5.25-3.5a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z" />
                </svg>
                @_.adatku
              </a>
            </div>
          </li>

          {{-- Email --}}
          <li class="flex items-start gap-3 p-3 rounded-xl hover:bg-yellow-50/70 transition">
            <span class="text-2xl">✉️</span>
            <div>
              <p class="font-semibold text-xs text-slate-500 mb-1">Email</p>
              <a href="mailto:adatku11@gmail.com"
                class="font-medium text-[#c98a00] hover:text-[#eab308] hover:underline transition">
                adatku11@gmail.com
              </a>
            </div>
          </li>

          {{-- Jam Operasional --}}
          <li class="flex items-start gap-3 p-3 rounded-xl hover:bg-yellow-50/70 transition">
            <span class="text-2xl">⏰</span>
            <div>
              <p class="font-semibold text-xs text-slate-500 mb-1">Jam Layanan</p>
              <p class="font-medium">Setiap Hari</p>
              <p class="text-xs text-slate-600">08.00 - 23.00 WIB</p>
            </div>
          </li>
        </ul>

        <div class="mt-6 p-4 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl border border-yellow-200 text-sm">
          <p class="text-slate-700 leading-relaxed">
            <span class="font-semibold">💡 Tip:</span> Biasanya kami merespons dalam waktu
            <span class="font-semibold">1–2 hari kerja</span>. Untuk kasus mendesak,
            silakan hubungi kami via Instagram.
          </p>
        </div>
      </div>

      {{-- POPUP SUKSES KIRIM PESAN --}}
      <div x-cloak x-show="successModal" x-transition.opacity
        class="fixed inset-0 z-[80] flex items-center justify-center bg-black/40 backdrop-blur-sm">

        <div class="popup-success-card relative max-w-md w-[90%] bg-gradient-to-br
                  from-[#fff9fb] via-white to-[#fff3d7]
                  rounded-3xl shadow-2xl border border-amber-100 px-6 py-6 overflow-hidden">

          {{-- bubble warna --}}
          <div class="absolute -top-6 -left-4 w-16 h-16 rounded-full bg-amber-100/60 blur-md"></div>
          <div class="absolute -bottom-10 -right-6 w-24 h-24 rounded-full bg-rose-100/60 blur-xl"></div>

          {{-- emoji melayang --}}
          <div class="absolute top-3 right-6 text-2xl floating-emoji delay-100">✨</div>
          <div class="absolute bottom-4 left-6 text-2xl floating-emoji delay-300">💌</div>
          <div class="absolute top-10 left-1/2 -translate-x-1/2 text-xl floating-emoji delay-700">🌸</div>

          <div class="relative">
            <div
              class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center mb-4 border border-emerald-100">
              <span class="text-3xl">✅</span>
            </div>

            <h2 class="text-xl font-semibold text-slate-800 mb-1">
              Pesan terkirim! 🎉
            </h2>
            <p class="text-sm text-slate-600 mb-4" x-text="successMessage"></p>

            <div class="flex items-center justify-between text-[11px] text-slate-400 mb-3">
              <span>Terima kasih sudah menghubungi AdatKu 💛</span>
              <span>Hubungi Kami · AdatKu</span>
            </div>

            <div class="flex justify-end">
              <button type="button" @click="successModal = false"
                class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 text-sm hover:bg-slate-50">
                Tutup
              </button>
            </div>
          </div>
        </div>
      </div>
    </aside>

  </main>

  {{-- MODAL PROFIL & EDIT --}}
  @auth
    {{-- Profil Saya --}}
    <div x-show="profileModal" x-cloak x-transition.opacity
      class="fixed inset-0 z-[80] flex items-center justify-center bg-black/40 backdrop-blur-sm">
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

    {{-- Edit Profil --}}
    <div x-show="editModal" x-cloak x-transition.opacity
      class="fixed inset-0 z-[90] flex items-center justify-center bg-black/45 backdrop-blur-sm">
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
                                    w-28 h-28 sm:w-32 sm:h-32 rounded-full p-[3px]
                                    bg-gradient-to-br from-[#f7e07b] via-[#eab308] to-[#c98a00] shadow-xl">
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
  <span class="floating-icon from-top icon-md" style="left: 15%; animation-duration: 23s; animation-delay: 2s;">✦</span>
  <span class="floating-icon from-top icon-lg" style="left: 42%; animation-duration: 27s; animation-delay: 5s;">❋</span>
  <span class="floating-icon from-top icon-xl" style="left: 68%; animation-duration: 30s; animation-delay: 8s;">◈</span>
  <span class="floating-icon from-top icon-md" style="left: 88%; animation-duration: 26s; animation-delay: 3s;">❂</span>

  {{-- SCRIPT ALPINE CONTACT FORM --}}
  <script>
    function contactForm() {
      return {
        loading: false,
        notification: {
          show: false,
          type: 'success',
          message: ''
        },

        // popup sukses
        successModal: false,
        successMessage: '',

        formData: {
          nama: '',
          telepon: '',
          email: '',
          subjek: '',
          pesan: ''
        },

        showNotification(type, message) {
          this.notification = { show: true, type, message };
          setTimeout(() => {
            this.notification.show = false;
          }, 4000);
        },

        async submitForm() {
          this.loading = true;

          try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            const response = await fetch('/hubungi-kami', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
              },
              body: JSON.stringify(this.formData)
            });

            const data = await response.json();

            if (data.success) {
              // notif kecil di atas form
              this.showNotification('success', data.message || 'Pesan berhasil dikirim! Kami akan segera menghubungi kamu.');

              // isi pesan popup
              this.successMessage = data.message || 'Pesanmu sudah terkirim ke tim AdatKu. Kami akan merespons dalam 1–2 hari kerja. ✨';
              this.successModal = true;

              // reset form
              this.formData = {
                nama: '',
                telepon: '',
                email: '',
                subjek: '',
                pesan: ''
              };

              // auto close popup
              setTimeout(() => {
                this.successModal = false;
              }, 4500);

            } else {
              throw new Error(data.message || 'Gagal mengirim pesan');
            }
          } catch (error) {
            this.showNotification('error', error.message || 'Gagal mengirim pesan. Silakan coba lagi atau hubungi kami melalui email.');
            console.error('Error:', error);
          } finally {
            this.loading = false;
          }
        }
      }
    }
  </script>

</body>

</html>