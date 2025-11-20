@extends('layouts.app')
@section('title', 'Edit Profile MUA')

@section('content')
  @php
    $inp = 'w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-[15px] shadow-sm focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 placeholder:text-slate-400 transition';
    $lab = 'block text-[13px] font-semibold text-slate-600 mb-1.5';
  @endphp

  <div class="w-full px-5 sm:px-6 lg:px-10">
    <div class="w-full bg-white/90 backdrop-blur rounded-3xl ring-1 ring-rose-50 shadow-md p-6 sm:p-8 lg:p-9">

      {{-- HEADER --}}
      <div class="pb-5 border-b border-rose-50 mb-8">
        <p class="text-xs font-semibold tracking-[0.18em] text-rose-400 uppercase mb-1.5">MUA Panel</p>
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Edit Profil MUA</h2>
        <p class="text-sm text-slate-500 mt-1">Lengkapi dan perbarui identitas profesional kamu.</p>
      </div>

      <form action="{{ route('profilemua.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')

        {{-- FOTO + INFO --}}
        <div class="grid lg:grid-cols-[260px_1fr] gap-10">

          {{-- FOTO --}}
          <div>
            <h3 class="text-sm font-semibold text-slate-900 mb-3 flex items-center gap-2">
              <span
                class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">📸</span>
              Foto Profil
            </h3>

            <div class="space-y-4">
              <div class="relative mx-auto lg:mx-0">
                <figure class="w-36 h-48 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-sm">
                  <img id="preview"
                    src="{{ $mua->foto ? asset('storage/' . $mua->foto) : 'https://placehold.co/240x320?text=Foto' }}"
                    class="w-full h-full object-cover" alt="Foto">
                </figure>
                <div
                  class="pointer-events-none absolute -inset-2 rounded-3xl border border-white/60 shadow-[0_0_0_1px_rgba(248,250,252,0.7)]">
                </div>
              </div>

              <div>
                <input type="file" name="foto" accept="image/*" onchange="previewImg(event)"
                  class="block w-full text-sm border border-slate-300 rounded-xl file:mr-3 file:px-3 file:py-1.5 file:rounded-xl file:border-0 file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition">
                <p class="text-xs text-slate-500 mt-1">Format JPG/PNG, max 2MB.</p>
              </div>
            </div>
          </div>

          {{-- INFORMASI UTAMA --}}
          <div>
            <h3 class="text-sm font-semibold text-slate-900 mb-3 flex items-center gap-2">
              <span
                class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">📝</span>
              Informasi Utama
            </h3>

            <div class="grid gap-4">
              <div>
                <label class="{{ $lab }}">Nama Usaha</label>
                <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $mua->nama_usaha) }}" class="{{ $inp }}">
              </div>

              <div class="grid sm:grid-cols-2 gap-4">
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
                <textarea name="deskripsi" rows="4"
                  class="{{ $inp }} resize-none">{{ old('deskripsi', $mua->deskripsi) }}</textarea>
                <p class="text-xs text-slate-500 mt-1">Ceritakan style makeup, keunggulan, pengalaman, dan layananmu.</p>
              </div>
            </div>
          </div>
        </div>

        {{-- SOSIAL MEDIA --}}
        <div>
          <h3 class="text-sm font-semibold text-slate-900 mb-3 flex items-center gap-2">
            <span
              class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">💬</span>
            Sosial Media
          </h3>

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="{{ $lab }}">Instagram</label>
              <input type="text" name="instagram" value="{{ old('instagram', $mua->instagram) }}" class="{{ $inp }}"
                placeholder="@username">
            </div>
            <div>
              <label class="{{ $lab }}">TikTok</label>
              <input type="text" name="tiktok" value="{{ old('tiktok', $mua->tiktok) }}" class="{{ $inp }}"
                placeholder="@username">
            </div>
          </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex justify-end gap-3 pt-5 border-t border-slate-100">
          <a href="{{ route('mua.panel') }}"
            class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition">
            Batal
          </a>
          <button type="submit"
            class="px-5 py-2.5 rounded-xl bg-rose-600 text-white hover:bg-rose-700 text-sm font-semibold shadow-sm transition">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function previewImg(e) {
      const f = e.target.files?.[0]; if (!f) return;
      const r = new FileReader();
      r.onload = () => document.getElementById('preview').src = r.result;
      r.readAsDataURL(f);
    }
  </script>
@endsection