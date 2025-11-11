@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-md mt-10">
        <h2 class="text-2xl font-bold text-rose-700 mb-6">Edit Profil MUA</h2>

        <form action="{{ route('panelmua.update', $mua->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700">Nama Usaha</label>
                <input type="text" name="Nama_Usaha" value="{{ old('Nama_Usaha', $mua->Nama_Usaha) }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-rose-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Kontak WA</label>
                <input type="text" name="Kontak_WA" value="{{ old('Kontak_WA', $mua->Kontak_WA) }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-rose-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $mua->alamat) }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-rose-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Deskripsi Profil</label>
                <textarea name="Profile_MUA" rows="4"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-rose-500">{{ old('Profile_MUA', $mua->Profile_MUA) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Instagram</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $mua->instagram) }}"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-rose-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tiktok</label>
                    <input type="text" name="tiktok" value="{{ old('tiktok', $mua->tiktok) }}"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-rose-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Foto MUA</label>
                <input type="file" name="foto" class="block w-full text-sm text-slate-500 border rounded-lg p-2">
                @if($mua->foto)
                    <img src="{{ asset('storage/' . $mua->foto) }}" alt="Foto MUA"
                        class="w-32 h-32 mt-2 rounded-lg object-cover">
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('panelmua.index') }}"
                    class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300">Batal</a>
                <button type="submit" class="px-5 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>
@endsection