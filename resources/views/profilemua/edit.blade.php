@extends('layouts.app')
@section('title', 'Edit Profil MUA')

@section('content')
  @php
    // INPUT: normal abu, pas focus baru muncul border emas gradasi
    $inp = 'w-full rounded-xl px-3 py-2.5 placeholder:text-slate-400 border border-slate-300
                            focus:outline-none focus:border-[3px] focus:border-transparent
                            focus:[background-image:linear-gradient(white,white),linear-gradient(90deg,#FFE07D,#C98A00)]
                            focus:[background-origin:border-box] focus:[background-clip:padding-box,border-box]
                            focus:ring-0';

    $lab = 'block text-[13px] font-semibold text-slate-600 mb-1.5';
  @endphp

  <div class="w-full px-4 sm:px-6 lg:px-10 py-5 sm:py-6">
    <div class="max-w-6xl mx-auto">
      <div class="w-full bg-white/90 backdrop-blur rounded-3xl ring-1 ring-rose-50 shadow-md p-5 sm:p-7 lg:p-9">

        {{-- HEADER --}}
        <div class="pb-5 border-b border-rose-50 mb-8">
          <p class="text-xs font-semibold tracking-[0.18em] uppercase mb-1.5" style="color:#C98A00;">
            MUA PANEL
          </p>
          <h2 class="text-2xl sm:text-3xl font-bold" style="color:#C98A00;">
            Edit Profil MUA
          </h2>
          <p class="text-sm text-slate-500 mt-1">
            Lengkapi dan perbarui identitas profesional kamu.
          </p>
        </div>

        <form action="{{ route('profilemua.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
          @csrf
          @method('PUT')

          {{-- FOTO + INFO --}}
          <div class="grid gap-8 lg:gap-10 lg:grid-cols-[260px_1fr]">

            {{-- FOTO --}}
            <div>
              <h3 class="text-sm font-semibold text-slate-900 mb-3 flex items-center gap-2">
                <span
                  class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">
                  📸
                </span>
                Foto Profil
              </h3>

              <div class="space-y-4">
                <div class="relative mx-auto lg:mx-0">
                  <figure
                    class="w-32 h-44 sm:w-36 sm:h-48 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-sm">
                    <img id="preview"
                      src="{{ !empty($mua?->foto) ? asset($mua->foto) : 'https://placehold.co/240x320?text=Foto' }}"
                      class="w-full h-full object-cover" alt="Foto">
                  </figure>
                  <div
                    class="pointer-events-none absolute -inset-2 rounded-3xl border border-white/60 shadow-[0_0_0_1px_rgba(248,250,252,0.7)]">
                  </div>
                </div>

                <div>
                  <input type="file" name="foto" accept="image/*" onchange="previewImg(event)" class="block w-full text-xs sm:text-sm border border-slate-300 rounded-xl
                                        file:mr-3 file:px-3 file:py-1.5 file:rounded-xl file:border-0
                                        file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition">
                  <p class="text-xs text-slate-500 mt-1">Format JPG/PNG, max 2MB.</p>
                </div>
              </div>
            </div>

            {{-- INFORMASI UTAMA --}}
            <div>
              <h3 class="text-sm font-semibold text-slate-900 mb-3 flex items-center gap-2">
                <span
                  class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">
                  📝
                </span>
                Informasi Utama
              </h3>

              <div class="grid gap-4">
                <div>
                  <label class="{{ $lab }}">Nama Usaha</label>
                  <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $mua->nama_usaha ?? '') }}"
                    class="{{ $inp }}" placeholder="Masukkan nama usaha / brand MUA kamu">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                  <div>
                    <label class="{{ $lab }}">Kontak WA</label>
                    {{-- tambahin id & tetap pakai placeholder +62 --}}
                    <input id="kontak_wa" type="text" name="kontak_wa"
                      value="{{ old('kontak_wa', $mua->kontak_wa ?? '') }}" class="{{ $inp }}"
                      placeholder="812 3456 7890 (isi tanpa 0 / +62)">

                  </div>
                  <div>
                    <label class="{{ $lab }}">Alamat / Domisili</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $mua->alamat ?? '') }}" class="{{ $inp }}"
                      placeholder="Masukkan alamat / domisili kamu">
                  </div>
                </div>

                <div>
                  <label class="{{ $lab }}">Deskripsi Profil</label>
                  <textarea name="deskripsi" rows="4" class="{{ $inp }} resize-y"
                    placeholder="Ceritakan secara singkat tentang jasa MUA kamu...">{{ old('deskripsi', $mua->deskripsi ?? '') }}</textarea>
                  <p class="text-xs text-slate-500 mt-1">
                    Ceritakan style makeup, keunggulan, pengalaman, dan layananmu.
                  </p>
                </div>
              </div>
            </div>
          </div>

          {{-- SOSIAL MEDIA --}}
          <div>
            <h3 class="text-sm font-semibold text-slate-900 mb-3 flex items-center gap-2">
              <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-500 text-sm">
                💬
              </span>
              Sosial Media
            </h3>

            <div class="grid sm:grid-cols-2 gap-4">
              <div>
                <label class="{{ $lab }}">Instagram</label>
                <input type="text" name="instagram" value="{{ old('instagram', $mua->instagram ?? '') }}"
                  class="{{ $inp }}" placeholder="@username">
              </div>
              <div>
                <label class="{{ $lab }}">TikTok</label>
                <input type="text" name="tiktok" value="{{ old('tiktok', $mua->tiktok ?? '') }}" class="{{ $inp }}"
                  placeholder="@username">
              </div>
            </div>
          </div>

          {{-- ACTION BUTTONS --}}
          <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3 mt-4">
            {{-- BATAL --}}
            <a href="{{ route('mua.panel') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-2xl font-semibold text-white
                              shadow-sm hover:brightness-110 active:brightness-95 transition text-sm"
              style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
              Batal
            </a>

            {{-- SIMPAN PERUBAHAN --}}
            <button type="submit"
              class="inline-flex items-center justify-center px-6 py-2.5 rounded-2xl font-semibold text-white
                             shadow-md hover:brightness-110 active:brightness-95 transition text-sm
                             focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#eab308] focus-visible:ring-offset-2"
              style="background: linear-gradient(90deg,#FFEB91,#DA9A00);">
              Simpan Perubahan
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <script>
    function previewImg(e) {
      const f = e.target.files?.[0];
      if (!f) return;
      const r = new FileReader();
      r.onload = () => document.getElementById('preview').src = r.result;
      r.readAsDataURL(f);
    }
  </script>
@endsection