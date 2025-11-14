@php
    $inp = 'w-full rounded-xl border border-slate-300 px-3 py-2.5 
                focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 placeholder:text-slate-400';
    $lab = 'block text-sm font-medium text-slate-700 mb-1.5';
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
        </div>
    </div>

    <div>
        <label class="{{ $lab }}">Deskripsi</label>
        <textarea name="deskripsi" rows="4" class="{{ $inp }}">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
    </div>

    <div>
        <label class="{{ $lab }}">Foto Layanan</label>
        <input type="file" name="foto" class="{{ $inp }}">
        @error('foto') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror

        @if(!empty($item?->foto))
            <img src="{{ asset('storage/' . $item->foto) }}" class="w-28 h-28 rounded-xl border mt-2 object-cover">
        @endif
    </div>

</div>