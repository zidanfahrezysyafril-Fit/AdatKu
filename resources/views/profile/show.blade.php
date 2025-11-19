<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya</title>
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
    <a href="{{ route('home') }}"
       class="px-4 py-2 rounded-lg bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
              text-white mb-6 inline-block shadow hover:opacity-90 transition">
      &larr; Kembali
    </a>

    <div class="bg-white rounded-2xl shadow border border-yellow-200/70 p-8 space-y-6">
      <h1 class="text-3xl font-bold text-[#c98a00] mb-6">Profil Saya</h1>

      @php
        $avatarUrl = ($user->avatar ?? null)
          ? asset('storage/'.$user->avatar)
          : 'https://placehold.co/150x150?text=Profile';
      @endphp

      <div class="flex items-center gap-6">
        <div class="w-28 h-28 rounded-full overflow-hidden border-2 border-[#f5d547] shadow">
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
           class="px-4 py-2 rounded-lg bg-gradient-to-r from-[#f7e07b] via-[#eab308] to-[#c98a00]
                  text-white hover:opacity-90 transition shadow-md">
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
