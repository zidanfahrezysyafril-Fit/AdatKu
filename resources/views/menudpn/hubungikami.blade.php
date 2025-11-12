<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AdatKu</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .logo-font {
      font-family: 'Perfecto Kaligrafi', 'Great Vibes', cursive;
    }
    @keyframes slide {
      0%, 20% { transform: translateX(0); }
      25%, 45% { transform: translateX(-25%); }
      50%, 70% { transform: translateX(-50%); }
      75%, 95% { transform: translateX(-75%); }
      100% { transform: translateX(0); }
    }
    .animate-slide { animation: slide 12s infinite ease-in-out; }
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
          <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
            class="w-14 h-14 rounded-full object-cover shadow-md">
          <h1 class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">AdatKu</h1>
        </a>
      </div>
      <nav class="hidden md:flex items-center gap-6 text-[18px] text-[#b48a00]">
        <a href="/" class="hover:text-[#eab308]">Beranda</a>
        @auth
        <a href="{{ ('mua') }}" class="hover:text-[#eab308]">Daftar MUA</a>
        @endauth
        <a href="{{ ('hubungikami') }}" class="hover:text-[#eab308]">Hubungi Kami</a>
      </nav>
      <div class="flex items-center gap-3">
        @guest
        <a href="{{ route('auth') }}"
          class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-[#f8e48c] hover:to-[#e0a100] transition">
          Sign In
        </a>
        @endguest
        @auth
        <form action="{{ route('logout') }}" method="POST" class="inline">
          @csrf
          <button type="submit"
            class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:from-[#f8e48c] hover:to-[#e0a100] transition">
            Logout
          </button>
        </form>
        @endauth
      </div>
    </div>
  </header>

  <section class="relative">
    <img src="{{ asset('logoss3 .jpg') }}" alt="Hero AdatKu"
      class="w-full h-[580px] object-cover brightness-75">
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
    <!-- Konten -->
    <main class="max-w-6xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-10">
        <!-- Formulir -->
        <section class="md:col-span-2">
            <p class="text-slate-600 mb-2">
                Hubungi kami untuk kasus apapun yang berhubungan di dalam website AdatKU ini.
            </p>
            <p class="text-slate-600 mb-6">
                Kami akan secepatnya dan sebisa mungkin membantu Anda.
            </p>

            <form onsubmit="alert('Form ini masih statis ya — sambungkan ke backend kalau mau berfungsi.'); return false;" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm mb-1 font-medium">Nama *</label>
                        <input type="text" name="nama" required
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-400">
                    </div>
                    <div>
                        <label class="block text-sm mb-1 font-medium">Nomor Telepon</label>
                        <input type="tel" name="telepon" value="+62"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm mb-1 font-medium">Email *</label>
                    <input type="email" name="email" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-400">
                </div>

                <div>
                    <label class="block text-sm mb-1 font-medium">Subjek *</label>
                    <input type="text" name="subject" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-400">
                </div>

                <div>
                    <label class="block text-sm mb-1 font-medium">Pertanyaan *</label>
                    <textarea name="pesan" rows="5" required
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-400"></textarea>
                </div>

                <button type="submit"
                    class="px-5 py-3 bg-[rgba(255,178,12,0.15)] text-black rounded-xl hover:bg-[rgba(255,242,213,0.08)] transition font-medium shadow">
                    kirim keluhan
                </button>

            </form>
        </section>

        <!-- Info Perusahaan -->
    <aside class="md:pl-6">
    <h2 class="text-xl font-semibold mb-4">Kontak Kami</h2>
    <ul class="space-y-3 text-slate-700">
        <li class="flex items-start gap-3">
            <span>📍</span>
            <span>
                Adatku<br>
                <!-- Tambahkan link Instagram di sini -->
                <a href="https://www.instagram.com/_.adatku?igsh=Nm1mbWk2emx1cGZl "
                   target="_blank"
                   class="inline-flex items-center gap-2 text-rose-600 hover:text-rose-700 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                        <path d="M7 2C6.45 2 6 2.45 6 3V5H5C3.34 5 2 6.34 2 8V19C2 20.66 3.34 22 5 22H19C20.66 22 22 20.66 22 19V8C22 6.34 20.66 5 19 5H18V3C18 2.45 17.55 2 17 2H7ZM12 8C14.21 8 16 9.79 16 12C16 14.21 14.21 16 12 16C9.79 16 8 14.21 8 12C8 9.79 9.79 8 12 8Z"/>
                    </svg>
                    @AdatKU.id
                </a>
            </span>
        </li>

        <li class="flex items-center gap-3">
            <span>✉️</span>
            <a href="mailto:AdatKU@gmail.com" class="hover:underline">
                AdatKU@gmail.com
            </a>
        </li>
    </ul>
</aside>

