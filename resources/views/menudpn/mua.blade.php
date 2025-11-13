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
            font-family: 'Poppins', monospace, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }

        .logo-font {
            font-family: 'Perfecto Kaligrafi', 'Great Vibes', cursive;
        }
    </style>
</head>

<body class="bg-[rgba(255,242,213,0.08)] text-gray-900">

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-opacity-1 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                        class="w-14 h-14 rounded-full object-cover shadow-md">
                    <h1
                        class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent tracking-wide">
                        AdatKu
                    </h1>
                </a>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-[18px] text-[#b48a00]">
                <a href="{{ 'home' }}" class="hover:text-[#eab308]">Beranda</a>
                <a href="#" class="hover:text-[#eab308]">Daftar MUA</a>
                <a href="{{ ('hubungikami') }}" class="hover:text-[#eab308]">Hubungi Kami</a>
            </nav>
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('auth') }}"
                        class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white px-5 py-2 rounded-full font-Arial shadow-md hover:shadow-lg hover:from-[#f8e48c] hover:to-[#e0a100] transition">
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
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-50">Profil
                                        Saya</a>
                                </li>
                                <li class="border-t">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
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

    <!-- HERO -->
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
            <p class="text-lg md:text-xl w-11/12 md:w-2/5">
                <span
                    class="bg-gradient-to-r from-[#fff3b0] via-[#f5d547] to-[#d4a017] bg-clip-text text-transparent drop-shadow-md">
                    Temukan keindahan budaya dan tradisi melalui koleksi busana adat, rias, dan pelaminan terbaik.
                </span>
            </p>
        </div>
    </section>

    <main class="max-w-9xl mx-auto px-6 py-10 flex space-x-6">
        <aside class="w-60 bg-white shadow-md rounded-md border border-gray-200 flex flex-col">
            <div class="p-4 text-2xl font-bold border-b border-gray-300">
                Pilih
            </div>
            <nav class="flex-1 overflow-auto p-4 space-y-2 text-gray-700">
                <button class="block w-full text-left py-2 px-3 rounded hover:bg-gray-200 transition"
                    onclick="showContent('dashboard')" id="menu-dashboard">Dashboard</button>
                <button class="block w-full text-left py-2 px-3 rounded hover:bg-gray-200 transition"
                    onclick="showContent('mua')" id="menu-mua">MUA</button>
            </nav>
        </aside>

        <!-- Konten Menu -->
        <section class="flex-1 bg-white rounded-md shadow-md border p-6 min-h-[300px]" id="content-area">
            <p class="text-gray-600 text-lg leading-relaxed">
                Pilih menu dari daftar di sebelah kiri untuk menampilkan isi disini.
            </p>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-[rgb(57,40,50)] text-[wheat] text-center py-6 mt-10">
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

    <script>
        function showContent(menu) {
            const contentArea = document.getElementById('content-area');
            const contentMap = {
                dashboard: `<h2 class="text-2xl font-bold mb-4">Pilih Mua yang tertera disini</h2>
                            <div class="flex gap-6">
                            <div class="w-64 bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <img src="" 
                                    alt="Mitia" 
                                    class="cursor-pointer w-full h-64 object-cover rounded-lg" onclick="location.href='mua'">
                                <div class="p-3 text-center">
                                <h3 class="text-lg font-semibold text-gray-800">Mythia Batford</h3>
                                </div>
                            </div>
                            <div class="w-64 bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <img src="" 
                                    alt="MUA Kedua" 
                                    class="cursor-pointer w-full h-64 object-cover rounded-lg">
                                <div class="p-3 text-center">
                                <h3 class="text-lg font-semibold text-gray-800">Maysa</h3>
                                </div>
                            </div>
                            <div class="w-64 bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <img src="" 
                                    alt="MUA Ketiga" 
                                    class="cursor-pointer w-full h-64 object-cover rounded-lg" onclick="location.href='https://www.instagram.com/ilhamfad1llah?igsh=bHJ1Mjg1eTFrb2F6'">
                                <div class="p-3 text-center">
                                <h3 class="text-lg font-semibold text-gray-800">Ilham Fadillah</h3>
                                </div>
                            </div>
                            </div>`,
                mua: `<h2 class="text-2xl font-bold mb-4">Anggota</h2><p>Profil MUA yang terdaftar.</p>`,
                kegiatan: `<h2 class="text-2xl font-bold mb-4">Kegiatan</h2><p>Informasi kegiatan MUA terbaru.</p>`
            };

            contentArea.innerHTML = contentMap[menu] || `<p>Konten tidak tersedia.</p>`;


            document.querySelectorAll('nav button').forEach(btn => {
                btn.classList.remove('bg-gray-300', 'font-bold');
            });
            const activeBtn = document.getElementById(`menu-${menu}`);
            if (activeBtn) {
                activeBtn.classList.add('bg-gray-300', 'font-bold');
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>