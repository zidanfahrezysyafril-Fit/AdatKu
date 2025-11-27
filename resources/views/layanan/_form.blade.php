@php
    $inp = 'w-full rounded-2xl border border-amber-200/70 bg-[#FFFBF3]
            px-3.5 py-2.5 text-sm
            focus:outline-none focus:ring-2 focus:ring-[#FACC6B] focus:border-[#DA9A00]
            placeholder:text-slate-400 shadow-[0_1px_0_rgba(248,250,252,0.7)]';
    $lab = 'block text-sm font-medium text-slate-800 mb-1.5';
@endphp

<div class="grid gap-5">

    <div>
        <label class="{{ $lab }}">Nama Layanan</label>
        <input type="text" name="nama" value="{{ old('nama', $item->nama ?? '') }}" class="{{ $inp }}">
        @error('nama') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid md:grid-cols-2 gap-5">
        <div>
            <label class="{{ $lab }}">Harga</label>
            <input type="number" name="harga" value="{{ old('harga', $item->harga ?? '') }}" class="{{ $inp }}">
            @error('harga') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="{{ $lab }}">Kategori</label>
            @php $kat = old('kategori', $item->kategori ?? ''); @endphp
            <select name="kategori" class="{{ $inp }}">
                <option value="">Pilih kategori</option>
                <option value="makeup" {{ $kat == 'makeup' ? 'selected' : '' }}>Makeup</option>
                <option value="baju" {{ $kat == 'baju' ? 'selected' : '' }}>Baju Adat</option>
                <option value="pelamin" {{ $kat == 'pelamin' ? 'selected' : '' }}>Pelamin</option>
            </select>
            @error('kategori') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="{{ $lab }}">Deskripsi</label>
        <textarea name="deskripsi" rows="4" class="{{ $inp }}">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="{{ $lab }}">Foto Layanan</label>
        <input type="file" name="foto" class="{{ $inp }}">
        @error('foto') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror

        @if(!empty($item?->foto))
            <img src="{{ asset('storage/' . $item->foto) }}" class="w-28 h-28 rounded-2xl border border-amber-200 mt-2 object-cover">
        @endif
    </div>

</div>
