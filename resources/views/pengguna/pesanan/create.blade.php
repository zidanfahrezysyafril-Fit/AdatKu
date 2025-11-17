<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Buat Pesanan - {{ $layanan->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[rgba(255,242,213,0.08)] text-slate-800">

    <div class="max-w-xl mx-auto mt-10 bg-white rounded-2xl shadow p-6">
        <h1 class="text-2xl font-bold text-rose-700 mb-4">Buat Pesanan</h1>

        <div class="mb-4 border rounded-xl p-3 bg-slate-50">
            <p class="font-semibold">{{ $layanan->nama }}</p>
            <p class="text-sm text-gray-600 mt-1">
                Rp {{ number_format($layanan->harga, 0, ',', '.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('pengguna.store', $layanan->id) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Booking</label>
                <input type="date" name="tanggal_booking" class="w-full border rounded-xl px-3 py-2"
                    value="{{ old('tanggal_booking') }}" required>
                @error('tanggal_booking')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full border rounded-xl px-3 py-2"
                    required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ url()->previous() }}" class="text-sm text-gray-500 hover:underline">
                    ← Kembali
                </a>
                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-rose-600 text-white text-sm font-semibold hover:bg-rose-700">
                    Buat Pesanan
                </button>
            </div>
        </form>
    </div>

</body>

</html>