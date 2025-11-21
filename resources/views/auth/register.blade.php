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

<body class="relative min-h-screen bg-gradient-to-b from-[#fff7e1] via-[#f4d890] to-[#cfa043] overflow-hidden">

    {{-- ORNAMEN --}}
    <span class="floating-icon from-bottom icon-lg" style="left: 5%; animation-duration: 22s;">❖</span>
    <span class="floating-icon from-bottom icon-xl" style="left: 15%; animation-duration: 28s;">✿</span>
    <span class="floating-icon from-top icon-md" style="left: 82%; animation-duration: 27s;">◈</span>

    {{-- KARTUN ADAT --}}
    <img src="{{ asset('foto kartun2.jpg') }}" class="hidden md:block fixed left-10 bottom-0 h-[300px] z-10">
    <img src="{{ asset('foto kartun2.jpg') }}" class="hidden md:block fixed right-10 bottom-0 h-[300px] z-10">

    {{-- CARD REGISTER --}}
    <div class="relative z-20 flex items-center justify-center min-h-screen px-4 py-6">
        <div class="w-full max-w-4xl bg-[#fffdf7]/95 rounded-[28px]
                    shadow-[0_18px_55px_rgba(190,143,43,0.35)]
                    border border-[#f4ddab] backdrop-blur-md overflow-hidden">

            <div class="grid md:grid-cols-2">

                {{-- KIRI: FORM --}}
                <div class="px-8 py-6 flex flex-col">

                    {{-- LOGO --}}
                    <div class="flex justify-center mb-3">
                        <div
                            class="flex items-center justify-center w-40 h-14 rounded-full border border-[#f4c970] bg-white shadow-md">
                            <img src="{{ asset('logos3.jpg') }}" class="h-11 object-contain">
                        </div>
                    </div>

                    <div class="text-center mb-3">
                        <h1 class="text-2xl font-bold text-[#d68e00]">AdatKu</h1>
                        <p class="text-sm text-[#c2983a]">Buat akun untuk mulai menggunakan <span
                                class="font-semibold text-[#e6a400]">AdatKu</span></p>
                    </div>

                    <h2 class="text-center text-lg font-bold text-[#d68e00] mb-3">Daftar Akun</h2>

                    {{-- GOOGLE --}}
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
                        <div class="relative flex justify-center text-[11px]"><span
                                class="px-2 bg-[#fffdf7] text-[#a98225]">atau daftar dengan email</span></div>
                    </div>

                    {{-- FORM --}}
                    <form method="POST" action="{{ route('register.post') }}" class="space-y-2.5">
                        @csrf
                        <div><label class="block text-[12px] font-medium text-[#a98225] mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7] px-3 py-2 text-[13px]">
                        </div>
                        <div><label class="block text-[12px] font-medium text-[#a98225] mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7] px-3 py-2 text-[13px]">
                        </div>
                        <div><label class="block text-[12px] font-medium text-[#a98225] mb-1">Password</label>
                            <input type="password" name="password" required
                                class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7] px-3 py-2 text-[13px]">
                        </div>
                        <div><label class="block text-[12px] font-medium text-[#a98225] mb-1">Konfirmasi
                                Password</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7] px-3 py-2 text-[13px]">
                        </div>

                        <button type="submit"
                            class="w-full py-2.5 rounded-xl bg-gradient-to-r from-[#f5c052] to-[#d09212]
                                       text-white font-semibold text-sm shadow-lg hover:brightness-110 transition-all duration-200">
                            Daftar
                        </button>
                    </form>

                    <p class="mt-3 text-center text-[11px] text-gray-700">
                        Sudah punya akun? <a href="{{ route('login') }}"
                            class="text-[#d68e00] font-semibold hover:underline">Login</a>
                    </p>
                    <p class="mt-2 text-center text-[9px] text-gray-500">© 2025 AdatKu. Semua hak dilindungi.</p>

                </div>

                {{-- KANAN --}}
                <div
                    class="hidden md:flex flex-col justify-center items-center bg-gradient-to-b from-[#fff8e1] to-[#f3cc75] py-6 px-6">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-[#c27b00] mb-3">Rayakan Adat dengan Cara Modern</h3>
                        <p class="text-sm text-[#9b7b34] max-w-sm">Temukan MUA, baju adat, dan layanan adat terbaik di
                            daerahmu — cepat, mudah, dan modern.</p>
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

        {{-- Overlay --}}
        <div id="reg-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-[998]"></div>

        {{-- Spinner --}}
        <div id="reg-spinner" class="fixed inset-0 flex items-center justify-center hidden z-[999]">
            <div class="w-12 h-12 border-4 border-yellow-500 border-t-transparent rounded-full animate-spin"></div>
        </div>

        {{-- Popup --}}
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

</body>

</html>