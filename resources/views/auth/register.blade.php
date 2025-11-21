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

        /* Popup Fade */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn .25s ease-out;
        }
    </style>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-[#fff7e1] via-[#f4d890] to-[#cfa043] overflow-x-hidden">

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

    {{-- KARTUN ADAT (RESPONSIF) --}}
    <img src="{{ asset('foto kartun2.jpg') }}"
        class="block fixed left-1 bottom-0 h-[120px] sm:left-4 sm:h-[170px] md:left-10 md:h-[260px] lg:h-[300px] object-contain z-10">
    <img src="{{ asset('foto kartun2.jpg') }}"
        class="block fixed right-1 bottom-0 h-[120px] sm:right-4 sm:h-[170px] md:right-10 md:h-[260px] lg:h-[300px] object-contain z-10">

    {{-- CARD REGISTER --}}
    <div class="relative z-20 flex items-center justify-center min-h-screen px-4 py-6 sm:px-6">
        <div class="w-full max-w-4xl bg-[#fffdf7]/95 rounded-[28px]
                    shadow-[0_18px_55px_rgba(190,143,43,0.35)]
                    border border-[#f4ddab] backdrop-blur-md overflow-hidden
                    transform hover:-translate-y-1 transition-all duration-300">

            <div class="grid md:grid-cols-2">

                {{-- KIRI: FORM REGISTER --}}
                <div class="px-5 py-6 sm:px-8 flex flex-col">

                    {{-- LOGO --}}
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center w-32 h-12 sm:w-40 sm:h-14 rounded-full
                                    border border-[#f4c970] bg-white shadow-md">
                            <img src="{{ asset('logos3.jpg') }}" class="h-9 sm:h-11 object-contain">
                        </div>
                    </div>

                    {{-- TEKS ATAS --}}
                    <div class="text-center mb-3 sm:mb-4">
                        <h1 class="text-xl sm:text-2xl font-bold text-[#d68e00]">AdatKu</h1>
                        <p class="text-xs sm:text-sm text-[#c2983a]">
                            Buat akun untuk mulai menggunakan
                            <span class="font-semibold text-[#e6a400]">AdatKu</span>
                        </p>
                    </div>

                    {{-- TITLE --}}
                    <h2 class="text-center text-base sm:text-lg font-bold text-[#d68e00] mb-4">Daftar Akun</h2>

                    {{-- TOMBOL GOOGLE --}}
                    <a href="{{ route('google.login') }}" class="flex items-center justify-center gap-3 w-full py-2.5 rounded-xl
                               bg-white border border-[#efcd82] text-gray-700 font-semibold text-sm
                               shadow-md hover:shadow-lg hover:bg-gray-50 transition-all duration-200 mb-3">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" alt="Google">
                        Daftar dengan Google
                    </a>

                    {{-- DIVIDER --}}
                    <div class="relative my-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-[#efcd82]"></div>
                        </div>
                        <div class="relative flex justify-center text-[11px]">
                            <span class="px-2 bg-[#fffdf7] text-[#a98225]">
                                atau daftar dengan email
                            </span>
                        </div>
                    </div>

                    {{-- FORM REGISTER --}}
                    <form method="POST" action="{{ route('register.post') }}" class="space-y-3">
                        @csrf

                        {{-- BARIS 1: NAMA & PASSWORD --}}
                        <div class="grid md:grid-cols-2 gap-3">
                            {{-- NAMA --}}
                            <div>
                                <label class="block text-[12px] font-medium text-[#a98225] mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                           px-3 py-2 text-[13px] text-gray-800
                                           focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                            </div>

                            {{-- PASSWORD + MATA --}}
                            <div>
                                <label class="block text-[12px] font-medium text-[#a98225] mb-1">Password</label>
                                <div class="relative">
                                    <input type="password" id="register_password" name="password" required
                                        class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                               px-3 py-2 pr-10 text-[13px] text-gray-800
                                               focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                                    <span
                                        class="absolute inset-y-0 right-3 flex items-center text-sm cursor-pointer text-[#d68e00]"
                                        onclick="togglePassword('register_password', this)">
                                        😶
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- BARIS 2: EMAIL & KONFIRMASI PASSWORD --}}
                        <div class="grid md:grid-cols-2 gap-3">
                            {{-- EMAIL --}}
                            <div>
                                <label class="block text-[12px] font-medium text-[#a98225] mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                           px-3 py-2 text-[13px] text-gray-800
                                           focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                            </div>

                            {{-- KONFIRMASI PASSWORD + MATA --}}
                            <div>
                                <label class="block text-[12px] font-medium text-[#a98225] mb-1">Konfirmasi
                                    Password</label>
                                <div class="relative">
                                    <input type="password" id="register_password_confirmation"
                                        name="password_confirmation" required
                                        class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                               px-3 py-2 pr-10 text-[13px] text-gray-800
                                               focus:outline-none focus:ring-2 focus:ring-[#f6c453] focus:border-[#f6c453]">
                                    <span
                                        class="absolute inset-y-0 right-3 flex items-center text-sm cursor-pointer text-[#d68e00]"
                                        onclick="togglePassword('register_password_confirmation', this)">
                                        😶
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL DAFTAR --}}
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-[#f5c052] to-[#d09212]
                                   text-white font-semibold text-sm shadow-lg hover:brightness-110
                                   transition-all duration-200">
                            Daftar
                        </button>
                    </form>

                    {{-- LINK KE LOGIN --}}
                    <p class="mt-4 text-[12px] text-center text-gray-700">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-[#d68e00] font-semibold hover:underline">Login</a>
                    </p>
                    <p class="mt-2 text-center text-[10px] text-gray-500">
                        © 2025 AdatKu. Semua hak dilindungi.
                    </p>

                </div>

                {{-- KANAN: TEKS --}}
                <div class="hidden md:flex flex-col justify-center items-center
                            bg-gradient-to-b from-[#fff8e1] to-[#f3cc75] py-6 px-6">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-[#c27b00] mb-3">
                            Rayakan Adat dengan Cara Modern
                        </h3>
                        <p class="text-sm text-[#9b7b34] max-w-sm mx-auto">
                            Temukan MUA, baju adat, dan layanan adat terbaik di daerahmu — cepat, mudah, dan modern.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- POPUP ERROR: VALIDASI REGISTER --}}
    @if ($errors->any())
        @php
            $errorMessage = implode("<br>", $errors->all());
        @endphp

        <div id="reg-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-[998]"></div>

        <div id="reg-spinner" class="fixed inset-0 flex items-center justify-center hidden z-[999]">
            <div class="w-12 h-12 border-4 border-yellow-500 border-t-transparent rounded-full animate-spin"></div>
        </div>

        <div id="reg-popup" class="fixed inset-0 flex items-center justify-center hidden z-[1000]">
            <div
                class="bg-[#fffdf7] w-[340px] px-6 py-5 rounded-2xl text-center shadow-xl border border-[#f4ddab] animate-fadeIn">
                <h3 class="text-red-600 font-semibold mb-1 text-lg">Pendaftaran gagal</h3>
                <p class="text-[13px] text-red-700">{!! $errorMessage !!}</p>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const overlay = document.getElementById('reg-overlay');
                const spinner = document.getElementById('reg-spinner');
                const popup = document.getElementById('reg-popup');

                overlay.classList.remove('hidden');
                spinner.classList.remove('hidden');

                setTimeout(() => {
                    spinner.classList.add('hidden');
                    popup.classList.remove('hidden');
                }, 900);

                setTimeout(() => {
                    popup.classList.add('opacity-0');
                    overlay.classList.add('opacity-0');
                    setTimeout(() => {
                        popup.remove(); overlay.remove(); spinner.remove();
                    }, 300);
                }, 3500);
            });
        </script>
    @endif

    {{-- SCRIPT TOGGLE PASSWORD --}}
    <script>
        function togglePassword(inputId, el) {
            const input = document.getElementById(inputId);
            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                el.textContent = '🫣';
            } else {
                input.type = 'password';
                el.textContent = '😶';
            }
        }
    </script>

</body>

</html>