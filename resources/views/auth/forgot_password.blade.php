<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - AdatKu</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
        }

        /* ANIMASI ORNAMEN */
        @keyframes float-up {
            0% { transform: translateY(0); opacity: 0; }
            10% { opacity: 1; }
            100% { transform: translateY(-140vh); opacity: 0; }
        }

        @keyframes float-down {
            0% { transform: translateY(0); opacity: 0; }
            10% { opacity: 1; }
            100% { transform: translateY(140vh); opacity: 0; }
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

        .from-bottom { bottom: -12vh; animation-name: float-up; }
        .from-top    { top: -12vh;    animation-name: float-down; }

        .icon-sm { font-size: 18px; }
        .icon-md { font-size: 22px; }
        .icon-lg { font-size: 28px; }
        .icon-xl { font-size: 34px; }
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

    {{-- KARTUN ADAT (FIXED) --}}
    <img src="{{ asset('foto kartun2.jpg') }}"
         class="fixed left-6 bottom-0 h-[160px] md:h-[230px] object-contain z-10">
    <img src="{{ asset('foto kartun2.jpg') }}"
         class="fixed right-6 bottom-0 h-[160px] md:h-[230px] object-contain z-10">

    {{-- CARD LUPA PASSWORD (MODEL 2 KOLOM SEPERTI LOGIN) --}}
    <div class="relative z-20 flex items-center justify-center min-h-screen px-4 py-4">
        <div class="w-full max-w-4xl bg-[#fffdf7]/95 rounded-[28px]
                    shadow-[0_18px_55px_rgba(190,143,43,0.35)]
                    border border-[#f4ddab] backdrop-blur-md overflow-hidden">

            <div class="grid md:grid-cols-2">

                {{-- KIRI: FORM --}}
                <div class="px-6 sm:px-8 py-6 flex flex-col justify-center">

                    {{-- LOGO --}}
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center w-40 h-14 rounded-full
                                    border border-[#f4c970] bg-white shadow-md">
                            <img src="{{ asset('logos3.jpg') }}" alt="Logo AdatKu" class="h-11 object-contain">
                        </div>
                    </div>

                    {{-- TITLE --}}
                    <h1 class="text-xl sm:text-2xl font-bold text-[#d68e00] mb-1 text-center">
                        Lupa Password
                    </h1>
                    <p class="text-[12px] sm:text-sm text-[#a98225] mb-5 text-center max-w-md mx-auto">
                        Masukkan email yang kamu gunakan saat mendaftar. Jika terdaftar,
                        kami akan mengirim link untuk setel ulang password.
                    </p>

                    {{-- ALERT --}}
                    @if (session('status'))
                        <div
                            class="mb-3 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-xs sm:text-sm border border-emerald-200">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div
                            class="mb-3 px-3 py-2 rounded-xl bg-rose-50 text-rose-700 text-xs sm:text-sm border border-rose-200">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- FORM --}}
                    <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="email" class="block text-[12px] font-medium text-slate-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="w-full rounded-xl border border-[#efcd82] bg-[#fffdf7]
                                       px-3 py-2 text-[13px] focus:outline-none focus:ring-2
                                       focus:ring-[#f6c453] focus:border-[#f6c453]" required autofocus>
                        </div>

                        <button type="submit"
                            class="w-full py-2.5 rounded-xl bg-gradient-to-r from-[#f5c052] to-[#d09212]
                                   text-white font-semibold text-sm shadow-lg hover:brightness-110
                                   transition-all duration-200">
                            Kirim Link Reset Password
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-xs sm:text-sm text-rose-600 hover:underline">
                            ← Kembali ke halaman login
                        </a>
                    </div>
                </div>

                {{-- KANAN: TEKS --}}
                <div class="hidden md:flex flex-col justify-center items-center
                            bg-gradient-to-b from-[#fff8e1] to-[#f3cc75] py-6 px-6">
                    <div class="text-center">
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
