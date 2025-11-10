@extends('layouts.app')

@section('title', 'Tambah Layanan')

@section('content')
<h2 class="text-2xl font-bold mb-4">Tambah Layanan Baru</h2>

<form action="{{ route('layanan.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md w-full md:w-1/2">
    @csrf
    <label class="block mb-2">Pilih MUA</label>
    <select name="Id_Mua" class="w-full border p-2 rounded mb-4">
        @foreach($mua as $item)
            <option value="{{ $item->Id_Mua }}">{{ $item->Nama_Usaha }}</option>
        @endforeach
    </select>

    <label class="block mb-2">Nama Layanan</label>
    <input type="text" name="Nama_Layanan" class="w-full border p-2 rounded mb-4">

    <label class="block mb-2">Kategori</label>
    <input type="text" name="Kategori" class="w-full border p-2 rounded mb-4">

    <label class="block mb-2">Harga</label>
    <input type="number" name="Harga" class="w-full border p-2 rounded mb-4">

    <label class="block mb-2">Deskripsi</label>
    <textarea name="Deskripsi" class="w-full border p-2 rounded mb-4"></textarea>

    <button class="bg-pink-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
