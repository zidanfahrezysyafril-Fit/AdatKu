<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdatKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[rgba(255,242,216,0.152)]">
    <!-- NAVBAR -->
<<<<<<< HEAD
    <header class="bg-[rgb(57,40,50)] text-[rgba(255,242,216,0.805)]">
        <div class="flex justify-between items-center px-10 py-3">
            {{-- <ul class="flex items-center gap-5"> --}}
                <img src="{{ asset('logosu.jpg') }}" alt="Logo" class="w-14 h-14 rounded-full object-cover">
                {{-- <li
                    class="list-none px-4 py-2 rounded-lg text-[20px] hover:bg-[rgba(240,248,255,0.364)] cursor-pointer">
                    <a href="#" class="text-[rgba(255,242,216,0.805)] font-serif">Beranda</a>
                </li>
                <li
                    class="list-none px-4 py-2 rounded-lg text-[20px] hover:bg-[rgba(240,248,255,0.364)] cursor-pointer">
                    <a href="{{ route('toko') }}" class="text-[rgba(255,242,216,0.805)] font-serif">Toko</a>
                </li>
                <li
                    class="list-none px-4 py-2 rounded-lg text-[20px] hover:bg-[rgba(240,248,255,0.364)] cursor-pointer">
                    <a href="#" class="text-[rgba(255,242,216,0.805)] font-serif">Hubungi Kami</a>
                </li>
            </ul> --}}

            <!-- Search -->
            {{-- <form action="hubungi kami.html" class="w-1/3">
                <input type="text" name="search" placeholder="S e a r c h.."
                    class="w-full border-2 border-[#d4af37] bg-white text-black rounded-full text-[15px] px-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#d4af37]" />

            </form> --}}

            <!-- Sign In -->
            <li
                class="list-none px-4 py-2 rounded-lg text-[20px] hover:bg-[rgba(240,248,255,0.364)] cursor-pointer font-serif">
                <a href="{{ route('auth') }}" class="text-[rgba(255,242,216,0.805)]">Sign In</a>
            </li>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <img src="logos3.jpg" alt="logo" class="w-full h-auto">

        {{-- <h1 class="text-center mt-5 text-[35px] pb-12 font-bold text-black font-serif">GALERI</h1> --}}
        <h1 class="text-center mt-5 text-[35px] pb-12 font-bold text-black font-serif">Baju Adat</h1>
        <div class="flex justify-center flex-wrap gap-1 mx-auto w-4/5">
            <div>
                <img src="bajuminang.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform" >
            </div>
            <div>
                <img src="bajumelayu.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
           <div>
                <img src="bajujawa.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform" >
            </div>
            <div>
                <img src="bajusunda.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
=======
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
                @auth
                    <a href="{{ ('mua') }}" class=" hover:text-red-500">Daftar MUA</a>
                @endauth
                <a href="#" class="hover:text-red-500">Hubungi Kami</a>
            </nav>
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('auth') }}"
                        class=" bg-red-200 text-[rgb(57,40,50)] px-5 py-2 rounded-full font-Arial hover:shadow-lg transition">Sign
                        In</a>
                @endguest
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <section class="relative">
        <img src="{{ asset('logoss3 .jpg') }}" alt="Hero AdatKu" class="w-full h-[580px] object-cover brightness-75">
        <div
            class="absolute inset-0 flex flex-col justify-center items-center text-center text-red-200 bg-gradient-to-b from-black/30 via-black/20 to-black/30">
            <h1 class="text-5xl md:text-6xl font-semibold mb-3 text-red-200">Selamat Datang di <span
                    class="logo-font text-6xl md:text-7xl">AdatKu</span></h1>
            <p class="text-lg md:text-xl w-11/12 md:w-2/5 text-red-200">Temukan keindahan budaya dan tradisi
                melalui koleksi busana
                adat, rias, dan pelaminan terbaik.</p>
            <div class="mt-6 flex gap-4">
                <a href="#"
                    class="border border-white-500 text-red-200 px-6 py-3 rounded-full hover:bg-red-500/10 transition">Pelajari
                    Lebih</a>
>>>>>>> d357a4052ae19e65fe0b0e967bdaff9c5465de25
            </div>
        </div>

        <h1 class="text-center mt-5 text-[35px] pb-12 font-bold text-black font-serif">Make Up</h1>
        <div class="flex justify-center flex-wrap gap-1 mx-auto w-4/5">
            <div>
                <img src="makeupjawa.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform" >
            </div>
            <div>
                <img src="makeupnikah.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
           <div>
                <img src="makeuplamaran.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform" >
            </div>
            <div>
                <img src="makeupwisuda.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
        </div>

        <h1 class="text-center mt-5 text-[35px] pb-12 font-bold text-black font-serif">Pelamin</h1>
        <div class="flex justify-center flex-wrap gap-1 mx-auto w-4/5 mb-6">
            <div>
                <img src="pelamin1.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform" >
            </div>
            <div>
                <img src="pelamin2.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
           <div>
                <img src="pelamin3.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform" >
            </div>
            <div>
                <img src="pelamin4.jpg" class="w-[290px] h-[290px] border-2 border-[#d4af37] rounded-xl shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
        </div>

    <!-- FOOTER -->
    <footer class="bg-red-200 text-[wheat] text-center py-45">
        <p>&copy; 2025 AdatKu</p>
        <img src="ig.png" alt="Instagram" class="w-12 h-10 rounded-full object-cover mx-auto mt-2">
    </footer>
</body>

</html>
