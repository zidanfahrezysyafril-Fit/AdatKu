<!DOCTYPE html>
<html lang="id" x-data="{ openSidebar: true, userMenu:false }">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Panel')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    body {
      background: #fff9f7;
    }

    .gold-btn {
      @apply text-white rounded-xl px-4 py-2 font-medium shadow-md transition;
    }
  </style>
</head>

<body class="text-slate-800">
  <div class="min-h-screen flex">

    <aside :class="openSidebar ? 'w-64' : 'w-16'"
      class="bg-white border-r border-rose-100 transition-all duration-200 sticky top-0 h-screen">
      <div class="p-4 flex items-center gap-3">
        <button @click="openSidebar = !openSidebar" class="p-2 rounded-lg hover:bg-rose-50">

          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 6h18v2H3V6Zm0 5h18v2H3v-2Zm0 5h18v2H3v-2Z" />
          </svg>
        </button>
        <span x-show="openSidebar" class="font-bold text-rose-700">AdatKu Admin</span>
      </div>

      <nav class="px-2 space-y-1">
        <a href="{{ route('admin.dashboard') }}"
          class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 @if(request()->routeIs('admin.dashboard')) bg-rose-50 text-rose-700 @endif">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 3 2 12h3v8h6v-6h2v6h6v-8h3z" />
          </svg>
          <span x-show="openSidebar">Dashboard</span>
        </a>
        <a href="{{ route('users.index') }}"
          class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 @if(request()->routeIs('users.*')) bg-rose-50 text-rose-700 @endif">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4 0-8 2-8 6v2h16v-2c0-4-4-6-8-6Z" />
          </svg>
          <span x-show="openSidebar">Users</span>
        </a>

        {{-- MENU BARU: Pesan Kontak --}}
        <a href="{{ route('admin.contact.index') }}"
          class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 @if(request()->routeIs('admin.contact.*')) bg-rose-50 text-rose-700 @endif">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
          </svg>
          <span x-show="openSidebar">Pesan Kontak</span>
        </a>

        <a href="{{ route('admin.mua-requests.index') }}"
          class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-rose-50 @if(request()->routeIs('admin.contact.*')) bg-rose-50 text-rose-700 @endif">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
          </svg>
          <span x-show="openSidebar">request MUA</span>
        </a>
      </nav>
    </aside>

    <div class="flex-1 flex flex-col">

      <header class="bg-white border-b border-rose-100">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
          <div>
            <h1 class="text-xl font-semibold">@yield('page_title', 'Dashboard')</h1>
            <p class="text-sm text-slate-500">@yield('page_desc')</p>
          </div>

          <div class="flex items-center gap-3 relative">
            <button @click="userMenu = !userMenu" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-rose-50">
              <img src="https://placehold.co/32x32" class="w-8 h-8 rounded-full" alt="">
              <span class="hidden sm:block">Admin</span>
            </button>

            <div x-show="userMenu" @click.outside="userMenu=false"
              class="absolute right-0 top-12 w-44 bg-white border border-rose-100 rounded-xl shadow p-2">
              <a href="#" class="block px-3 py-2 rounded-lg hover:bg-rose-50">Profile</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full mt-1 px-3 py-2 rounded-lg text-white
                               bg-gradient-to-r from-yellow-400 via-amber-400 to-orange-500 hover:opacity-90">
                  Logout
                </button>
              </form>
            </div>
          </div>
        </div>
      </header>

      <main class="max-w-7xl mx-auto w-full p-4 md:p-6">
        @yield('content')
      </main>
    </div>
  </div>
</body>

</html>