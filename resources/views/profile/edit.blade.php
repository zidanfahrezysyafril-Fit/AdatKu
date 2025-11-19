<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff9fb;
      background-image:
        linear-gradient(135deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
        linear-gradient(225deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
        linear-gradient(315deg, rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%),
        linear-gradient(45deg,  rgba(200, 150, 160, 0.06) 25%, transparent 25%, transparent 50%, rgba(200, 150, 160, 0.06) 50%, rgba(200, 150, 160, 0.06) 75%, transparent 75%, transparent 100%);
      background-size: 24px 24px;
      background-position: 0 0, 0 12px, 12px -12px, -12px 0;
    }
  </style>
</head>

<body class="bg-[rgba(255,242,213,0.08)] text-slate-800 min-h-screen">

  <div class="max-w-3xl mx-auto py-10 px-6">
    <a href="{{ route('profile.show') }}"
       class="px-4 py-2 rounded-lg bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
              text-white mb-6 inline-block shadow hover:opacity-90 transition">
      &larr; Kembali
    </a>

    <div class="bg-white rounded-2xl shadow border border-yellow-200/70 p-8">
      <h2 class="text-3xl font-bold text-[#c98a00] mb-6">Edit Profil</h2>

      @php
        $avatarUrl = ($user->avatar ?? null) ? asset('storage/'.$user->avatar) : 'https://placehold.co/150x150?text=Profile';
      @endphp

      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-6">
          <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-[#f5d547] shadow">
            <img src="{{ $avatarUrl }}" alt="Foto Profil" class="object-cover w-full h-full">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Ganti Foto</label>
            <input type="file" name="profile"
                   class="block w-full text-sm text-slate-600 file:rounded-lg file:px-3 file:py-1 file:border file:bg-white file:border-yellow-200 cursor-pointer">
            <p class="text-xs text-slate-500 mt-1">jpg/jpeg/png, maks 2MB</p>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}"
                 class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#f5d547] focus:border-[#c98a00]">
        </div>

        <div class="flex justify-end gap-3 pt-3">
          <a href="{{ route('profile.show') }}"
             class="px-4 py-2 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
            Batal
          </a>
          <button type="submit"
                  class="px-5 py-2 rounded-lg text-white shadow-md bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                         hover:opacity-90 transition">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
