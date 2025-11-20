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

    .justify-teks {
      text-align: justify;
      text-justify: inter-word;
    }

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

<body class="bg-[rgba(255,242,213,0.08)] text-gray-900" x-data="{ open:false, profileModal:false, editModal:false }">

  {{-- FLASH MESSAGE --}}
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

  {{-- HEADER --}}
  <header class="sticky top-0 z-50 bg-opacity-1 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <a href="/" class="flex items-center gap-3">
          <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu" class="w-14 h-14 rounded-full object-cover shadow-md">
          <h1
            class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
            AdatKu
          </h1>
        </a>
      </div>

      <nav class="hidden md:flex items-center gap-6 text-[18px] text-[#b48a00]">
        <a href="/" class="hover:text-[#eab308]">Beranda</a>
        @auth
          <a href="{{ 'daftarmua' }}" class="hover:text-[#eab308]">Daftar MUA</a>
        @endauth
        <a href="{{ 'hubungikami' }}" class="hover:text-[#eab308]">Hubungi Kami</a>
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

          @if ($user->role === 'Pengguna')
            <a href="{{ route('pengguna.pesanan.index') }}"
              class="hidden md:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-100 hover:bg-yellow-200 text-[#b48a00] font-semibold text-sm shadow-md">
              📦 Pesanan Saya
            </a>
          @endif

          {{-- DROPDOWN USER --}}
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
                  <button type="button" @click="profileModal = true; open = false"
                    class="w-full text-left px-4 py-2 hover:bg-gray-50">
                    Profil Saya
                  </button>
                </li>
                <li class="border-top">
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

  {{-- HERO --}}
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
        <a href="#" class="border border-white/70 text-white px-6 py-3 rounded-full hover:bg-white/10 transition">
          Pelajari Lebih
        </a>
      </div>
    </div>
  </section>

  {{-- SEKILAS --}}
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

  {{-- GALERI --}}
  <h1 class="flex flex-col items-center text-6xl text-bold logo-font text-[#5c2b33]">
    Galeri AdatKu
  </h1>

  <main class="py-16 space-y-28">
    {{-- BAGIAN 1 --}}
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

    {{-- BAGIAN 2 --}}
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

    {{-- BAGIAN 3 --}}
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

  {{-- ================= MODAL PROFIL & EDIT ================= --}}
  @auth
    @php
      $user = auth()->user();
      $avatarUrl = ($user->avatar ?? null)
        ? asset('storage/' . $user->avatar)
        : 'https://placehold.co/300x300?text=Profile';
    @endphp

    {{-- MODAL PROFIL SAYA --}}
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
          {{-- Ornamen belakang foto --}}
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

    {{-- MODAL EDIT PROFIL --}}
    <div x-show="editModal" x-cloak x-transition.opacity
      class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/45 backdrop-blur-sm">
      <div @click.outside="editModal = false" class="bg-white rounded-[32px] shadow-2xl border border-yellow-200/70
                    w-[92%] max-w-3xl p-8 md:p-10 relative">

        {{-- Tombol close --}}
        <button type="button" @click="editModal = false" class="absolute top-5 right-5 w-9 h-9 rounded-full bg-slate-100
                         hover:bg-slate-200 flex items-center justify-center text-slate-500">
          ✕
        </button>

        {{-- Ornamen sudut --}}
        <span class="absolute -left-3 top-10 text-yellow-100 text-4xl">❋</span>
        <span class="absolute right-8 -bottom-3 text-yellow-100 text-4xl rotate-45">✦</span>

        {{-- Judul --}}
        <h2 class="text-3xl md:text-4xl font-bold text-[#c98a00] mb-7">
          Edit Profil
        </h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @method('PUT')

          {{-- FOTO + INPUT FILE --}}
          <div class="flex flex-col sm:flex-row items-center gap-6 md:gap-8">
            <div class="relative flex items-center justify-center
                          w-28 h-28 sm:w-32 sm:h-32
                          rounded-full p-[3px]
                          bg-gradient-to-br from-[#f7e07b] via-[#eab308] to-[#c98a00]
                          shadow-xl">
              <div class="w-full h-full rounded-full overflow-hidden bg-slate-100">
                <img src="{{ $avatarUrl }}" alt="Foto Profil" class="w-full h-full object-cover">
              </div>

              {{-- ornamen kecil di samping foto --}}
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

          {{-- NAMA --}}
          <div class="pt-2">
            <label class="block text-sm font-medium text-slate-700 mb-1">
              Nama
            </label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3
                            text-sm md:text-base
                            focus:outline-none focus:ring-2 focus:ring-[#f5d547]
                            focus:border-[#c98a00]">
          </div>

          {{-- BUTTON --}}
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

  {{-- BUTTON DAFTARKAN MUA --}}
  <div class="fixed left-5 bottom-5 z-50">
    <a href="{{ route('login') }}" class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
              text-white px-6 py-3 rounded-full shadow-lg hover:shadow-xl
              hover:from-[#f8e48c] hover:to-[#e0a100] transition font-medium">
      Daftarkan jasa MUA kamu di sini
    </a>
  </div>

  {{-- ICON MELAYANG --}}
  <span class="floating-icon from-bottom icon-lg"
    style="left: 5%;  animation-duration: 22s; animation-delay: 0s;">❖</span>
  <span class="floating-icon from-bottom icon-xl"
    style="left: 15%; animation-duration: 28s; animation-delay: 3s;">✿</span>
  <span class="floating-icon from-bottom icon-md"
    style="left: 25%; animation-duration: 18s; animation-delay: 6s;">❋</span>
  <span class="floating-icon from-bottom icon-lg"
    style="left: 35%; animation-duration: 25s; animation-delay: 1s;">✦</span>
  <span class="floating-icon from-bottom icon-xl"
    style="left: 45%; animation-duration: 30s; animation-delay: 5s;">❁</span>
  <span class="floating-icon from-bottom icon-md"
    style="left: 55%; animation-duration: 20s; animation-delay: 7s;">✥</span>
  <span class="floating-icon from-bottom icon-lg"
    style="left: 65%; animation-duration: 26s; animation-delay: 2s;">◈</span>
  <span class="floating-icon from-bottom icon-xl"
    style="left: 75%; animation-duration: 24s; animation-delay: 4s;">❂</span>
  <span class="floating-icon from-bottom icon-md"
    style="left: 85%; animation-duration: 29s; animation-delay: 8s;">✺</span>

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