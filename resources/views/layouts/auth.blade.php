<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Autentikasi' }}</title>
  <link rel="icon" type="image/png" href="{{ asset('logo_2.png?v=5') }}">
  <link rel="shortcut icon" type="image/png" href="{{ asset('logo_2.png?v=5') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    @keyframes fadePop {
      0% {
        opacity: 0;
        transform: translateY(-15px) scale(0.95);
      }

      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .animate-fadePop {
      animation: fadePop 0.4s ease-out forwards;
    }

    body {
      background: linear-gradient(180deg, #fff7e6 0%, #fdeabf 55%, #c9a246 100%);
      background-attachment: fixed;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center text-[rgb(57,40,50)]">

  <main
    class="relative w-full max-w-md p-8 rounded-2xl shadow-2xl bg-white/90 backdrop-blur-sm border border-[#f5d547]/60 transition duration-300 ease-in-out hover:shadow-[0_0_25px_rgba(245,213,71,0.2)]">

    <div class="text-center mb-6 relative">
      @if (session('success') || session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2500)" x-show="show" x-transition
          class="absolute left-1/2 -translate-x-1/2 -top-3 z-50 animate-fadePop">
          <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-lg shadow-lg text-[14px] font-medium text-white backdrop-blur-sm border border-[#fff3b0]/40
                @if (session('success')) bg-gradient-to-r from-[#fce97a] via-[#f0c84b] to-[#c89a24]
                @else bg-gradient-to-r from-[#ef4444] via-[#dc2626] to-[#b91c1c] @endif">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              @if (session('success'))
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              @else
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              @endif
            </svg>
            <span>{{ session('success') ?? session('error') }}</span>
          </div>
        </div>
      @endif

      <img src="{{ asset('logosu.jpg') }}" alt="Logo AdatKu"
        class="w-40 h-auto mx-auto rounded-full shadow-md border-2 border-[#f3d565]">
      <h1
        class="mt-4 text-3xl font-semibold tracking-wide bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00] bg-clip-text text-transparent">
        AdatKu
      </h1>
      <p class="text-sm text-gray-700 mt-1">
        <span class="bg-gradient-to-r from-[#fff3b0] via-[#f5d547] to-[#d4a017] bg-clip-text text-transparent">
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