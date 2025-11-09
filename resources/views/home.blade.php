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
                    <h1 class="text-2xl logo-font text-[rgb(57,40,50)] tracking-wide">AdatKu</h1>
                </a>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-[18px] text-[rgb(57,40,50)]">
                <a href="/" class="hover:text-red-500">Beranda</a>
                <a href="{{ ('mua') }}" class="hidden hover:text-red-500">Daftar MUA</a>
                <a href="#" class="hover:text-red-500">Hubungi Kami</a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ route('auth') }}"
                    class=" bg-red-200 text-[rgb(57,40,50)] px-5 py-2 rounded-full font-Arial hover:shadow-lg transition">Sign In</a>
            </div>
        </div>
    </header>
    
    <section class="relative">
        <img src="{{ asset('logoss3 .jpg') }}" alt="Hero AdatKu" class="w-full h-[580px] object-cover brightness-75">
        <div
            class="absolute inset-0 flex flex-col justify-center items-center text-center text-red-200 bg-gradient-to-b from-black/30 via-black/20 to-black/30">
            <h1 class="text-5xl md:text-6xl font-semibold mb-3 text-[rgb(57,40,50)]">Selamat Datang di <span
                    class="logo-font text-6xl md:text-7xl">AdatKu</span></h1>
            <p class="text-lg md:text-xl w-11/12 md:w-2/5 text-[rgb(57,40,50)]">Temukan keindahan budaya dan tradisi melalui koleksi busana
                adat, rias, dan pelaminan terbaik.</p>
            <div class="mt-6 flex gap-4">
                <a href="#"
                    class="hidden bg-red-200 text-[rgb(57,40,50)] px-6 py-3 rounded-full font-medium hover:scale-105 transition">Kunjungi
                    Toko</a>
                <a href="#"
                    class="border border-white-500 text-[rgb(57,40,50)] px-6 py-3 rounded-full hover:bg-red-500/10 transition">Pelajari
                    Lebih</a>
            </div>
        </div>
    </section>
    {{-- keterangan adataku --}}
    <div class="object-cover space-y-2 my-10 mx-20">
        <h1 class="flex flex-col items-center text-4xl text-bold logo-font text-[rgb(57,40,50)]">Sekilas Tentang Adatku</h1>
        <a class="flex flex-col items-center justify-center text-lg text-gray-600">
            AdatKu adalah sebuah website berbasis digital yang dibuat untuk melestarikan budaya daerah Indonesia sekaligus
            mempermudah masyarakat dalam memesan layanan adat secara online.
            Website ini menggabungkan unsur kebudayaan tradisional dengan teknologi modern, sehingga menghadirkan pengalaman
            baru dalam mengenal dan menggunakan layanan adat seperti baju adat, make up (MUA), dan pelaminan.
        </a>
    </div>

    <!-- GALERI SECTION -->
    <h1 class="flex flex-col items-center text-6xl text-bold logo-font text-[rgb(57,40,50)]">Galeri AdatKu</h1>
    <main class="py-16 space-y-28">
        <!-- BAJU ADAT -->
        <section class="flex flex-col md:flex-row items-center justify-center md:space-x-16">
            <!-- Slider -->
            <div class="relative w-[460px] h-[340px] overflow-hidden rounded-2xl shadow-xl">
                <div class="flex w-[400%] animate-slide">
                    <img src="{{ asset('bajuminang.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Baju Minang">
                    <img src="{{ asset('bajumelayu.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Baju Melayu">
                    <img src="{{ asset('bajujawa.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Baju Jawa">
                    <img src="{{ asset('bajusunda.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Baju Sunda">
                </div>
            </div>
            <div class="mt-10 md:mt-0 md:w-[420px] text-center md:text-left">
                <h2 class="logo-font text-4xl font-bold text-red-300 mb-4">Baju Adat</h2>
                <p class="justify-teks text-gray-600 leading-relaxed text-lg">
                    Baju adat adalah simbol kebanggaan daerah dan identitas budaya. Setiap daerah di Indonesia memiliki
                    ciri khas tersendiri pada busana adatnya yang mencerminkan keindahan, filosofi, serta nilai-nilai luhur
                    masyarakat setempat.
                </p>
            </div>
        </section>
    
        <!-- MAKE UP -->
        <section class="flex flex-col md:flex-row-reverse items-center justify-center md:space-x-16 md:space-x-reverse">
            <!-- Slider -->
            <div class="relative w-[460px] h-[340px] overflow-hidden rounded-2xl shadow-xl">
                <div class="flex w-[400%] animate-slide">
                    <img src="{{ asset('makeupjawa.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Makeup Jawa">
                    <img src="{{ asset('makeupnikah.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Makeup Nikah">
                    <img src="{{ asset('makeuplamaran.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Makeup Lamaran">
                    <img src="{{ asset('makeupwisuda.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Makeup Wisuda">
                </div>
            </div>
            <div class="mt-10 md:mt-0 md:w-[420px] text-center md:text-right">
                <h2 class="logo-font text-4xl font-bold text-red-300 mb-4">Make Up</h2>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Seni rias atau make up berperan penting dalam mempercantik penampilan. Dari rias pengantin hingga
                    wisuda, setiap gaya memiliki karakteristik unik yang mempertegas keanggunan dan kepercayaan diri
                    seseorang.
                </p>
            </div>
        </section>
    
        <!-- PELAMINAN -->
        <section class="flex flex-col md:flex-row items-center justify-center md:space-x-16">
            <!-- Slider -->
            <div class="relative w-[460px] h-[340px] overflow-hidden rounded-2xl shadow-xl">
                <div class="flex w-[400%] animate-slide">
                    <img src="{{ asset('pelamin1.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Pelamin 1">
                    <img src="{{ asset('pelamin2.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Pelamin 2">
                    <img src="{{ asset('pelamin3.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Pelamin 3">
                    <img src="{{ asset('pelamin4.jpg') }}" class="w-1/4 h-[340px] object-cover" alt="Pelamin 4">
                </div>
            </div>
            <div class="mt-10 md:mt-0 md:w-[420px] text-center md:text-left">
                <h2 class="logo-font text-4xl font-bold text-red-300 mb-4">Pelaminan</h2>
                <p class="text-gray-600 leading-relaxed text-lg">
                    Pelaminan adalah simbol kebahagiaan dalam pernikahan. Setiap desain pelaminan menonjolkan kekayaan adat
                    dan keindahan budaya, menciptakan suasana yang megah dan sakral bagi pasangan pengantin.
                </p>
            </div>
        </section>
    </main>

<!-- ANIMASI SLIDER -->
<style>
@keyframes slide {
  0%, 20% { transform: translateX(0); }
  25%, 45% { transform: translateX(-25%); }
  50%, 70% { transform: translateX(-50%); }
  75%, 95% { transform: translateX(-75%); }
  100% { transform: translateX(0); }
}
.animate-slide {
  animation: slide 12s infinite ease-in-out;
}
</style>


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
