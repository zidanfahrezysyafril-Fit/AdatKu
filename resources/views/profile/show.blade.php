<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#fff9f7] text-slate-800 min-h-screen">

  <div class="max-w-3xl mx-auto py-10 px-6">
    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg bg-amber-500 text-white hover:underline mb-6 inline-block">&larr; Kembali</a>

    <div class="bg-white rounded-2xl shadow border border-rose-100 p-8 space-y-6">
      <h1 class="text-3xl font-bold text-[#c98a00] mb-6">Profil Saya</h1>

      @php
        $avatarUrl = ($user->avatar ?? null) ? asset('storage/'.$user->avatar) : 'https://placehold.co/150x150?text=Profile';
      @endphp

      <div class="flex items-center gap-6">
        <div class="w-28 h-28 rounded-full overflow-hidden border border-[#f5d547]">
          <img src="{{ $avatarUrl }}" alt="Foto Profil" class="object-cover w-full h-full">
        </div>
        <div>
          <p class="text-slate-600 text-sm">Nama</p>
          <p class="text-lg font-semibold">{{ $user->name }}</p>
          <p class="text-slate-600 text-sm mt-3">Email</p>
          <p class="font-medium">{{ $user->email }}</p>
        </div>
      </div>

      <div class="flex gap-3 pt-4">
        <a href="{{ route('profile.edit') }}"
           class="px-4 py-2 rounded-lg bg-amber-500 text-white hover:bg-amber-600 transition">
          Edit Profil
        </a>
      </div>
    </div>

    <footer class="text-xs text-slate-500 mt-10 text-center">
      © {{ date('Y') }} AdatKu
    </footer>
  </div>
</body>
</html>
