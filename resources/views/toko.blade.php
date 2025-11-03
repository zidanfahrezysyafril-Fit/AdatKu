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
    <header class="bg-[rgb(57,40,50)] text-[rgba(255,242,216,0.805)]">
        <div class="flex justify-between items-center px-10 py-3">
            <ul class="flex items-center gap-5">
                <img src="{{ asset('logosu.jpg') }}" alt="Logo" class="w-14 h-14 rounded-full object-cover">
                <li
                    class="list-none px-4 py-2 rounded-lg text-[20px] hover:bg-[rgba(240,248,255,0.364)] cursor-pointer">
                    <a href="#" class="text-[rgba(255,242,216,0.805)] font-serif">Beranda</a>
                </li>
                <li
                    class="list-none px-4 py-2 rounded-lg text-[20px] hover:bg-[rgba(240,248,255,0.364)] cursor-pointer">
                    <a href="toko.blade.php" class="text-[rgba(255,242,216,0.805)] font-serif">Toko</a>
                </li>
                <li
                    class="list-none px-4 py-2 rounded-lg text-[20px] hover:bg-[rgba(240,248,255,0.364)] cursor-pointer">
                    <a href="#" class="text-[rgba(255,242,216,0.805)] font-serif">Hubungi Kami</a>
                </li>
            </ul>

            <!-- Search -->
            <form action="hubungi kami.html" class="w-1/3">
                <input type="text" name="search" placeholder="S e a r c h.."
                    class="w-full border-2 border-[#d4af37] bg-white text-black rounded-full text-[15px] px-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#d4af37]" />

            </form>

            <!-- Sign In -->
            <li
                class="list-none px-4 py-2 rounded-lg text-[20px] hover:bg-[rgba(240,248,255,0.364)] cursor-pointer font-serif">
                <a href="#" class="text-[rgba(255,242,216,0.805)]">Sign In</a>
            </li>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <img src="logos3.jpg" alt="logo" class="w-full h-auto">

        <!-- GALERI -->
        <h1 class="text-center mt-5 text-[35px] pb-12 font-bold text-black font-serif">GALERI</h1>
        <div class="flex justify-center flex-wrap gap-16 mx-auto w-4/5">
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
        </div>

        <!-- ULASAN -->
        <h1 class="text-center mt-5 text-[35px] pb-12 font-bold text-black font-serif">ULASAN</h1>
        <div class="flex justify-center flex-wrap gap-16 mx-auto w-4/5">
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
        </div>

        <!-- TENTANG -->
        <h1 class="text-center mt-5 text-[35px] pb-12 font-bold text-black font-serif">TESTIMONI</h1>
        <div class="flex justify-center flex-wrap gap-16 mx-auto w-4/5 mb-16">
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
            <div
                class="w-[250px] h-[250px] border-2 border-[#d4af37] rounded-lg shadow-lg bg-[#fafafa] hover:scale-105 transition-transform">
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-[rgb(57,40,50)] text-[wheat] text-center py-6">
        <p>&copy; 2025 AdatKu</p>
        <img src="ig.png" alt="Instagram" class="w-12 h-10 rounded-full object-cover mx-auto mt-2">
    </footer>
</body>

</html>
