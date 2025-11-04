<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Autentikasi' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(0deg, #f9f4f4 10%, #ffc7c7 60%);
            background-attachment: fixed;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center text-[rgb(57,40,50)]">

    {{--halaman login/register --}}
    <main
        class="w-full max-w-md p-8 rounded-2xl shadow-2xl bg-white/90 backdrop-blur-sm border border-red-100 transition hover:shadow-red-400 duration-300 ease-in-out">

        {{-- Logo dan judul --}}
        <div class="text-center mb-6">
            <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                class="w-40 h-auto mx-auto rounded-full shadow-md border border-red-200">
            <h1 class="mt-4 text-3xl font-semibold tracking-wide text-red-600">AdatKu</h1>
            <p class="text-sm text-gray-600 mt-1">Masuk untuk melanjutkan</p>
        </div>

        {{-- Tempat konten form --}}
        <section class="space-y-4">
            @yield('content')
        </section>

        {{-- Footer kecil --}}
        <footer class="mt-8 text-center text-xs text-gray-500">
            &copy; 2025 AdatKu. Semua hak dilindungi.
        </footer>
    </main>

</body>

</html>
