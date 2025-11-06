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
        body {font-family: 'Poppins', monospace, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}
        .logo-font {font-family: 'Perfecto Kaligrafi', 'Great Vibes', cursive;}
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
                <a href="/" class="hover:text-red-500">Beranda</a>
                <a href="{{ ('mua') }}" class=" hover:text-red-500">Daftar MUA</a>
                <a href="#" class="hover:text-red-500">Hubungi Kami</a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ route('auth') }}"
                    class=" bg-red-200 text-[rgb(57,40,50)] px-5 py-2 rounded-full font-Arial hover:shadow-lg transition">SignIn</a>
            </div>
        </div>
    </header>

    <section class="relative">
        <img src="{{ asset('logos3.jpg') }}" alt="Hero AdatKu" class="w-full h-[580px] object-cover brightness-75">
        <div
            class="absolute inset-0 flex flex-col justify-center items-center text-center text-red-200 bg-gradient-to-b from-black/30 via-black/20 to-black/30">
            <h1 class="text-5xl md:text-6xl font-semibold mb-3">Selamat Datang di <span
                    class="logo-font text-6xl md:text-7xl">AdatKu</span></h1>
            <p class="text-lg md:text-xl w-11/12 md:w-2/5">Temukan keindahan budaya dan tradisi melalui koleksi busana
                adat, rias, dan pelaminan terbaik.</p>
            <div class="mt-6 flex gap-4">
                <a href="#"
                    class="bg-red-200 text-[rgb(57,40,50)] px-6 py-3 rounded-full font-medium hover:scale-105 transition">Kunjungi
                    Toko</a>
                <a href="#"
                    class="border border-white-500 text-red-200 px-6 py-3 rounded-full hover:bg-red-500/10 transition">Pelajari
                    Lebih</a>
            </div>
        </div>
    </section>

    <!-- GALERI SECTION -->
    <main class="py-16">
        <!-- Baju Adat -->
        <section class="text-center mb-14">
            <h2 class="text-4xl font-bold tex mb-8 text-red-300">Baju Adat</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <img src="{{ asset('bajuminang.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg transition duration-300 ease-in-out hover:scale-105"
                    alt="Baju Minang">
                <img src="{{ asset('bajumelayu.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg transition duration-300 ease-in-out hover:scale-105"
                    alt="Baju Melayu">
                <img src="{{ asset('bajujawa.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg transition duration-300 ease-in-out hover:scale-105"
                    alt="Baju Jawa">
                <img src="{{ asset('bajusunda.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg transition duration-300 ease-in-out hover:scale-105"
                    alt="Baju Sunda">
            </div>
        </section>


        <!-- Make Up -->
        <section class="text-center mb-14">
            <h2 class="text-4xl font-bold mb-8 text-red-300">Make Up</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <img src="{{ asset('makeupjawa.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg card-img hover:scale-105" alt="Makeup Jawa">
                <img src="{{ asset('makeupnikah.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg card-img hover:scale-105" alt="Makeup Nikah">
                <img src="{{ asset('makeuplamaran.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg card-img hover:scale-105" alt="Makeup Lamaran">
                <img src="{{ asset('makeupwisuda.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg card-img hover:scale-105" alt="Makeup Wisuda">
            </div>
        </section>

        <!-- Pelamin -->
        <section class="text-center">
            <h2 class="text-4xl font-bold mb-8 text-green-900">Pelamin</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <img src="{{ asset('pelamin1.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg card-img hover:scale-105" alt="Pelamin 1">
                <img src="{{ asset('pelamin2.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg card-img hover:scale-105" alt="Pelamin 2">
                <img src="{{ asset('pelamin3.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg card-img hover:scale-105" alt="Pelamin 3">
                <img src="{{ asset('pelamin4.jpg') }}"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg card-img hover:scale-105" alt="Pelamin 4">
            </div>
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
</body>

</html>
