<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MUA Panel — Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#fff9f7] text-slate-800 min-h-screen overflow-x-hidden">
  <div x-data="{ open: true }" class="min-h-screen flex flex-col">
    
    <header class="fixed top-0 left-0 right-0 z-40 bg-white shadow-sm border-b border-rose-100">
      <div class="w-full px-8 h-16 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <button @click="open = !open" class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-amber-400 flex items-center justify-center text-white font-semibold shadow">M</div>
            <div>
              <p class="text-xs uppercase tracking-wide text-rose-600">MUA Panel</p>
              <h1 class="text-lg font-semibold">Dashboard</h1>
            </div>
          </div>
        </div>
        <div class="flex items-center gap-4">
          <p class="hidden md:block text-sm">Halo, <span class="font-medium text-rose-600">{{ auth()->user()->name ?? 'Admin' }}</span></p>
          <div class="w-9 h-9 rounded-full overflow-hidden border border-rose-100">
            <img src="https://i.pravatar.cc/72" class="object-cover w-full h-full" alt="avatar">
          </div>
        </div>
      </div>
    </header>

    <div class="flex flex-1 pt-16">
    
      <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="w-64 bg-[#2a2330] text-white transition-transform duration-200 flex-shrink-0 h-[calc(100vh-4rem)] fixed lg:static">
        <div class="flex flex-col h-full">
          <div class="px-6 py-6 border-b border-white/10">
            <h2 class="text-lg font-semibold">MUA Panel</h2>
          </div>
          <nav class="flex-1 px-4 py-3 space-y-1 text-sm">
            <a href="#" class="block px-4 py-2 rounded-lg bg-white/10 hover:bg-white/15 transition">Dashboard</a>
            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition">Users</a>
            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition">Settings</a>
          </nav>
          <div class="p-4 border-t border-white/10 text-xs text-white/80">
            <p>29°C — Berawan</p>
          </div>
        </div>
      </aside>

      <main class="flex-1 p-8 bg-[#fff9f7] min-h-screen overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="rounded-2xl bg-white p-6 shadow hover:shadow-md transition border border-rose-50">
            <p class="text-sm text-slate-500">Total Users</p>
            <h2 class="mt-2 text-4xl font-bold text-rose-600">{{ number_format($totalUsers ?? 0) }}</h2>
          </div>
          <div class="rounded-2xl bg-white p-6 shadow hover:shadow-md transition border border-indigo-50">
            <p class="text-sm text-slate-500">Active Sessions</p>
            <h2 class="mt-2 text-4xl font-bold text-indigo-600">{{ number_format($activeSessions ?? 0) }}</h2>
          </div>
          <div class="rounded-2xl bg-white p-6 shadow hover:shadow-md transition border border-amber-50">
            <p class="text-sm text-slate-500">Revenue</p>
            <h2 class="mt-2 text-4xl font-bold text-amber-600">$ {{ number_format($revenue ?? 0, 0) }}</h2>
          </div>
        </div>

        <section class="mt-10 bg-white shadow rounded-2xl border border-slate-100 overflow-hidden">
          <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-semibold">Recent Activity</h3>
            <div class="flex items-center gap-2 text-xs text-slate-500">
              <span class="h-2 w-2 bg-emerald-400 rounded-full"></span>
              Live
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-[#fdf6f5]">
                <tr>
                  <th class="px-6 py-3 text-left font-medium text-slate-600">User</th>
                  <th class="px-6 py-3 text-left font-medium text-slate-600">Activity</th>
                  <th class="px-6 py-3 text-left font-medium text-slate-600">Date</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse ($activities ?? [] as $row)
                  <tr class="hover:bg-rose-50/50 transition">
                    <td class="px-6 py-4">{{ $row['user'] }}</td>
                    <td class="px-6 py-4">{{ $row['activity'] }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($row['date'])->format('Y-m-d') }}</td>
                  </tr>
                @empty
                  <tr>
                    <td class="px-6 py-6 text-slate-400" colspan="3">Belum ada aktivitas.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>

        <footer class="mt-10 text-xs text-slate-500 text-center pb-8">© {{ date('Y') }} AdatKu — MUA Panel</footer>
      </main>
    </div>
  </div>
</body>
</html>