<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdatKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[rgba(255,242,216,0.15)] text-gray-900 font-">

    <!-- NAVBAR -->
    <header class="bg-[rgb(57,40,50)] text-[rgba(255,242,216,0.85)] shadow-md sticky top-0 z-50">
        <div class="flex justify-between items-center px-10 py-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logosu.jpg') }}" alt="Logo" class="w-14 h-14 rounded-full object-cover">
                <h1 class="text-2xl font-[Great_Vibes] tracking-wider">AdatKu</h1>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-[18px]">
                <a href="#" class="hover:text-[#d4af37] transition">Beranda</a>
                <a href="{{ route('toko') }}" class="hover:text-[#d4af37] transition">Toko</a>
                <a href="#" class="hover:text-[#d4af37] transition">Hubungi Kami</a>
            </nav>
            <a href="{{ route('auth') }}"
                class="border border-[#d4af37] px-5 py-2 rounded-full hover:bg-[#d4af37] hover:text-[rgb(57,40,50)] transition text-lg">
                Sign In
            </a>
        </div>
    </header>


    <section class="relative">
        <img src="logos3.jpg" alt="logo" class="w-full h-[580px] object-cover brightness-75">
        <div
            class="absolute inset-0 flex flex-col justify-center items-center text-center text-[rgba(255,242,216,0.95)] bg-black/30">
            <h1 class="text-5xl font-bold mb-3">Selamat Datang di AdatKu</h1>
            <p class="text-lg w-3/4 md:w-1/2">Temukan keindahan budaya dan tradisi melalui koleksi busana adat, rias,
                dan pelaminan
                terbaik.</p>
        </div>
    </section>

    <!-- GALERI SECTION -->
    <main class="py-16">

        <!-- Baju Adat -->
        <section class="text-center mb-14">
            <h2 class="text-4xl font-bold mb-8 text-[rgb(57,40,50)]">Baju Adat</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <img src="bajuminang.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
                <img src="bajumelayu.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
                <img src="bajujawa.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
                <img src="bajusunda.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
            </div>
        </section>

        <!-- Make Up -->
        <section class="text-center mb-14">
            <h2 class="text-4xl font-bold mb-8 text-[rgb(57,40,50)]">Make Up</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <img src="makeupjawa.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
                <img src="makeupnikah.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
                <img src="makeuplamaran.jpg"
                    class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition" alt="">
                <img src="makeupwisuda.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
            </div>
        </section>

        <!-- Pelamin -->
        <section class="text-center">
            <h2 class="text-4xl font-bold mb-8 text-[rgb(57,40,50)]">Pelamin</h2>
            <div class="flex flex-wrap justify-center gap-6">
                <img src="pelamin1.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
                <img src="pelamin2.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
                <img src="pelamin3.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
                <img src="pelamin4.jpg" class="w-[270px] h-[270px] rounded-2xl shadow-lg hover:scale-105 transition"
                    alt="">
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-[rgb(57,40,50)] text-[wheat] text-center py-2 mt-5">
        <p class="text-lg">&copy; 2025 AdatKu. All rights reserved.</p>
        <div class="flex justify-center mt-4 gap-4">
            <a href="#"><img src="ig.png" alt="Instagram"
                    class="w-10 h-10 rounded-full hover:scale-110 transition"></a>
            <a href="#"><img src="fb.png" alt="Facebook"
                    class="w-10 h-10 rounded-full hover:scale-110 transition"></a>
            <a href="#"><img src="wa.png" alt="WhatsApp"
                    class="w-10 h-10 rounded-full hover:scale-110 transition"></a>
        </div>
    </footer>

</body>

</html>
