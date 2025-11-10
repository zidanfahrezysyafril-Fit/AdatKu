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
                    <h1 class="text-2xl logo-font text-red-300 tracking-wide">AdatKu</h1>
                </a>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-[18px] text-red-300">
                <a href="{{ 'home' }}" class="hover:text-red-500">Beranda</a>
                <a href="/" class=" hover:text-red-500">Daftar MUA</a>
                <a href="#" class="hover:text-red-500">Hubungi Kami</a>
            </nav>
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('auth') }}"
                        class=" bg-red-200 text-[rgb(57,40,50)] px-5 py-2 rounded-full font-Arial hover:shadow-lg transition">Sign In</a>
                @endguest
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section class="relative">
        <img src="{{ asset('logoss3 .jpg') }}" alt="Hero AdatKu" class="w-full h-[580px] object-cover brightness-75">
        <div
            class="absolute inset-0 flex flex-col justify-center items-center text-center text-red-200 bg-gradient-to-b from-black/30 via-black/20 to-black/30">
            <h1 class="text-5xl md:text-6xl font-semibold mb-3">Selamat Datang di <span
                    class="logo-font text-6xl md:text-7xl">AdatKu</span></h1>
            <p class="text-lg md:text-xl w-11/12 md:w-2/5">Temukan keindahan budaya dan tradisi melalui koleksi busana
                adat, rias, dan pelaminan terbaik.</p>
        </div>
    </section>

    <!-- BAGIAN MENU DAN KONTEN -->
    <main class="max-w-9xl mx-auto px-6 py-10 flex space-x-6">
        <!-- Sidebar -->
        <aside class="w-60 bg-white shadow-md rounded-md border border-gray-200 flex flex-col">
            <div class="p-4 text-2xl font-bold border-b border-gray-300">
                Pilih
            </div>
            <!-- List Pilihan MUA -->
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
        // Fungsi untuk menampilkan konten sesuai menu yang dipilih
        function showContent(menu) {
            const contentArea = document.getElementById('content-area');
            const contentMap = {
                dashboard: `<h2 class="text-2xl font-bold mb-4">Pilih Mua yang tertera disini</h2>
                            <div class="flex gap-6">
                            <div class="w-64 bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <img src="https://pbs.twimg.com/profile_images/1978582245096165376/l-CxaLRm.jpg" 
                                    alt="Mitia" 
                                    class="cursor-pointer w-full h-64 object-cover rounded-lg" onclick="location.href='mua'">
                                <div class="p-3 text-center">
                                <h3 class="text-lg font-semibold text-gray-800">Mythia Batford</h3>
                                </div>
                            </div>
                            <div class="w-64 bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <img src="data:image/jpeg;base64,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" 
                                    alt="MUA Kedua" 
                                    class="cursor-pointer w-full h-64 object-cover rounded-lg">
                                <div class="p-3 text-center">
                                <h3 class="text-lg font-semibold text-gray-800">Maysa</h3>
                                </div>
                            </div>
                            <div class="w-64 bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <img src="ilham.jpg" 
                                    alt="MUA Kedua" 
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

            // Highlight menu aktif
            document.querySelectorAll('nav button').forEach(btn => {
                btn.classList.remove('bg-gray-300', 'font-bold');
            });
            const activeBtn = document.getElementById(`menu-${menu}`);
            if (activeBtn) {
                activeBtn.classList.add('bg-gray-300', 'font-bold');
            }
        }
    </script>

</body>

</html>