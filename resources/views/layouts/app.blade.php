<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MUA Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slideIn {
            animation: slideIn 0.4s ease-out;
        }
    </style>
</head>

<body class="bg-pink-50 text-gray-800">
    @if (session('success') || session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="fixed top-5 right-5 z-[9999] max-w-sm animate-slideIn">
            <div
                class="rounded-xl shadow-2xl px-5 py-4 text-white flex items-start gap-3 backdrop-blur-sm
                @if (session('success')) bg-gradient-to-r from-[#f8e17a] via-[#eab308] to-[#c98a00]
                @else bg-gradient-to-r from-[#ef4444] via-[#dc2626] to-[#b91c1c] @endif">
                <svg class="w-6 h-6 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    @if (session('success'))
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    @endif
                </svg>
                <p class="text-sm leading-5 font-medium tracking-wide">
                    {{ session('success') ?? session('error') }}
                </p>
                <button class="ml-auto text-lg font-semibold opacity-70 hover:opacity-100 transition"
                    @click="show = false">✕</button>
            </div>
        </div>
    @endif

    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h1
                class="font-bold text-xl bg-gradient-to-r from-[#f8e17a] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
                MUA Panel
            </h1>
            <a href="/" class="text-gray-600 hover:text-[#eab308] font-medium transition">Dashboard</a>
        </header>

        <main class="flex-1 container mx-auto p-6">
            @yield('content')
        </main>

        <footer class="text-center py-4 text-gray-500 text-sm">
            © 2025 AdatKu — MUA Panel
        </footer>
    </div>
</body>

</html>
