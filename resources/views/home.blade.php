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
      font-family: 'Poppins', sans-serif;
    }

    .logo-font {
      font-family: 'Perfecto Kaligrafi', 'Great Vibes', cursive;
    }

    @keyframes slide {

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

    .animate-slide {
      animation: slide 12s infinite ease-in-out;
    }

    /* TEKS RATA KIRI–KANAN */
    .justify-teks {
      text-align: justify !important;
      text-justify: inter-word;
    }

    /* ========== ORNAMEN ADAT MELAYANG ========== */

    .floating-icon {
      position: fixed;
      font-weight: bold;
      color: rgba(255, 255, 255, 0.9);
      z-index: 9999;
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

    /* Naik dari bawah */
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

    /* Turun dari atas */
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

<body class="bg-[rgba(255,242,213,0.08)] text-gray-900">

  @if (session('success') || session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2500)" x-show="show" x-transition
      class="fixed left-1/2 -translate-x-1/2 top-20 z-[9999]">
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

  <header class="sticky top-0 z-50 bg-opacity-1 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <a href="/" class="flex items-center gap-3">
          <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu" class="w-14 h-14 rounded-full object-cover shadow-md">
          <h1
            class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
            AdatKu</h1>
        </a>
      </div>
      <nav class="hidden md:flex items-center gap-6 text-[18px] text-[#b48a00]">
        <a href="/" class="hover:text-[#eab308]">Beranda</a>
        @auth
          <a href="{{ ('daftarmua') }}" class="hover:text-[#eab308]">Daftar MUA</a>
        @endauth
        <a href="{{ ('hubungikami') }}" class="hover:text-[#eab308]">Hubungi Kami</a>
      </nav>
      <div class="flex items-center gap-3">
        @guest
          <a href="{{ route('login') }}"
            class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-[#f8e48c] hover:to-[#e0a100] transition">
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

          {{-- 🔔 TOMBOL PESANAN UNTUK PENGGUNA --}}
          @if ($user->role === 'Pengguna')
            <a href="{{ route('pengguna.pesanan.index') }}"
              class="hidden md:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-100 hover:bg-yellow-200 text-[#b48a00] font-semibold text-sm shadow-md">
              📦 Pesanan Saya
            </a>
          @endif

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
                  <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-50">Profil Saya</a>
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

      <p class="text-lg md:text-xl w-11/12 md:w-2/5 mt-2">
        <span
          class="bg-gradient-to-r from-[#fff3b0] via-[#f5d547] to-[#d4a017] bg-clip-text text-transparent drop-shadow-md">
          Temukan keindahan budaya dan tradisi melalui koleksi busana adat, rias, dan pelaminan terbaik.
        </span>
      </p>

      <div class="mt-6 flex gap-4">
        <a href="#"
          class="border border-white/70 text-white px-6 py-3 rounded-full hover:bg-white/10 transition">Pelajari
          Lebih</a>
      </div>
    </div>
  </section>

  <div class="object-cover space-y-4 my-10 mx-4 md:mx-20">
    <h1 class="flex flex-col items-center text-4xl text-bold logo-font text-[#5c2b33]">
      Sekilas Tentang AdatKu
    </h1>
    <p class="max-w-4xl mx-auto text-lg text-gray-600 leading-relaxed justify-teks">
      AdatKu adalah sebuah website berbasis digital yang dibuat untuk melestarikan budaya daerah Indonesia
      sekaligus mempermudah masyarakat dalam memesan layanan adat secara online.
      Website ini menggabungkan unsur kebudayaan tradisional dengan teknologi modern, sehingga menghadirkan
      pengalaman baru dalam mengenal dan menggunakan layanan adat seperti baju adat, make up (MUA), dan pelaminan.
    </p>
  </div>

  <h1 class="flex flex-col items-center text-6xl text-bold logo-font text-[#5c2b33]">
    Galeri AdatKu
  </h1>
  <main class="py-16 space-y-28">

    {{-- BAJU ADAT --}}
    <section class="flex flex-col md:flex-row items-center justify-center md:space-x-16">
      <div class="relative w-[460px] h-[340px] overflow-hidden rounded-2xl shadow-xl">
        <div class="flex w-[400%] animate-slide">
          <img src="{{ asset('bajuminang.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Baju Minang">
          <img src="{{ asset('bajumelayu.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Baju Melayu">
          <img src="{{ asset('bajujawa.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Baju Jawa">
          <img src="{{ asset('bajusunda.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Baju Sunda">
        </div>
      </div>
      <div class="mt-10 md:mt-0 md:w-[420px]">
        <h2 class="logo-font text-4xl font-bold text-[#c98a00] mb-4 text-center md:text-left">Baju Adat</h2>
        <p class="justify-teks text-gray-600 leading-relaxed text-lg">
          Baju adat adalah simbol kebanggaan daerah dan identitas budaya. Setiap daerah di Indonesia memiliki
          ciri khas tersendiri pada busana adatnya yang mencerminkan keindahan, filosofi, serta nilai-nilai luhur
          masyarakat setempat.
        </p>
      </div>
    </section>

    {{-- MAKE UP --}}
    <section class="flex flex-col md:flex-row-reverse items-center justify-center md:space-x-16 md:space-x-reverse">
      <div class="relative w-[460px] h-[340px] overflow-hidden rounded-2xl shadow-xl">
        <div class="flex w-[400%] animate-slide">
          <img src="{{ asset('makeupjawa.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Makeup Jawa">
          <img src="{{ asset('makeupnikah.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Makeup Nikah">
          <img src="{{ asset('makeuplamaran.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Makeup Lamaran">
          <img src="{{ asset('makeupwisuda.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Makeup Wisuda">
        </div>
      </div>
      <div class="mt-10 md:mt-0 md:w-[420px]">
        <h2 class="logo-font text-4xl font-bold text-[#c98a00] mb-4 text-center md:text-right">Make Up</h2>
        <p class="justify-teks text-gray-600 leading-relaxed text-lg">
          Seni rias atau make up berperan penting dalam mempercantik penampilan. Dari rias pengantin hingga
          wisuda, setiap gaya memiliki karakteristik unik yang mempertegas keanggunan dan kepercayaan diri
          seseorang.
        </p>
      </div>
    </section>

    {{-- PELAMINAN --}}
    <section class="flex flex-col md:flex-row items-center justify-center md:space-x-16">
      <div class="relative w-[460px] h-[340px] overflow-hidden rounded-2xl shadow-xl">
        <div class="flex w-[400%] animate-slide">
          <img src="{{ asset('pelamin1.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Pelamin 1">
          <img src="{{ asset('pelamin2.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Pelamin 2">
          <img src="{{ asset('pelamin3.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Pelamin 3">
          <img src="{{ asset('pelamin4.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Pelamin 4">
        </div>
      </div>
      <div class="mt-10 md:mt-0 md:w-[420px]">
        <h2 class="logo-font text-4xl font-bold text-[#c98a00] mb-4 text-center md:text-left">Pelaminan</h2>
        <p class="justify-teks text-gray-600 leading-relaxed text-lg">
          Pelaminan adalah simbol kebahagiaan dalam pernikahan. Setiap desain pelaminan menonjolkan kekayaan adat
          dan keindahan budaya, menciptakan suasana yang megah dan sakral bagi pasangan pengantin.
        </p>
      </div>
    </section>
  </main>

  <footer class="bg-[#3d2630] text-[wheat] text-center py-6 mt-10">
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

  <div class="fixed left-5 bottom-5 z-50">
    <a href="{{ route('login') }}" class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
             text-white px-6 py-3 rounded-full shadow-lg hover:shadow-xl
             hover:from-[#f8e48c] hover:to-[#e0a100] transition font-medium">
      Daftarkan jasa MUA kamu di sini
    </a>
  </div>

  {{-- ORNAMEN ADAT NAIK DARI BAWAH --}}
  <span class="floating-icon from-bottom icon-lg" style="left: 5%;  animation-duration: 22s; animation-delay: 0s;">❖</span>
  <span class="floating-icon from-bottom icon-xl" style="left: 15%; animation-duration: 28s; animation-delay: 3s;">✿</span>
  <span class="floating-icon from-bottom icon-md" style="left: 25%; animation-duration: 18s; animation-delay: 6s;">❋</span>
  <span class="floating-icon from-bottom icon-lg" style="left: 35%; animation-duration: 25s; animation-delay: 1s;">✦</span>
  <span class="floating-icon from-bottom icon-xl" style="left: 45%; animation-duration: 30s; animation-delay: 5s;">❁</span>
  <span class="floating-icon from-bottom icon-md" style="left: 55%; animation-duration: 20s; animation-delay: 7s;">✥</span>
  <span class="floating-icon from-bottom icon-lg" style="left: 65%; animation-duration: 26s; animation-delay: 2s;">◈</span>
  <span class="floating-icon from-bottom icon-xl" style="left: 75%; animation-duration: 24s; animation-delay: 4s;">❂</span>
  <span class="floating-icon from-bottom icon-md" style="left: 85%; animation-duration: 29s; animation-delay: 8s;">✺</span>

  {{-- ORNAMEN ADAT TURUN DARI ATAS --}}
  <span class="floating-icon from-top icon-lg" style="left: 12%; animation-duration: 26s; animation-delay: 1s;">❖</span>
  <span class="floating-icon from-top icon-xl" style="left: 22%; animation-duration: 32s; animation-delay: 4s;">✿</span>
  <span class="floating-icon from-top icon-md" style="left: 32%; animation-duration: 20s; animation-delay: 6s;">❋</span>
  <span class="floating-icon from-top icon-lg" style="left: 52%; animation-duration: 28s; animation-delay: 2s;">✦</span>
  <span class="floating-icon from-top icon-xl" style="left: 62%; animation-duration: 30s; animation-delay: 7s;">❁</span>
  <span class="floating-icon from-top icon-md" style="left: 72%; animation-duration: 22s; animation-delay: 9s;">✥</span>
  <span class="floating-icon from-top icon-lg" style="left: 82%; animation-duration: 27s; animation-delay: 3s;">◈</span>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
