<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MUA Panel — Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    body {
      background-color: #fff9f7;
    }
  </style>
</head>

<body class="text-slate-800 min-h-screen overflow-x-hidden" x-data="{ open: false }">

<<<<<<< HEAD
    <header class="fixed top-0 left-0 right-0 z-40 bg-white shadow-sm border-b border-rose-100">
      <div class="w-full px-8 h-16 flex items-center justify-between">
=======
  <!-- HEADER -->
  <header class="fixed top-0 inset-x-0 z-40 bg-white shadow-sm border-b border-rose-100">
    <div class="px-6 h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <button @click="open = !open"
          class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 hover:bg-slate-100">
          <!-- menu -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
>>>>>>> c1ac103379dd8439165f51df7483edc0475a88b3
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-amber-400 flex items-center justify-center text-white font-semibold shadow">
            M</div>
          <div>
            <p class="text-xs uppercase tracking-wide text-rose-600">MUA Panel</p>
            <h1 class="text-lg font-semibold">Dashboard</h1>
          </div>
        </div>
      </div>
      <div class="flex items-center gap-4">
        <p class="hidden md:block text-sm">Halo, <span
            class="font-medium text-rose-600">{{ auth()->user()->name ?? 'Admin' }}</span></p>
        <img src="https://i.pravatar.cc/72" class="w-9 h-9 rounded-full border border-rose-100 object-cover"
          alt="avatar">
      </div>
    </div>
  </header>

  <!-- SIDEBAR -->
  <aside class="fixed z-30 top-16 left-0 w-72 h-[calc(100vh-4rem)] bg-[#231b27] text-white border-r border-white/10"
    :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" x-transition.opacity
    x-transition.duration.200ms>
    <div class="flex flex-col h-full">
      <div class="px-6 py-4 border-b border-white/10">
        <h2 class="text-base font-semibold tracking-wide text-white/90">MUA Panel</h2>
      </div>
<<<<<<< HEAD
=======

<<<<<<< HEAD
      <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="w-64 bg-[#2a2330] text-white transition-transform duration-200 flex-shrink-0 h-[calc(100vh-4rem)] fixed lg:static">
        <div class="flex flex-col h-full">
          <div class="px-6 py-6 border-b border-white/10">
            <h2 class="text-lg font-semibold">MUA Panel</h2>
          </div>
          <nav x-data="{ openMua:false, openKatalog:false }" class="flex-1 px-4 py-3 space-y-1 text-sm">
            <a href="{{ route('dashboard') }}"
              class="block px-4 py-2 rounded-lg bg-white/10 hover:bg-white/15 transition">Dashboard</a>

            <button @click="openMua = !openMua"
              class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-white/10 transition">
              <span>MUA</span>
              <svg :class="openMua ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                  clip-rule="evenodd" />
=======
      <!-- NAV -->
>>>>>>> 7d59410c0775ab1ca146a391d0702dcb816aedc2
      <nav class="flex-1 px-3 py-4 text-sm space-y-1">
        <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl
                  hover:bg-white/10 transition
                  {{ request()->routeIs('dashboard') ? 'bg-white/10 ring-1 ring-white/10' : '' }}">
          <svg class="w-4 h-4 opacity-80 group-hover:opacity-100" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 3l9 8h-3v10H6V11H3l9-8z" />
          </svg>
          <span>Dashboard</span>
        </a>

        <div x-data="{ openMua: {{ request()->routeIs('panelmua.*') ? 'true' : 'false' }} }" class="pt-1">
          <button @click="openMua = !openMua"
            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl hover:bg-white/10 transition">
            <span class="flex items-center gap-3">
              <svg class="w-4 h-4 opacity-80" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 0116 0H4z" />
>>>>>>> c1ac103379dd8439165f51df7483edc0475a88b3
              </svg>
              <span>MUA</span>
            </span>
            <svg :class="openMua ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" viewBox="0 0 20 20"
              fill="currentColor">
              <path fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                clip-rule="evenodd" />
            </svg>
          </button>

<<<<<<< HEAD
            <div x-show="openMua" x-collapse class="ml-2 pl-3 border-l border-white/10 space-y-1">
              <a href="{{ route('panelmua.index') }}" class="block px-3 py-2 rounded-md hover:bg-white/10">
                Profil MUA
              </a>

              <button @click="openKatalog = !openKatalog"
                class="w-full flex items-center justify-between px-3 py-2 rounded-md hover:bg-white/10">
                <span>Katalog Layanan</span>
                <svg :class="openKatalog ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" viewBox="0 0 20 20"
                  fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                    clip-rule="evenodd" />
                </svg>
              </button>

              <div x-show="openKatalog" x-collapse class="ml-2 pl-3 border-l border-white/10 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-white/10">Baju Adat</a>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-white/10">Makeup</a>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-white/10">Pelamin</a>
              </div>
            </div>
          </nav>

          <div class="p-4 border-t border-white/10 text-xs text-white/80">
            <p>29°C — Cerah Berawan</p>
=======
          <div x-show="openMua" x-collapse class="ml-2 pl-4 my-1 border-l border-white/10 space-y-1">
            <a href="{{ route('panelmua.index') }}" class="block px-3 py-2 rounded-lg hover:bg-white/10
                      {{ request()->routeIs('panelmua.index') ? 'bg-white/10 ring-1 ring-white/10' : '' }}">
              Profil MUA
            </a>
            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-white/10">Katalog</a>
<<<<<<< HEAD
            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-white/10">Transaksi</a>
=======
            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-white/10">Pesanan</a>
>>>>>>> c1ac103379dd8439165f51df7483edc0475a88b3
>>>>>>> 7d59410c0775ab1ca146a391d0702dcb816aedc2
          </div>
        </div>
      </nav>

      <div class="mt-auto p-4 border-t border-white/10 text-xs text-white/70">
        29°C — Cerah Berawan
      </div>
    </div>
  </aside>

  {{-- konten --}}
  <main class="pt-16 lg:pl-72">
    <div class="max-w-5xl mx-auto px-4 py-8">
<<<<<<< HEAD
      <main class="flex-1 p-8 bg-[#fff9f7] min-h-screen overflow-y-auto">
=======
      <!-- … taruh seluruh konten form kamu di sini (bagian Media, Informasi Utama, Sosial Media, dll) … -->


      <main class="flex-1 p-8 bg-[#fff9f7] min-h-screen overflow-y-auto">

<<<<<<< HEAD
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
=======
        <!-- KARTU STATISTIK -->
>>>>>>> 7d59410c0775ab1ca146a391d0702dcb816aedc2
        <div class="grid grid-cols-1 md:grid-cols-3 gap-9">
>>>>>>> c1ac103379dd8439165f51df7483edc0475a88b3
          <div class="rounded-2xl bg-white p-6 shadow hover:shadow-md transition border border-rose-50">
            <p class="text-sm text-slate-500">Total Baju Adat</p>
            <h2 class="mt-2 text-4xl font-bold text-rose-600">{{ number_format($totalBajuAdat ?? 0) }}</h2>
          </div>
          <div class="rounded-2xl bg-white p-6 shadow hover:shadow-md transition border border-amber-50">
            <p class="text-sm text-slate-500">Total Makeup</p>
            <h2 class="mt-2 text-4xl font-bold text-amber-600">{{ number_format($totalMakeup ?? 0) }}</h2>
          </div>
          <div class="rounded-2xl bg-white p-6 shadow hover:shadow-md transition border border-fuchsia-50">
            <p class="text-sm text-slate-500">Total Pelamin</p>
            <h2 class="mt-2 text-4xl font-bold text-fuchsia-600">{{ number_format($totalPelamin ?? 0) }}</h2>
          </div>
        </div>
<<<<<<< HEAD
=======

>>>>>>> 7d59410c0775ab1ca146a391d0702dcb816aedc2
        <section class="mt-10">
          <h2 class="text-xl font-semibold text-rose-700 mb-4">Atur Katalog MUA Anda</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-pink-50 border border-pink-200 rounded-xl p-6 text-center hover:shadow-lg transition">
              <h3 class="text-lg font-semibold text-pink-700 mb-2">Katalog Baju Adat</h3>
              <p class="text-gray-600 text-sm mb-4">Tambahkan atau kelola koleksi baju adat.</p>
              <a href="#" class="inline-block px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">
                + Tambah Baju Adat
              </a>
            </div>

            <div class="bg-rose-50 border border-rose-200 rounded-xl p-6 text-center hover:shadow-lg transition">
              <h3 class="text-lg font-semibold text-rose-700 mb-2">Katalog Makeup</h3>
              <p class="text-gray-600 text-sm mb-4">Kelola berbagai jenis makeup profesional Anda.</p>
              <a href="#" class="inline-block px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition">
                + Tambah Makeup
              </a>
            </div>

            <div class="bg-fuchsia-50 border border-fuchsia-200 rounded-xl p-6 text-center hover:shadow-lg transition">
              <h3 class="text-lg font-semibold text-fuchsia-700 mb-2">Dekorasi Pelamin</h3>
              <p class="text-gray-600 text-sm mb-4">Atur dan tampilkan dekorasi pelamin adat Anda.</p>
              <a href="#"
                class="inline-block px-4 py-2 bg-fuchsia-600 text-white rounded-lg hover:bg-fuchsia-700 transition">
                + Tambah Pelamin
              </a>
            </div>
          </div>
        </section>

        <footer class="mt-10 text-xs text-slate-500 text-center pb-8">
          © {{ date('Y') }} AdatKu — MUA Panel
        </footer>

      </main>
    </div>
    </div>
</body>

</html>