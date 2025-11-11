<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Autentikasi' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .animate-fadeInScale {
            animation: fadeInScale 0.4s ease-out;
        }

        body {
            background: linear-gradient(180deg, #fff7e6 0%, #fdeabf 55%, #c9a246ff 100%);
            background-attachment: fixed;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center text-[rgb(57,40,50)]">

    @if (session('success') || session('error'))
        <div x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="fixed inset-0 flex items-center justify-center z-[9999] animate-fadeInScale">

            <div
                class="rounded-2xl shadow-2xl px-6 py-4 text-white flex items-center gap-3 backdrop-blur-md
                @if (session('success')) bg-gradient-to-r from-[#f8e17a] via-[#eab308] to-[#c98a00]
                @else bg-gradient-to-r from-[#ef4444] via-[#dc2626] to-[#b91c1c] @endif">

                <svg class="w-7 h-7 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    @if (session('success'))
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    @endif
                </svg>

                <p class="text-base font-semibold tracking-wide text-center">
                    {{ session('success') ?? session('error') }}
                </p>

                <button class="ml-4 text-lg font-bold opacity-80 hover:opacity-100 transition"
                    @click="show = false">✕</button>
            </div>
        </div>
    @endif

    <main
        class="w-full max-w-md p-8 rounded-2xl shadow-2xl bg-white/90 backdrop-blur-sm border border-[#f5d547]/60 transition duration-300 ease-in-out hover:shadow-[0_0_40px_rgba(245,213,71,0.35)]">
        <div class="text-center mb-6">
            <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
                class="w-40 h-auto mx-auto rounded-full shadow-md border-2 border-[#f3d565]">
            <h1
                class="mt-4 text-3xl font-semibold tracking-wide bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
                AdatKu
            </h1>
            <p class="text-sm text-gray-700 mt-1">
                <span
                    class="bg-gradient-to-r from-[#fff3b0] via-[#f5d547] to-[#d4a017] bg-clip-text text-transparent">
                    Masuk untuk melanjutkan
                </span>
            </p>
        </div>

        <section class="space-y-4">
            @yield('content')
        </section>

        <footer class="mt-8 text-center text-xs text-gray-600">
            © 2025 AdatKu. Semua hak dilindungi.
        </footer>
    </main>

</body>
</html>
