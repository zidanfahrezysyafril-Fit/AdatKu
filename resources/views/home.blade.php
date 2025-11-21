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
      scroll-behavior: smooth;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff9fb;
      /* pattern lembut */
      background-image:
        linear-gradient(135deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
        linear-gradient(225deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%);
      background-size: 26px 26px;
    }

    .logo-font {
      font-family: 'Great Vibes', cursive;
    }

    /* --- animasi badge kecil di hero --- */
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

    /* --- slider galeri --- */
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

    /* ================= ICON MELAYANG ================= */

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
  </style>

</head>

<body class="text-gray-900" x-data="{ open:false, profileModal:false, editModal:false }">

  {{-- FLASH MESSAGE --}}
  @if (session('success') || session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2600)" x-show="show" x-transition
      class="fixed left-1/2 -translate-x-1/2 top-6 z-[9999]">
      <div class="flex items-center gap-3 px-5 py-3 rounded-full shadow-xl text-[13px] md:text-[14px] font-medium text-white
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

  {{-- HEADER --}}
  <header class="sticky top-0 z-40">
    <div class="backdrop-blur-md bg-white/80 border-b border-amber-100/60 shadow-sm">
      <div class="max-w-7xl mx-auto px-5 md:px-8 py-3.5 flex items-center justify-between gap-4">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
          <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
            class="w-12 h-12 rounded-full object-cover shadow-md border border-amber-200">
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
          <a href="#tim" class="hover:text-amber-600 transition">Tim</a> {{-- <== ini baru --}} <a
            href="{{ route('hubungikami') }}" class="hover:text-amber-600 transition">Hubungi Kami</a>
            @auth
              <a href="{{ route('public.mua.index') }}" class="hover:text-amber-600 transition">
                Daftar MUA
              </a>
            @endauth
        </nav>


        {{-- Aksi kanan --}}
        <div class="flex items-center gap-3">
          @guest
            <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                                              bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                              text-white shadow-md hover:brightness-110 transition">
              Masuk
            </a>
          @endguest

          @auth
            @php
              $user = auth()->user();
              $avatar = $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png');
            @endphp

            {{-- Tombol Pesanan (pengguna) --}}
            @if ($user->role === 'Pengguna')
              <a href="{{ route('pengguna.pesanan.index') }}"
                class="hidden lg:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 hover:bg-amber-100
                                                                        text-amber-800 text-xs font-semibold shadow-sm border border-amber-200">
                📦 Pesanan Saya
              </a>
            @endif

            {{-- Dropdown user --}}
            <div class="relative">
              <button @click="open = !open"
                class="w-10 h-10 rounded-full overflow-hidden border-2 border-amber-300 shadow focus:outline-none">
                <img src="{{ $avatar }}" alt="Profile" class="w-full h-full object-cover"
                  onerror="this.onerror=null;this.src='{{ asset('default-avatar.png') }}'">
              </button>

              <div x-show="open" x-cloak x-transition @click.outside="open = false"
                class="absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-lg ring-1 ring-black/5 overflow-hidden z-50">
                <div class="px-4 py-3 border-b border-amber-50 bg-amber-50/40">
                  <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                  <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                </div>
                <ul class="py-1 text-sm">
                  <li>
                    <button type="button" @click="profileModal = true; open = false"
                      class="w-full text-left px-4 py-2 hover:bg-amber-50">
                      Profil Saya
                    </button>
                  </li>
                  <li class="border-t border-amber-50">
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

  {{-- HERO --}}
  <section class="relative overflow-hidden">
    {{-- background image --}}
    <div class="relative h-[520px] md:h-[560px]">
      <img src="{{ asset('logoss3 .jpg') }}" alt="AdatKu Hero" class="w-full h-full object-cover brightness-[0.55]">
      <div
        class="absolute inset-0 bg-gradient-to-br from-black/40 via-black/35 to-black/55 mix-blend-multiply pointer-events-none">
      </div>

      {{-- konten --}}
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

          {{-- kartu stats / info kenapa AdatKu --}}
          <div class="hidden md:block relative h-full">
            <div class="absolute top-10 right-0 w-[360px]
           bg-white/90 backdrop-blur-xl
           rounded-3xl shadow-[0_18px_45px_rgba(0,0,0,0.35)]
           border border-amber-100/80 p-6
           floating-badge">

              <p class="text-xs font-semibold text-amber-700 mb-2 uppercase tracking-[0.16em]">
                KENAPA ADATKU?
              </p>
              <p class="text-sm text-gray-600 mb-5 leading-relaxed">
                Kami membantu menghubungkanmu dengan penyedia jasa adat yang
                terpercaya di daerahmu, tanpa ribet dan tetap elegan.
              </p>

              <div class="grid grid-cols-3 gap-3 text-center text-xs">
                <div class="bg-amber-50/90 rounded-2xl py-3 px-2">
                  <div class="text-lg font-bold text-amber-700">+25</div>
                  <div class="text-[11px] text-amber-800/80">MUA Terdaftar</div>
                </div>
                <div class="bg-amber-50/90 rounded-2xl py-3 px-2">
                  <div class="text-lg font-bold text-amber-700">+40</div>
                  <div class="text-[11px] text-amber-800/80">Busana Adat</div>
                </div>
                <div class="bg-amber-50/90 rounded-2xl py-3 px-2">
                  <div class="text-lg font-bold text-amber-700">+15</div>
                  <div class="text-[11px] text-amber-800/80">Pelaminan</div>
                </div>
              </div>

              <p class="text-[10px] text-amber-700/80 mt-4 border-t border-amber-100 pt-3 leading-relaxed">
                *Data hanya ilustrasi, bisa kamu sesuaikan dengan data asli dari sistemmu.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- TENTANG ADATKU --}}
  <section id="tentang" class="max-w-5xl mx-auto px-6 md:px-10 py-14 scroll-mt-24 md:scroll-mt-32">
    <div class="text-center mb-7">
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
            <img src="{{ asset('bajuminang.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Baju Minang">
            <img src="{{ asset('bajumelayu.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Baju Melayu">
            <img src="{{ asset('bajujawa.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Baju Jawa">
            <img src="{{ asset('bajusunda.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Baju Sunda">
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
            <img src="{{ asset('makeupjawa.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Makeup Jawa">
            <img src="{{ asset('makeupnikah.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Makeup Nikah">
            <img src="{{ asset('makeuplamaran.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Makeup Lamaran">
            <img src="{{ asset('makeupwisuda.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Makeup Wisuda">
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
            <img src="{{ asset('pelamin1.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Pelamin 1">
            <img src="{{ asset('pelamin2.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Pelamin 2">
            <img src="{{ asset('pelamin3.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Pelamin 3">
            <img src="{{ asset('pelamin4.jpg') }}" class="w-1/4 h-[320px] object-cover" alt="Pelamin 4">
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
        // kalau admin belum isi apa-apa, kita seed fallback manual dulu
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
              'role' => 'Backend & Database',
              'division' => 'Logika Pemesanan & Data MUA',
              'photo' => null,
            ],
          ]);
        }
      @endphp

      <div class="grid md:grid-cols-3 gap-6 md:gap-8 items-stretch">
        @foreach ($teamToShow as $index => $member)
              @php
                $isCenter = ($loop->count >= 3 && $loop->iteration == 2); // orang ke-2 jadi kartu tengah/hightlight
                $photoUrl = $member->photo
                  ? asset('storage/' . $member->photo)
                  : 'https://placehold.co/300x300?text=' . urlencode(Str::limit($member->name, 2, ''));
              @endphp

              <div class="
                                                bg-white rounded-3xl border px-5 md:px-6 py-6 md:py-7 flex flex-col items-center text-center 
                                                {{ $isCenter
          ? 'shadow-lg border-amber-200 md:scale-105 md:-translate-y-2'
          : 'shadow-md border-amber-100/80' }}
                                              ">
                <div
                  class="w-20 h-20 {{ $isCenter ? 'w-24 h-24' : '' }}
                                                       rounded-full overflow-hidden bg-gradient-to-br from-[#f7e07b] via-[#eab308] to-[#c98a00]
                                                       flex items-center justify-center text-white text-2xl md:text-3xl font-bold mb-3 shadow-lg">
                  <img src="{{ $photoUrl }}" alt="{{ $member->name }}" class="w-full h-full object-cover"
                    onerror="this.onerror=null;this.src='https://placehold.co/300x300?text=Tim';">
                </div>

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
        @endforeach
      </div>

      <p class="text-[11px] text-center text-gray-500 mt-5">
        *Data tim bisa diubah dari dashboard admin (nama, peran, dan foto).
      </p>
    </div>
  </section>


  {{-- CTA STRIP MODERN --}}
  <section class="py-10">
    <div
      class="max-w-6xl mx-auto mx-4 md:mx-auto px-6 md:px-10 py-7 rounded-3xl bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] shadow-lg flex flex-col md:flex-row items-center justify-between gap-4">
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
        <a href="{{ route('login') }}"
          class="inline-flex items-center px-4 py-2.5 rounded-full text-sm font-semibold bg-white text-[#c98a00] shadow-md hover:bg-amber-50">
          Daftarkan Jasa Sekarang
        </a>
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

        <button type="button" @click="editModal = false" class="absolute top-5 right-5 w-9 h-9 rounded-full bg-slate-100
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
              <li><a href="{{ route('hubungikami') }}" class="hover:text-[#f7e07b] transition">Hubungi Kami</a></li>
            </ul>
          </div>

          {{-- Kontak & kredit --}}
          <div class="text-sm">
            <h3 class="font-semibold text-[#f7e07b] mb-3">Kontak</h3>
            <p class="text-[#f5e9df] text-[13px]">
              Email: <a href="mailto:adatku11@gmail.com" class="hover:text-[#f7e07b]">adatku11@gmail.com</a><br>
              Instagram: <a href="https://www.instagram.com/_.adatku?igsh=Nm1mbWk2emx1cGZl" target="_blank"
                class="hover:text-[#f7e07b]">@_.adatku</a>
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

  {{-- BUTTON DAFTARKAN MUA --}}
  @auth
    @php
      $user = auth()->user();
      $isMua = strtolower($user->role ?? '') === 'mua';
    @endphp

    {{-- Kalau BELUM jadi MUA, tombolnya muncul --}}
    @if (!$isMua)
      <div class="fixed left-5 bottom-5 z-40">
        <a href="{{ route('mua.request.index') }}" class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                          text-white px-5 md:px-6 py-2.5 rounded-full shadow-lg hover:shadow-xl
                          hover:from-[#f8e48c] hover:to-[#e0a100] transition text-sm md:text-[15px] font-medium">
          Daftarkan jasa MUA kamu di sini
        </a>
      </div>
    @endif
  @else
    {{-- Kalau belum login, tetap munculin, tapi arahkan ke login dulu --}}
    <div class="fixed left-5 bottom-5 z-40">
      <a href="{{ route('login') }}" class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                    text-white px-5 md:px-6 py-2.5 rounded-full shadow-lg hover:shadow-xl
                    hover:from-[#f8e48c] hover:to-[#e0a100] transition text-sm md:text-[15px] font-medium">
        Daftarkan jasa MUA kamu di sini
      </a>
    </div>
  @endauth


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

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>