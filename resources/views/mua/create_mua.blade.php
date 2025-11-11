@extends('layouts.app')

@section('title', 'Tambah MUA')

@section('content')
<h2 class="text-2xl font-bold mb-4">Tambah Data MUA</h2>

<form action="{{ route('mua.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md w-full md:w-1/2">
    @csrf
    <label class="block mb-2">Nama Usaha</label>
    <input type="text" name="Nama_Usaha" class="w-full border p-2 rounded mb-4">

    <label class="block mb-2">Kontak WA</label>
    <input type="text" name="Kontak_WA" class="w-full border p-2 rounded mb-4">

    <label class="block mb-2">Rekening Bank</label>
    <input type="text" name="Rekening_Bank" class="w-full border p-2 rounded mb-4">

    <label class="block mb-2">Profil MUA</label>
    <textarea name="Profile_MUA" class="w-full border p-2 rounded mb-4"></textarea>

    <button class="bg-pink-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
