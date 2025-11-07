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
                <a href="{{ route('auth') }}"
                    class=" bg-red-200 text-[rgb(57,40,50)] px-5 py-2 rounded-full font-Arial hover:shadow-lg transition">Sign
                    In</a>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section class="relative">
        <img src="{{ asset('logos3.jpg') }}" alt="Hero AdatKu" class="w-full h-[580px] object-cover brightness-75">
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
                Daftar MUA
            </div>
            <!-- List Pilihan MUA -->
            <nav class="flex-1 overflow-auto p-4 space-y-2 text-gray-700">
                <button class="block w-full text-left py-2 px-3 rounded hover:bg-gray-200 transition"
                    onclick="showContent('dashboard')" id="menu-dashboard">MUA</button>
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
                mua: `<h2 class="text-2xl font-bold mb-4">Mua</h2><p>Daftar semua pengguna MUA.</p>`,
                users: `<h2 class="text-2xl font-bold mb-4">Users</h2><p>Daftar semua pengguna MUA.</p>`,
                anggota: `<h2 class="text-2xl font-bold mb-4">Anggota</h2><p>Profil anggota MUA yang terdaftar.</p>`,
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
