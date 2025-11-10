<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MUA Panel — Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#fbf7f5] text-slate-800 font-sans">
  <div x-data="{ open: true }" class="min-h-screen">
    <!-- Topbar -->
    <header class="sticky top-0 z-40 bg-white shadow-sm">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center gap-4">
          <button @click="open = !open" class="lg:hidden inline-flex items-center justify-center rounded-md p-2 hover:bg-slate-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
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
          <div class="hidden md:flex items-center gap-3 text-sm text-slate-600">
            <div class="text-right">
              <div class="text-xs">Halo, <span class="font-medium">{{ auth()->user()->name ?? 'Admin' }}</span></div>
              <div class="text-[11px] text-slate-400">Admin Panel</div>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-white shadow flex items-center justify-center overflow-hidden">
              <img src="https://i.pravatar.cc/72" alt="avatar" class="w-full h-full object-cover" />
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex gap-6">
      <!-- Sidebar -->
      <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed lg:static inset-y-0 left-0 z-30 w-56 bg-[#2b2227] text-white transition-transform duration-200 rounded-tr-xl rounded-br-xl overflow-hidden">
        <div class="px-5 py-6">
          <h2 class="text-lg font-semibold">MUA Panel</h2>
        </div>
        <nav class="px-3 pb-6 space-y-1 text-sm">
          <a href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/15">
            <span class="ml-1">Dashboard</span>
          </a>
          <a href="{{ Route::has('users.index') ? route('users.index') : '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10">Users</a>
          <a href="{{ Route::has('settings') ? route('settings') : '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/10">Settings</a>
        </nav>
        <div class="mt-auto p-4 text-xs text-white/70">
          <div class="bg-white/5 rounded-md p-3">29°C — Berawan</div>
        </div>
      </aside>

      <!-- Main -->
      <main class="flex-1 lg:ml-2 py-8">
        <!-- Overview cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-sm text-slate-500">Total Users</p>
                <h2 class="mt-2 text-3xl font-extrabold text-rose-600">{{ number_format($totalUsers ?? 0) }}</h2>
              </div>
              <div class="rounded-full bg-rose-100 p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 7h18M3 12h18M3 17h18"/></svg>
              </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Jumlah pengguna yang terdaftar di sistem.</p>
          </div>

          <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-sm text-slate-500">Active Sessions</p>
                <h2 class="mt-2 text-3xl font-extrabold">{{ number_format($activeSessions ?? 0) }}</h2>
              </div>
              <div class="rounded-full bg-indigo-50 p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Sesi aktif saat ini (perkiraan).</p>
          </div>

          <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-sm text-slate-500">Revenue</p>
                <h2 class="mt-2 text-3xl font-extrabold text-amber-600">$ {{ number_format($revenue ?? 0, 0) }}</h2>
              </div>
              <div class="rounded-full bg-amber-50 p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/></svg>
              </div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Total pendapatan sampai periode ini.</p>
          </div>
        </div>

        <!-- Recent activity (nice table) -->
        <section class="mt-8 bg-white border border-slate-100 rounded-2xl shadow-sm">
          <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-semibold">Recent Activity</h3>
            <div class="text-sm text-slate-500">Lihat ringkasan aktivitas terbaru</div>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead class="bg-[#faf7f6]">
                <tr>
                  <th class="px-6 py-3 text-left font-medium text-slate-600">User</th>
                  <th class="px-6 py-3 text-left font-medium text-slate-600">Activity</th>
                  <th class="px-6 py-3 text-left font-medium text-slate-600">Date</th>
                </tr>
              </thead>
              <tbody>
                @forelse (($activities ?? []) as $row)
                  <tr class="border-t border-slate-100">
                    <td class="px-6 py-4">{{ $row['user'] }}</td>
                    <td class="px-6 py-4">{{ $row['activity'] }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($row['date'])->format('Y-m-d') }}</td>
                  </tr>
                @empty
                  <tr class="border-t border-slate-100">
                    <td class="px-6 py-6 text-slate-400" colspan="3">Belum ada aktivitas.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>

        <footer class="mt-8 text-xs text-slate-500">© {{ date('Y') }} AdatKu — MUA Panel</footer>
      </main>
    </div>
  </div>
</body>
</html>
