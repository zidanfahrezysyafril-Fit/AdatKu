<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#fff9f7] text-slate-800 min-h-screen">

  <div class="max-w-3xl mx-auto py-10 px-6">
    <a href="{{ route('profile.show') }}" class="px-4 py-2 rounded-lg bg-amber-500 text-white hover:underline mb-6 inline-block">&larr; Kembali</a>

    <div class="bg-white rounded-2xl shadow border border-rose-100 p-8">
      <h2 class="text-3xl font-bold text-[#c98a00] mb-6">Edit Profil</h2>

      @php
        $avatarUrl = ($user->avatar ?? null) ? asset('storage/'.$user->avatar) : 'https://placehold.co/150x150?text=Profile';
      @endphp

      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-6">
          <div class="w-24 h-24 rounded-full overflow-hidden border border-[#f5d547]">
            <img src="{{ $avatarUrl }}" alt="Foto Profil" class="object-cover w-full h-full">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Ganti Foto</label>
            <input type="file" name="profile" class="block w-full text-sm text-slate-600">
            <p class="text-xs text-slate-500 mt-1">jpg/jpeg/png, maks 2MB</p>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}"
                 class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-rose-500">
        </div>

        <div class="flex justify-end gap-3">
          <a href="{{ route('profile.show') }}" class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300">Batal</a>
          <button type="submit" class="px-5 py-2 bg-[#c98a00] text-white rounded-lg hover:bg-[#eab308]">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
