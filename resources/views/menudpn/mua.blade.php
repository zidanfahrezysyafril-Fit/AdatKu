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
                    <!-- Judul brand dibuat emas gradasi -->
                    <h1
                        class="text-2xl logo-font bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent tracking-wide">
                        AdatKu
                    </h1>
                </a>
            </div>
            <!-- Link navbar pakai warna emas tua dan hover lebih cerah -->
            <nav class="hidden md:flex items-center gap-6 text-[18px] text-[#b48a00]">
                <a href="{{ 'home' }}" class="hover:text-[#eab308]">Beranda</a>
                <a href="/" class="hover:text-[#eab308]">Daftar MUA</a>
                <a href="#" class="hover:text-[#eab308]">Hubungi Kami</a>
            </nav>
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('auth') }}"
                        class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] text-white px-5 py-2 rounded-full font-Arial shadow-md hover:shadow-lg hover:from-[#f8e48c] hover:to-[#e0a100] transition">
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

    <!-- HERO -->
    <section class="relative">
        <img src="{{ asset('logoss3 .jpg') }}" alt="Hero AdatKu" class="w-full h-[580px] object-cover brightness-75">
        <div
            class="absolute inset-0 flex flex-col justify-center items-center text-center bg-gradient-to-b from-black/30 via-black/20 to-black/30">
            <!-- Judul & subjudul diganti jadi teks emas gradasi -->
            <h1 class="text-5xl md:text-6xl font-semibold mb-3">
                <span class="bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent drop-shadow-lg">
                    Selamat Datang di <span class="logo-font text-6xl md:text-7xl">AdatKu</span>
                </span>
            </h1>
            <p class="text-lg md:text-xl w-11/12 md:w-2/5">
                <span class="bg-gradient-to-r from-[#fff3b0] via-[#f5d547] to-[#d4a017] bg-clip-text text-transparent drop-shadow-md">
                    Temukan keindahan budaya dan tradisi melalui koleksi busana adat, rias, dan pelaminan terbaik.
                </span>
            </p>
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
