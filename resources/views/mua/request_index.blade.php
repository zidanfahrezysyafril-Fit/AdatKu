<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ajukan Sebagai MUA - AdatKu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff9fb;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    <main class="flex-1 max-w-2xl mx-auto py-10 px-4">

        <h1 class="text-2xl font-bold text-rose-700 mb-4">
            Ajukan Sebagai MUA
        </h1>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-rose-50 text-rose-700 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if ($requestMua)
            <div class="mb-6 bg-white rounded-2xl shadow border border-amber-100 p-4 text-sm">
                <p class="font-semibold text-slate-700">Status pengajuan kamu:</p>
                <p class="mt-1">
                    <span class="font-bold capitalize">{{ $requestMua->status }}</span>
                    @if ($requestMua->catatan_admin)
                        - <span class="text-slate-600">{{ $requestMua->catatan_admin }}</span>
                    @endif
                </p>
            </div>
        @endif

        @php
            $user = $user ?? Auth::user();
            $isMua = strtolower($user->role ?? '') === 'mua';
            $isDisabled = $isMua ? 'disabled' : '';
        @endphp

        <form action="{{ route('mua.request.store') }}" method="POST"
            class="bg-white rounded-2xl shadow p-6 space-y-4 border border-rose-100">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Usaha / Studio</label>
                <input type="text" name="nama_usaha" {{ $isDisabled }}
                    value="{{ old('nama_usaha', $requestMua->nama_usaha ?? '') }}"
                    class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMua) bg-slate-100 cursor-not-allowed @endif">
                @error('nama_usaha')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kontak WhatsApp</label>
                <input type="text" name="kontak_wa" {{ $isDisabled }}
                    value="{{ old('kontak_wa', $requestMua->kontak_wa ?? '') }}"
                    class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMua) bg-slate-100 cursor-not-allowed @endif">
                @error('kontak_wa')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="2" {{ $isDisabled }}
                    class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMua) bg-slate-100 cursor-not-allowed @endif">{{ old('alamat', $requestMua->alamat ?? '') }}</textarea>
                @error('alamat')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Usaha</label>
                <textarea name="deskripsi" rows="3" {{ $isDisabled }}
                    class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMua) bg-slate-100 cursor-not-allowed @endif">{{ old('deskripsi', $requestMua->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Instagram (opsional)</label>
                    <input type="text" name="instagram" {{ $isDisabled }}
                        value="{{ old('instagram', $requestMua->instagram ?? '') }}"
                        class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMua) bg-slate-100 cursor-not-allowed @endif">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">TikTok (opsional)</label>
                    <input type="text" name="tiktok" {{ $isDisabled }}
                        value="{{ old('tiktok', $requestMua->tiktok ?? '') }}"
                        class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-rose-300 focus:border-rose-400 @if($isMua) bg-slate-100 cursor-not-allowed @endif">
                </div>
            </div>

            {{-- Kalau sudah jadi MUA, tombol kembali ke tengah --}}
            @if($isMua)
                <div class="mt-6 text-center">
                    <a href="{{ route('mua.panel') }}"
                        class="px-6 py-2.5 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm font-semibold inline-block">
                        ← Kembali
                    </a>
                </div>

                {{-- Kalau belum jadi MUA, 2 tombol berdampingan --}}
            @else
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('home') }}"
                        class="px-5 py-2.5 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm font-semibold">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm shadow-md">
                        Kirim Pengajuan
                    </button>
                </div>
            @endif

        </form>
    </main>

</body>

</html>