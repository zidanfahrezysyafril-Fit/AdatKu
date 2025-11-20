<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - AdatKu</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
        }
        /* ANIMASI ORNAMEN */
        @keyframes float-up {
            0% {
                transform: translateY(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            100% {
                transform: translateY(-140vh);
                opacity: 0;
            }
        }

        @keyframes float-down {
            0% {
                transform: translateY(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            100% {
                transform: translateY(140vh);
                opacity: 0;
            }
        }

        .floating-icon {
            position: fixed;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 0 12px rgba(255, 255, 255, 0.9);
            pointer-events: none;
            z-index: 1;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }

        .from-bottom {
            bottom: -12vh;
            animation-name: float-up;
        }

        .from-top {
            top: -12vh;
            animation-name: float-down;
        }

        .icon-sm {
            font-size: 18px;
        }

        .icon-md {
            font-size: 22px;
        }

        .icon-lg {
            font-size: 28px;
        }

        .icon-xl {
            font-size: 34px;
        }
    </style>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-[#fff7e1] via-[#f4d890] to-[#cfa043] overflow-hidden">

    {{-- ORNAMEN NAIK DARI BAWAH --}}
    <span class="floating-icon from-bottom icon-lg"
        style="left: 5%;  animation-duration: 22s; animation-delay: 0s;">❖</span>
    <span class="floating-icon from-bottom icon-xl"
        style="left: 15%; animation-duration: 28s; animation-delay: 3s;">✿</span>
    <span class="floating-icon from-bottom icon-md"
        style="left: 25%; animation-duration: 18s; animation-delay: 6s;">❋</span>
    <span class="floating-icon from-bottom icon-lg"
        style="left: 35%; animation-duration: 25s; animation-delay: 1s;">✦</span>
    <span class="floating-icon from-bottom icon-xl"
        style="left: 45%; animation-duration: 30s; animation-delay: 5s;">❁</span>
    <span class="floating-icon from-bottom icon-md"
        style="left: 55%; animation-duration: 20s; animation-delay: 7s;">✥</span>
    <span class="floating-icon from-bottom icon-lg"
        style="left: 65%; animation-duration: 26s; animation-delay: 2s;">◈</span>
    <span class="floating-icon from-bottom icon-xl"
        style="left: 75%; animation-duration: 24s; animation-delay: 4s;">❂</span>
    <span class="floating-icon from-bottom icon-md"
        style="left: 85%; animation-duration: 29s; animation-delay: 8s;">✺</span>

    {{-- ORNAMEN TURUN DARI ATAS --}}
    <span class="floating-icon from-top icon-lg"
        style="left: 12%; animation-duration: 26s; animation-delay: 1s;">❖</span>
    <span class="floating-icon from-top icon-xl"
        style="left: 22%; animation-duration: 32s; animation-delay: 4s;">✿</span>
    <span class="floating-icon from-top icon-md"
        style="left: 32%; animation-duration: 20s; animation-delay: 6s;">❋</span>
    <span class="floating-icon from-top icon-lg"
        style="left: 52%; animation-duration: 28s; animation-delay: 2s;">✦</span>
    <span class="floating-icon from-top icon-xl"
        style="left: 62%; animation-duration: 30s; animation-delay: 7s;">❁</span>
    <span class="floating-icon from-top icon-md"
        style="left: 72%; animation-duration: 22s; animation-delay: 9s;">✥</span>
    <span class="floating-icon from-top icon-lg"
        style="left: 82%; animation-duration: 27s; animation-delay: 3s;">◈</span>
    </style>
</head>


    {{-- KARTUN ADAT KIRI & KANAN --}}
    <img src="{{ asset('foto kartun2.jpg') }}"
        class="hidden md:block fixed left-10 bottom-0 h-[300px] object-contain z-10">
    <img src="{{ asset('foto kartun2.jpg') }}"
        class="hidden md:block fixed right-10 bottom-0 h-[300px] object-contain z-10">

    {{-- CARD REGISTER MELAYANG --}}
    <div class="relative z-20 flex items-center justify-center min-h-screen px-4 py-6">
        <div class="w-full max-w-4xl bg-[#fffdf7]/95 rounded-[28px]
                    shadow-[0_18px_55px_rgba(190,143,43,0.35)]
                    border border-[#f4ddab] backdrop-blur-md overflow-hidden
                    transform hover:-translate-y-1 transition-all duration-300">

            <div class="grid md:grid-cols-2">

                {{-- KOLOM KIRI: FORM --}}
                <div class="px-8 py-6 flex flex-col">

                    {{-- LOGO --}}
                    <div class="flex justify-center mb-3">
                        <div class="flex items-center justify-center w-40 h-14 rounded-full
                                    border border-[#f4c970] bg-white shadow-md">
                            <img src="{{ asset('logos3.jpg') }}" alt="Logo AdatKu" class="h-11 object-contain">
                        </div>
                    </div>

                    {{-- TEKS ATAS --}}
                    <div class="text-center mb-3">
                        <h1 class="text-xl md:text-2xl font-bold text-[#d68e00]">AdatKu</h1>
                        <p class="text-[12px] md:text-sm text-[#c2983a]">
                            Buat akun untuk mulai menggunakan
                            <span class="font-semibold text-[#e6a400]">AdatKu</span>
                        </p>
                    </div>

                    <h2 class="text-center text-lg font-bold text-[#d68e00] mb-3">
                        Daftar Akun
                    </h2>

                    {{-- TOMBOL GOOGLE --}}
                    <a href="{{ route('google.login') }}" class="flex items-center justify-center gap-3 w-full py-2.5 rounded-xl
                              bg-white border border-[#efcd82] text-gray-700 font-semibold text-sm
                              shadow-md hover:shadow-lg hover:bg-gray-50 transition-all duration-200 mb-3">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" alt="Google">
                        Daftar dengan Google
                    </a>

                    {{-- DIVIDER --}}
                    <div class="relative my-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-[#efcd82]"></div>
                        </div>
                        <div class="relative flex justify-center text-[11px]">
                            <span class="px-2 bg-[#fffdf7] text-[#a98225]">atau daftar dengan email</span>
                        </div>
                    </div>

                    {{-- FORM REGISTER --}}
                    <form method="POST" action="{{ route('register.post') }}" class="space-y-2.5">
                        @csrf

                        <div>
                            <label class="block text-[12px] font-medium text-[#a98225] mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                          px-3 py-2 text-[13px] text-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                        </div>

                        <div>
                            <label class="block text-[12px] font-medium text-[#a98225] mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                          px-3 py-2 text-[13px] text-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                        </div>

                        <div>
                            <label class="block text-[12px] font-medium text-[#a98225] mb-1">Password</label>
                            <input type="password" name="password" required class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                          px-3 py-2 text-[13px] text-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                        </div>

                        <div>
                            <label class="block text-[12px] font-medium text-[#a98225] mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                          px-3 py-2 text-[13px] text-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-[#f5c052] to-[#d09212]
                                       text-white font-semibold text-sm shadow-lg hover:brightness-110
                                       transition-all duration-200">
                            Daftar
                        </button>
                    </form>

                    {{-- LINK LOGIN & COPYRIGHT (DIPERKECIL) --}}
                    <p class="mt-3 text-center text-[11px] text-gray-700">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-[#d68e00] font-semibold hover:underline">
                            Login
                        </a>
                    </p>

                    <p class="mt-2 text-center text-[9px] text-gray-500">
                        © 2025 AdatKu. Semua hak dilindungi.
                    </p>
                </div>

                {{-- KOLOM KANAN: TEKS --}}
                <div class="hidden md:flex flex-col justify-center items-center
                            bg-gradient-to-b from-[#fff8e1] to-[#f3cc75] py-6 px-6">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-[#c27b00] mb-3">
                            Rayakan Adat dengan Cara Modern
                        </h3>
                        <p class="text-sm text-[#9b7b34] max-w-sm">
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