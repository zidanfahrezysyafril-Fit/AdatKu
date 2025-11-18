<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran - AdatKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fff9f7] text-slate-800">

    <div class="min-h-screen flex">
        {{-- kalau kamu punya layout sidebar panelmua, boleh include di sini --}}

        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold text-rose-700 mb-6">
                Konfirmasi Pembayaran Pesanan
            </h1>

            <div class="bg-white rounded-2xl shadow border border-rose-100 p-6 max-w-xl">
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Layanan</p>
                    <p class="font-semibold">
                        {{ $pesanan->layanan->nama ?? '-' }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Tanggal Booking:
                        <span class="font-medium">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_booking)->format('d M Y') }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Total:
                        <span class="font-bold text-amber-600">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </span>
                    </p>
                </div>

                <form action="{{ route('panelmua.pembayaran.store', $pesanan->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium mb-1">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar"
                            value="{{ old('tanggal_bayar', now()->toDateString()) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-rose-200 focus:border-rose-400">
                        @error('tanggal_bayar')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Metode Pembayaran</label>
                        <select name="metode_bayar"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-rose-200 focus:border-rose-400">
                            <option value="">-- Pilih Metode --</option>
                            <option value="Transfer_Bank" {{ old('metode_bayar') == 'Transfer_Bank' ? 'selected' : '' }}>
                                Transfer Bank</option>
                            <option value="E_Wallet" {{ old('metode_bayar') == 'E_Wallet' ? 'selected' : '' }}>E-Wallet
                            </option>
                            <option value="COD" {{ old('metode_bayar') == 'COD' ? 'selected' : '' }}>COD</option>
                        </select>
                        @error('metode_bayar')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-[11px] text-gray-500 mt-1">
                            Bukti transfer boleh dikosongkan jika metode COD.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Bukti Transfer (jpg / png, max 2MB)
                        </label>
                        <input type="file" name="bukti_transfer" class="block w-full text-sm text-gray-700
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-rose-50 file:text-rose-700
                                  hover:file:bg-rose-100">
                        @error('bukti_transfer')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ route('panelmua.pesanan.index') }}"
                            class="px-4 py-2 rounded-full text-sm border border-gray-300 text-gray-600 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2 rounded-full text-sm font-semibold bg-rose-600 text-white hover:bg-rose-700">
                            Simpan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>

</html>