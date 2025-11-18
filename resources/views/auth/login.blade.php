<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - AdatKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        @keyframes float-slow {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-16px); }
            100% { transform: translateY(0px); }
        }

        .float-1 {
            animation: float-slow 9s ease-in-out infinite;
        }
    </style>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-[#fff7e1] via-[#f4d890] to-[#cfa043] overflow-hidden">

    {{-- GAMBAR KARTUN ADAT KIRI --}}
    <img src="{{ asset('foto kartun.png') }}"
         alt="Kartun Adat Kiri"
         class="hidden md:block fixed left-10 bottom-0 h-96 object-contain z-0">

    {{-- GAMBAR KARTUN ADAT KANAN --}}
    <img src="{{ asset('images/adat-kanan.png') }}"
         alt="Kartun Adat Kanan"
         class="hidden md:block fixed right-10 bottom-0 h-96 object-contain z-0">

    {{-- ELEMEN DEKOR BULAT --}}
    <div class="absolute -left-10 top-10 w-40 h-40 bg-white/25 rounded-full blur-2xl float-1"></div>
    <div class="absolute right-[-30px] top-32 w-52 h-52 bg-[#fff3ce]/30 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-16 left-1/2 -translate-x-1/2 w-72 h-72 bg-white/15 rounded-full blur-3xl"></div>

    {{-- CARD LOGIN DI TENGAH --}}
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-4xl bg-[#fffdf7]/95 rounded-[32px]
                    shadow-[0_25px_60px_rgba(190,143,43,0.35)]
                    border border-[#f4ddab] backdrop-blur-sm overflow-hidden">

            <div class="grid md:grid-cols-2">

                {{-- KOLOM KIRI: FORM LOGIN --}}
                <div class="px-10 py-10 md:py-12 flex flex-col justify-center">
                    {{-- LOGO --}}
                    <div class="flex justify-center mb-6">
                        <div class="flex items-center justify-center w-40 h-16 rounded-full border border-[#f4c970] bg-white shadow-[0_10px_25px_rgba(0,0,0,0.1)]">
                            <img src="{{ asset('logos3.jpg') }}" alt="Logo AdatKu"
                                 class="h-12 object-contain rounded-md">
                        </div>
                    </div>

                    {{-- TEKS HEADER --}}
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold text-[#d68e00]">AdatKu</h1>
                        <p class="text-sm text-[#c2983a]">
                            Masuk untuk <span class="text-[#e6a400] font-semibold">melanjutkan</span>
                        </p>
                    </div>

                    <h2 class="text-center text-xl font-bold text-[#d68e00] mb-6">
                        Login
                    </h2>

                    {{-- FORM LOGIN --}}
                    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                        @csrf

                        {{-- EMAIL --}}
                        <div>
                            <label class="block text-sm font-medium text-[#a98225] mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                          px-3 py-3 text-sm text-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                        </div>

                        {{-- PASSWORD --}}
                        <div>
                            <label class="block text-sm font-medium text-[#a98225] mb-1">Password</label>
                            <input type="password" name="password" required
                                   class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                          px-3 py-3 text-sm text-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                        </div>

                        {{-- REMEMBER ME --}}
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <input type="checkbox" name="remember"
                                   class="rounded border-[#e4c26d] text-[#d09100] focus:ring-[#f6c453]">
                            <span>Remember me</span>
                        </div>

                        {{-- TOMBOL LOGIN --}}
                        <button type="submit"
                                class="w-full py-2.5 rounded-xl bg-gradient-to-r from-[#f5c052] to-[#d09212]
                                       text-white font-semibold text-sm
                                       shadow-[0_10px_25px_rgba(180,120,20,0.5)]
                                       hover:brightness-110 transition">
                            Login
                        </button>
                    </form>

                    {{-- LINK DAFTAR --}}
                    <p class="mt-5 text-center text-xs text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-[#d68e00] font-semibold hover:underline">
                            Daftar
                        </a>
                    </p>

                    {{-- FOOTER --}}
                    <p class="mt-6 text-center text-[10px] text-gray-500">
                        © 2025 AdatKu. Semua hak dilindungi.
                    </p>
                </div>

                {{-- KOLOM KANAN: TEKS SAJA --}}
                <div class="hidden md:flex flex-col justify-center items-center
                            bg-gradient-to-b from-[#fff8e1] to-[#f3cc75] relative">

                    <div class="absolute -top-8 right-6 w-32 h-32 bg-white/35 rounded-full blur-2xl float-1"></div>

                    <div class="relative z-10 px-8 text-center">
                        <h3 class="text-2xl font-bold text-[#c27b00] mb-3 drop-shadow-sm">
                            Rayakan Adat dengan Cara Modern
                        </h3>
                        <p class="text-sm text-[#9b7b34] leading-relaxed max-w-sm mx-auto">
                            Temukan MUA, baju adat, dan layanan adat terbaik di daerahmu —
                            cepat, mudah, dan modern.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
