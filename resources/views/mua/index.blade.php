<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MUA Panel — Katalog MUA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.tailwindcss.min.css">
    <style>
        body {
            background-color: #fff9f7;
        }
    </style>
</head>

<body class="text-slate-800 min-h-screen overflow-x-hidden">
    <div x-data="{ open: true }" class="min-h-screen flex flex-col">

        <!-- HEADER -->
        <header class="fixed top-0 left-0 right-0 z-40 bg-white shadow-sm border-b border-rose-100">
            <div class="w-full px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button @click="open = !open"
                        class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-200 p-2 hover:bg-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-amber-400 flex items-center justify-center text-white font-semibold shadow">
                            M
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-rose-600">MUA Panel</p>
                            <h1 class="text-lg font-semibold">Katalog MUA</h1>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <p class="hidden md:block text-sm">Halo, <span
                            class="font-medium text-rose-600">{{ auth()->user()->name ?? 'Admin' }}</span></p>
                    <div class="w-9 h-9 rounded-full overflow-hidden border border-rose-100">
                        <img src="https://i.pravatar.cc/72" class="object-cover w-full h-full" alt="avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1 pt-16">

            <!-- SIDEBAR -->
            <aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="w-64 bg-[#2a2330] text-white transition-transform duration-200 flex-shrink-0 h-[calc(100vh-4rem)] fixed lg:static">
                <div class="flex flex-col h-full">
                    <div class="px-6 py-6 border-b border-white/10">
                        <h2 class="text-lg font-semibold">MUA Panel</h2>
                    </div>
                    <nav class="flex-1 px-4 py-3 space-y-1 text-sm">
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 rounded-lg hover:bg-white/10 transition">Dashboard</a>
                        <a href="{{ route('panelmua.index') }}"
                            class="block px-4 py-2 rounded-lg bg-white/10 hover:bg-white/15 transition">Katalog MUA</a>
                        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition">Settings</a>
                    </nav>
                    <div class="p-4 border-t border-white/10 text-xs text-white/80">
                        <p>29°C — Cerah Berawan</p>
                    </div>
                </div>
            </aside>

            <!-- MAIN CONTENT -->
            <main class="flex-1 p-8 bg-[#fff9f7] min-h-screen overflow-y-auto">

                <!-- HEADER TABLE -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-rose-700">Kelola Katalog MUA</h1>
                    <a href="#"
                        class="bg-gradient-to-r from-rose-500 to-amber-400 hover:opacity-90 text-white px-4 py-2 rounded-lg shadow font-medium">
                        + Tambah Item
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-emerald-100 text-emerald-700 px-4 py-3 rounded mb-4 border border-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- DATA TABLE -->
                <div class="bg-white rounded-2xl shadow border border-rose-50 overflow-hidden">
                    <div class="p-4">
                        <table id="catalogTable" class="min-w-full text-sm">
                            <thead class="bg-[#fdf6f5] text-slate-700">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium">Nama Usaha</th>
                                    <th class="px-4 py-3 text-left font-medium">Kontak WA</th>
                                    <th class="px-4 py-3 text-left font-medium">Rekening</th>
                                    <th class="px-4 py-3 text-left font-medium">Profil</th>
                                    <th class="px-4 py-3 text-center font-medium">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @php use Illuminate\Support\Str; @endphp

                                @php $adaItem = false; @endphp

                                @forelse($mua as $mua)
                                    @forelse($mua->layanan as $item)
                                        @php $adaItem = true; @endphp
                                        <tr class="hover:bg-rose-50 transition">
                                            <td class="px-4 py-2">{{ ucfirst($item->Kategori ?? '-') }}</td>
                                            <td class="px-4 py-2 font-medium text-slate-800">
                                                {{ $item->Nama_Layanan ?? '-' }}
                                                <div class="text-xs text-slate-500">MUA: {{ $mua->Nama_Usaha }}</div>
                                            </td>
                                            <td class="px-4 py-2 text-rose-600 font-semibold">
                                                @if(isset($item->Harga))
                                                    Rp {{ number_format($item->Harga, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-slate-600">
                                                {{ \Illuminate\Support\Str::limit($item->Deskripsi ?? '-', 50) }}
                                            </td>
                                            <td class="px-4 py-2 text-center space-x-2">
                                                {{-- GUNAKAN ROUTE LAYANAN kalau yang dikelola adalah layanan --}}
                                                <a href="{{ route('layanan.show', $item->id) }}"
                                                    class="text-blue-600 hover:underline font-medium">Detail</a>
                                                <a href="{{ route('layanan.edit', $item->id) }}"
                                                    class="text-amber-600 hover:underline font-medium">Edit</a>
                                                <form action="{{ route('layanan.destroy', $item->id) }}" method="POST"
                                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:underline font-medium">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- MUA ini belum punya layanan, lewati baris kosong --}}
                                    @endforelse
                                @empty
                                    {{-- Belum ada MUA sama sekali --}}
                                @endforelse

                                @if(!$adaItem)
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-slate-400">
                                            Belum ada item katalog ditambahkan.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>

                <footer class="mt-10 text-xs text-slate-500 text-center pb-8">
                    © {{ date('Y') }} AdatKu — MUA Panel
                </footer>
            </main>
        </div>
    </div>

    <!-- SCRIPT -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.tailwindcss.min.js"></script>
    <script>
        $.fn.dataTable.ext.errMode = 'none';
        $(function () {
            $('#catalogTable').DataTable({
                initComplete: function () {
                    $('select, input[type="search"], .pagination').each(function () {
                        this.className = this.className
                            .split(' ')
                            .filter(cls => !cls.startsWith('dark:'))
                            .join(' ');
                    });
                }
            });
        });
    </script>
</body>

</html>