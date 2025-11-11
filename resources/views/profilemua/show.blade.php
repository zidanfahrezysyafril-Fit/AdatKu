<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail MUA — {{ $mua->Nama ?? 'Profil MUA' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fff9f7] text-slate-800 min-h-screen">

    <div class="max-w-5xl mx-auto py-10 px-6">
        <a href="{{ route('panelmua.index') }}" class="text-rose-600 hover:underline mb-6 inline-block">&larr; Kembali</a>

        <div class="bg-white rounded-2xl shadow border border-rose-100 p-8 space-y-6">

            <div class="flex flex-col md:flex-row items-start gap-6">
                <div class="w-40 h-40 rounded-xl overflow-hidden border border-rose-100 bg-slate-100">
                    <img src="{{ ($mua->Foto ?? null) ? asset('storage/' . $mua->Foto) : 'https://placehold.co/200x200?text=Foto' }}"
                        class="object-cover w-full h-full" alt="Foto MUA">
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-rose-700 mb-2">{{ $mua->Nama ?? 'Belum diisi' }}</h2>
                    <p class="text-slate-600 mb-1">Kontak WA: <span class="font-medium">{{ $mua->Kontak_WA ?? '-' }}</span></p>
                    <p class="text-slate-600 mb-1">Rekening Bank: <span class="font-medium">{{ $mua->Rekening_Bank ?? '-' }}</span></p>
                    <p class="text-slate-600 mb-1">Alamat: <span class="font-medium">{{ $mua->Alamat ?? '-' }}</span></p>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-rose-700 mb-2">Deskripsi</h3>
                <p class="text-slate-700 leading-relaxed">{{ $mua->Deskripsi ?? 'Belum ada deskripsi yang diisi.' }}</p>
            </div>

            <div class="flex gap-3 pt-4">
                <a href="{{ route('panelmua.edit', $mua->id) }}"
                    class="px-4 py-2 rounded-lg bg-amber-500 text-white hover:bg-amber-600 transition">
                    Edit Profil
                </a>

                <form action="{{ route('panelmua.destroy', $mua->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <footer class="text-xs text-slate-500 mt-10 text-center">
            © {{ date('Y') }} AdatKu — MUA Panel
        </footer>
    </div>
</body>

</html>
