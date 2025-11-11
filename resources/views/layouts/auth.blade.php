<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Autentikasi' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Latar hangat keemasan lembut */
        body {
            background: linear-gradient(180deg, #fff7e6 0%, #fdeabf 55%, #c9a246ff 100%);
            background-attachment: fixed;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center text-[rgb(57,40,50)]">

    {{-- halaman login/register --}}
    <main
        class="w-full max-w-md p-8 rounded-2xl shadow-2xl bg-white/90 backdrop-blur-sm border border-[#f5d547]/60 transition duration-300 ease-in-out hover:shadow-[0_0_40px_rgba(245,213,71,0.35)]">

        {{-- Logo dan judul --}}
        <div class="text-center mb-6">
            <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                class="w-40 h-auto mx-auto rounded-full shadow-md border-2 border-[#f3d565]">
            <!-- Judul brand: emas gradasi -->
            <h1
                class="mt-4 text-3xl font-semibold tracking-wide bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
                AdatKu
            </h1>
            <p class="text-sm text-gray-700 mt-1">
                <span class="bg-gradient-to-r from-[#fff3b0] via-[#f5d547] to-[#d4a017] bg-clip-text text-transparent">
                    Masuk untuk melanjutkan
                </span>
            </p>
        </div>

        {{-- Tempat konten form --}}
        <section class="space-y-4">
            @yield('content')
        </section>

        {{-- Footer kecil --}}
        <footer class="mt-8 text-center text-xs text-gray-600">
            &copy; 2025 AdatKu. Semua hak dilindungi.
        </footer>
    </main>

</body>

</html>
