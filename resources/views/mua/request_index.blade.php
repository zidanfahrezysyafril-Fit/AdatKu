<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ajukan Sebagai MUA - AdatKu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Fonts & Tailwind --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #111827;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-slate-900/80 px-3 sm:px-4">

    @php
        $user = $user ?? Auth::user();
        $isMua = strtolower($user->role ?? '') === 'mua';
        $isDisabled = $isMua ? 'disabled' : '';
    @endphp

    {{-- WRAPPER KARTU MODAL --}}
    <main class="w-full max-w-md sm:max-w-lg">
        <div
            class="bg-white rounded-[2rem] shadow-2xl border border-rose-100 px-5 sm:px-7 py-6 sm:py-7 max-h-[90vh] overflow-y-auto">

            {{-- HEADER MODAL --}}
            <div class="flex items-start justify-between gap-3 mb-4 sm:mb-5">
                <h1 class="text-xl sm:text-2xl font-bold text-rose-500">
                    Ajukan Sebagai MUA
                </h1>

                {{-- tombol close optional: balik ke halaman sebelumnya / home --}}
                <a href="{{ url()->previous() }}"
                    class="shrink-0 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 text-lg">
                    ×
                </a>
            </div>

            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-xs sm:text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 px-4 py-3 rounded-xl bg-rose-50 text-rose-700 text-xs sm:text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- STATUS PENGAJUAN --}}
            @if ($requestMua)
                <div class="mb-5 bg-amber-50/60 rounded-2xl shadow-sm border border-amber-100 px-4 py-3 text-xs sm:text-sm">
                    <p class="font-semibold text-slate-700">Status pengajuan kamu:</p>
                    <p class="mt-1">
                        <span class="font-bold capitalize">{{ $requestMua->status }}</span>
                        @if ($requestMua->catatan_admin)
                            - <span class="text-slate-600">{{ $requestMua->catatan_admin }}</span>
                        @endif
                    </p>
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('mua.request.store') }}" method="POST" class="space-y-4 text-xs sm:text-sm">
                @csrf

                <div>
                    <label class="block font-medium text-slate-700 mb-1">
                        Nama Usaha / Studio
                    </label>
                    <input type="text" name="nama_usaha" {{ $isDisabled }}
                        value="{{ old('nama_usaha', $requestMua->nama_usaha ?? '') }}" class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-rose-300 focus:border-rose-400
                                  @if($isMua) bg-slate-100 cursor-not-allowed @endif">
                    @error('nama_usaha')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium text-slate-700 mb-1">
                        Kontak WhatsApp
                    </label>
                    <input type="text" name="kontak_wa" {{ $isDisabled }}
                        value="{{ old('kontak_wa', $requestMua->kontak_wa ?? '') }}" class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-rose-300 focus:border-rose-400
                                  @if($isMua) bg-slate-100 cursor-not-allowed @endif">
                    @error('kontak_wa')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium text-slate-700 mb-1">
                        Alamat
                    </label>
                    <textarea name="alamat" rows="2" {{ $isDisabled }}
                        class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-rose-300 focus:border-rose-400
                                     @if($isMua) bg-slate-100 cursor-not-allowed @endif">{{ old('alamat', $requestMua->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium text-slate-700 mb-1">
                        Deskripsi Usaha
                    </label>
                    <textarea name="deskripsi" rows="3" {{ $isDisabled }}
                        class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-rose-300 focus:border-rose-400
                                     @if($isMua) bg-slate-100 cursor-not-allowed @endif">{{ old('deskripsi', $requestMua->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">
                            Instagram (opsional)
                        </label>
                        <input type="text" name="instagram" {{ $isDisabled }}
                            value="{{ old('instagram', $requestMua->instagram ?? '') }}" class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-rose-300 focus:border-rose-400
                                      @if($isMua) bg-slate-100 cursor-not-allowed @endif">
                    </div>

                    <div>
                        <label class="block font-medium text-slate-700 mb-1">
                            TikTok (opsional)
                        </label>
                        <input type="text" name="tiktok" {{ $isDisabled }}
                            value="{{ old('tiktok', $requestMua->tiktok ?? '') }}" class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-rose-300 focus:border-rose-400
                                      @if($isMua) bg-slate-100 cursor-not-allowed @endif">
                    </div>
                </div>

                {{-- TOMBOL AKSI (FINAL FIX – versi kecil) --}}
                @if($isMua)
                    <div class="mt-6">
                        <a href="{{ route('mua.panel') }}"
                            class="block w-full text-center px-4 py-2 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm font-semibold">
                            ← Kembali ke panel MUA
                        </a>
                    </div>
                @else
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end sm:gap-4">

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm font-semibold
                      w-full sm:w-auto">
                            ← Kembali
                        </a>

                        {{-- Tombol Kirim --}}
                        <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold shadow-md
                           w-full sm:w-auto">
                            Kirim Pengajuan
                        </button>
                    </div>
                @endif

            </form>
        </div>
    </main>

</body>

</html>