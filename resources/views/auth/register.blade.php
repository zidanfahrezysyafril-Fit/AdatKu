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
    </style>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-[#fff7e1] via-[#f4d890] to-[#cfa043] overflow-hidden">

    {{-- ORNAMEN NAIK --}}
    <span class="floating-icon from-bottom icon-md"
        style="left: 10%; animation-duration: 24s; animation-delay: 0s;">❖</span>
    <span class="floating-icon from-bottom icon-sm"
        style="left: 25%; animation-duration: 22s; animation-delay: 4s;">✿</span>
    <span class="floating-icon from-bottom icon-md"
        style="left: 55%; animation-duration: 26s; animation-delay: 2s;">❋</span>
    <span class="floating-icon from-bottom icon-sm"
        style="left: 75%; animation-duration: 28s; animation-delay: 6s;">✦</span>

    {{-- ORNAMEN TURUN --}}
    <span class="floating-icon from-top icon-sm"
        style="left: 18%; animation-duration: 26s; animation-delay: 1s;">❁</span>
    <span class="floating-icon from-top icon-md"
        style="left: 40%; animation-duration: 30s; animation-delay: 5s;">✺</span>
    <span class="floating-icon from-top icon-sm"
        style="left: 68%; animation-duration: 24s; animation-delay: 3s;">◈</span>

    {{-- KARTUN ADAT --}}
    <img src="{{ asset('foto kartun2.jpg') }}"
        class="hidden md:block fixed left-10 bottom-0 h-[310px] md:h-[330px] object-contain z-10">
    <img src="{{ asset('foto kartun2.jpg') }}"
        class="hidden md:block fixed right-10 bottom-0 h-[310px] md:h-[330px] object-contain z-10">


    {{-- WRAPPER CARD (lebih kecil & benar-benar tengah) --}}
    <div class="relative z-20 flex items-center justify-center min-h-screen px-4 py-2">
        <div class="w-full max-w-3xl bg-[#fffdf7]/95 rounded-[22px]
                    shadow-[0_16px_40px_rgba(190,143,43,0.28)]
                    border border-[#f4ddab] backdrop-blur-sm overflow-hidden">

            <div class="grid md:grid-cols-2">

                {{-- KOLOM KIRI: FORM --}}
                <div class="px-6 md:px-7 py-6 md:py-7 flex flex-col justify-center">

                    {{-- LOGO --}}
                    <div class="flex justify-center mb-4">
                        <div
                            class="flex items-center justify-center w-30 h-12 rounded-full border border-[#f4c970] bg-white shadow-md">
                            <img src="{{ asset('logos3.jpg') }}" class="h-9 object-contain" alt="Logo AdatKu">
                        </div>
                    </div>

                    {{-- TEKS ATAS --}}
                    <div class="text-center mb-4">
                        <h1 class="text-xl md:text-2xl font-bold text-[#d68e00]">AdatKu</h1>
                        <p class="text-[11px] md:text-xs text-[#c2983a]">
                            Buat akun untuk mulai menggunakan
                            <span class="font-semibold text-[#e6a400]">AdatKu</span>
                        </p>
                    </div>

                    {{-- FLASH ERROR --}}
                    @if (session('error'))
                        <div class="mb-3 p-2.5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-[11px]">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- FLASH SUCCESS --}}
                    @if (session('success'))
                        <div class="mb-3 p-2.5 bg-green-50 border border-green-200 text-green-700 rounded-xl text-[11px]">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- JUDUL --}}
                    <h2 class="text-center text-lg font-bold text-[#d68e00] mb-4">
                        Daftar Akun
                    </h2>

                    {{-- TOMBOL GOOGLE --}}
                    <a href="{{ route('google.login') }}" class="flex items-center justify-center gap-3 w-full py-2 mb-4
                              rounded-xl bg-white border border-[#efcd82] text-gray-700
                              font-semibold text-[11px] md:text-xs shadow-md hover:shadow-lg hover:bg-gray-50
                              transition-all duration-200">
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path fill="#FFC107"
                                d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                            <path fill="#FF3D00"
                                d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                            <path fill="#4CAF50"
                                d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                            <path fill="#1976D2"
                                d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                        </svg>
                        Daftar dengan Google
                    </a>

                    {{-- DIVIDER --}}
                    <div class="relative my-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-[#efcd82]"></div>
                        </div>
                        <div class="relative flex justify-center text-[10px]">
                            <span class="px-2 bg-[#fffdf7] text-[#a98225]">
                                atau daftar dengan email
                            </span>
                        </div>
                    </div>

                    {{-- FORM REGISTER --}}
                    <form action="{{ route('register.post') }}" method="POST" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block mb-1 text-[11px] font-medium text-[#a98225]">
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 text-[11px] text-gray-800 bg-[#fffdf7]
                                          border border-[#efcd82] rounded-xl focus:outline-none
                                          focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]
                                          @error('name') border-red-300 @enderror">
                            @error('name')
                                <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1 text-[11px] font-medium text-[#a98225]">
                                Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 text-[11px] text-gray-800 bg-[#fffdf7]
                                          border border-[#efcd82] rounded-xl focus:outline-none
                                          focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]
                                          @error('email') border-red-300 @enderror">
                            @error('email')
                                <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1 text-[11px] font-medium text-[#a98225]">
                                Password
                            </label>
                            <input type="password" name="password" required class="w-full px-3 py-2 text-[11px] text-gray-800 bg-[#fffdf7]
                                          border border-[#efcd82] rounded-xl focus:outline-none
                                          focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]
                                          @error('password') border-red-300 @enderror">
                            @error('password')
                                <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1 text-[11px] font-medium text-[#a98225]">
                                Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation" required class="w-full px-3 py-2 text-[11px] text-gray-800 bg-[#fffdf7]
                                          border border-[#efcd82] rounded-xl focus:outline-none
                                          focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                        </div>

                        <button type="submit" class="w-full py-2 text-[11px] font-semibold text-white
                                       rounded-xl shadow-lg bg-gradient-to-r from-[#f5c052] to-[#d09212]
                                       hover:brightness-110 transition-all duration-200">
                            Daftar
                        </button>
                    </form>

                    <p class="mt-4 text-[10px] text-center text-gray-700">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-[#d68e00] hover:underline">
                            Login
                        </a>
                    </p>

                    <p class="mt-3 text-[9px] text-center text-gray-500">
                        © 2025 AdatKu. Semua hak dilindungi.
                    </p>
                </div>

                {{-- KOLOM KANAN: TEKS --}}
                <div
                    class="hidden md:flex flex-col justify-center items-center bg-gradient-to-b from-[#fff8e1] to-[#f3cc75]">
                    <div class="px-7 text-center">
                        <h3 class="text-xl font-bold text-[#c27b00] mb-3">
                            Rayakan Adat dengan Cara Modern
                        </h3>
                        <p class="text-xs text-[#9b7b34] max-w-xs mx-auto">
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