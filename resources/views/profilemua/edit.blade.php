@extends('layouts.app')
@section('title', 'Edit Profile MUA')

@section('content')
@php
  $inp = 'w-full rounded-lg border border-slate-300 px-3 py-2 text-[14px] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 placeholder:text-slate-400';
  $lab = 'block text-sm font-medium text-slate-700 mb-1';
@endphp

{{-- ====== FLUID CONTAINER (full melebar) ====== --}}
<div class="w-full px-6 lg:px-10 border-slate-500">
  <div class="w-full bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm p-6 lg:p-8">
    <h2 class="text-2xl font-bold text-rose-700 mb-6">Edit Profil MUA</h2>

    <form action="{{ route('profilemua.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PUT')

      {{-- GRID ATAS: FOTO + INFO --}}
      <div class="grid md:grid-cols-12 gap-8">
        {{-- FOTO --}}
        <div class="md:col-span-4">
          <h3 class="text-base font-semibold text-slate-800 mb-3">Foto Profil</h3>
          <div class="flex items-start gap-4">
            <div class="w-28 h-36 rounded-xl overflow-hidden bg-slate-400 border border-slate-200 shrink-0">
              <img id="preview"
                   src="{{ $mua->foto ? asset('storage/'.$mua->foto) : 'https://placehold.co/240x320?text=Foto' }}"
                   class="w-full h-full object-cover" alt="Foto">
            </div>
            <div class="flex-1">
              <label class="{{ $lab }}">Unggah Foto</label>
              <input type="file" name="foto" accept="image/*" onchange="previewImg(event)"
                     class="block w-full text-sm border border-slate-500 rounded-lg file:mr-3 file:px-3 file:py-1.5 file:rounded-lg file:border-0 file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
              <p class="text-xs text-slate-500 mt-1">Format JPG/PNG, maks 2MB.</p>
            </div>
          </div>
        </div>

        {{-- INFORMASI UTAMA --}}
        <div class="md:col-span-8">
          <h3 class="text-base font-semibold text-slate-800 mb-3">Informasi Utama</h3>
          <div class="grid gap-4">
            <div>
              <label class="{{ $lab }}">Nama Usaha</label>
              <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $mua->nama_usaha) }}" class="{{ $inp }}">
            </div>

            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="{{ $lab }}">Kontak WA</label>
                <input type="text" name="kontak_wa" value="{{ old('kontak_wa', $mua->kontak_wa) }}" class="{{ $inp }}">
              </div>
              <div>
                <label class="{{ $lab }}">Alamat / Domisili</label>
                <input type="text" name="alamat" value="{{ old('alamat', $mua->alamat) }}" class="{{ $inp }}">
              </div>
            </div>

            <div>
              <label class="{{ $lab }}">Deskripsi Profil</label>
              <textarea name="deskripsi" rows="3" class="{{ $inp }}">{{ old('deskripsi', $mua->deskripsi) }}</textarea>
            </div>
          </div>
        </div>
      </div>

      {{-- SOSIAL MEDIA --}}
      <div>
        <h3 class="text-base font-semibold text-slate-800 mb-3">Sosial Media</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="{{ $lab }}">Instagram</label>
            <input type="text" name="instagram" value="{{ old('instagram', $mua->instagram) }}" class="{{ $inp }}" placeholder="@username">
          </div>
          <div>
            <label class="{{ $lab }}">TikTok</label>
            <input type="text" name="tiktok" value="{{ old('tiktok', $mua->tiktok) }}" class="{{ $inp }}" placeholder="@username">
          </div>
        </div>
      </div>

      {{-- ACTION BAR --}}
      <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
        <a href="{{ route('mua.panel') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-[14px]">Batal</a>
        <button type="submit" class="px-5 py-2.5 rounded-lg bg-rose-600 text-white hover:bg-rose-700 text-[14px]">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function previewImg(e){
    const f = e.target.files?.[0]; if(!f) return;
    const r = new FileReader();
    r.onload = () => document.getElementById('preview').src = r.result;
    r.readAsDataURL(f);
  }
</script>
@endsection
