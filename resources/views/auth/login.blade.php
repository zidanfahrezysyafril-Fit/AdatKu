<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - AdatKu</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
        }

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
            font-size: 24px;
        }

        .icon-lg {
            font-size: 30px;
        }

        .icon-xl {
            font-size: 36px;
        }
    </style>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-[#fff7e1] via-[#f4d890] to-[#cfa043] overflow-hidden">

    {{-- ORNAMEN ADAT NAIK DARI BAWAH --}}
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

    {{-- ORNAMEN ADAT TURUN DARI ATAS --}}
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

    {{-- KARTUN ADAT KIRI & KANAN --}}
    <img src="{{ asset('foto kartun2.jpg') }}" alt="Kartun Adat Kiri"
        class="hidden md:block fixed left-10 bottom-0 h-[340px] object-contain z-10">

    <img src="{{ asset('foto kartun2.jpg') }}" alt="Kartun Adat Kanan"
        class="hidden md:block fixed right-10 bottom-0 h-[340px] object-contain z-10">

    {{-- CARD LOGIN --}}
    <div class="relative z-20 flex items-center justify-center min-h-screen px-4 py-8">
        <div class="w-full max-w-4xl bg-[#fffdf7]/95 rounded-[32px]
                    shadow-[0_25px_60px_rgba(190,143,43,0.35)]
                    border border-[#f4ddab] backdrop-blur-sm overflow-hidden">

            <div class="grid md:grid-cols-2">

                {{-- KOLOM KIRI: FORM LOGIN --}}
                <div class="px-10 py-10 md:py-12 flex flex-col justify-center">

                    {{-- LOGO --}}
                    <div class="flex justify-center mb-6">
                        <div
                            class="flex items-center justify-center w-40 h-16 rounded-full border border-[#f4c970] bg-white shadow-md">
                            <img src="{{ asset('logos3.jpg') }}" alt="Logo AdatKu" class="h-12 object-contain">
                        </div>
                    </div>

                    {{-- TEKS ATAS --}}
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold text-[#d68e00]">AdatKu</h1>
                        <p class="text-sm text-[#c2983a]">
                            Masuk untuk melanjutkan <span class="font-semibold text-[#e6a400]">AdatKu</span>
                        </p>
                    </div>

                    {{-- PESAN ERROR --}}
                    @if(session('error'))
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- PESAN SUCCESS --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="text-center text-xl font-bold text-[#d68e00] mb-6">Login</h2>

                    {{-- FORM LOGIN --}}
                    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                        @csrf

                        {{-- EMAIL --}}
                        <div>
                            <label class="block text-sm font-medium text-[#a98225] mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                px-3 py-3 text-sm text-gray-800
                                focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]
                                @error('email') border-red-300 @enderror">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div>
                            <label class="block text-sm font-medium text-[#a98225] mb-1">Password</label>
                            <input type="password" name="password" required 
                                class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                px-3 py-3 text-sm text-gray-800
                                focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]
                                @error('password') border-red-300 @enderror">
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- REMEMBER ME --}}
                        <div class="flex items-center justify-between text-xs text-gray-700">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember"
                                    class="rounded border-[#efcd82] text-[#f6c453] focus:ring-[#f6c453]">
                                <span>Remember me</span>
                            </label>
                        </div>

                        {{-- TOMBOL LOGIN --}}
                        <button type="submit"
                            class="w-full py-2.5 rounded-xl bg-gradient-to-r from-[#f5c052] to-[#d09212]
                            text-white font-semibold text-sm shadow-lg hover:brightness-110 transition-all duration-200">
                            Login
                        </button>
                    </form>

                    {{-- DIVIDER --}}
                    <div class="relative my-5">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-[#efcd82]"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-2 bg-[#fffdf7] text-[#a98225]">atau</span>
                        </div>
                    </div>

                    {{-- TOMBOL LOGIN GOOGLE --}}
                    <a href="{{ route('google.login') }}" 
                        class="flex items-center justify-center gap-3 w-full py-2.5 rounded-xl
                        bg-white border border-[#efcd82] text-gray-700 font-semibold text-sm
                        shadow-md hover:shadow-lg hover:bg-gray-50 transition-all duration-200">
                        <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path fill="#FFC107"
                                d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                            <path fill="#FF3D00"
                                d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                            <path fill="#4CAF50"
                                d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                            <path fill="#1976D2"
                                d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                        </svg>
                        Login dengan Google
                    </a>

                    {{-- LINK KE REGISTER --}}
                    <p class="mt-5 text-center text-xs text-gray-700">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-[#d68e00] font-semibold hover:underline">
                            Daftar
                        </a>
                    </p>

                    <p class="mt-6 text-center text-[10px] text-gray-500">
                        © 2025 AdatKu. Semua hak dilindungi.
                    </p>
                </div>

                {{-- KOLOM KANAN: TEKS --}}
                <div class="hidden md:flex flex-col justify-center items-center
                            bg-gradient-to-b from-[#fff8e1] to-[#f3cc75] relative">

                    <div class="relative z-10 px-8 text-center">
                        <h3 class="text-2xl font-bold text-[#c27b00] mb-3">
                            Rayakan Adat dengan Cara Modern
                        </h3>
                        <p class="text-sm text-[#9b7b34] max-w-sm mx-auto">
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