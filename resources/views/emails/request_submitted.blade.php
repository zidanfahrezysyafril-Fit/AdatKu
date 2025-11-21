<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - AdatKu</title>
</head>

<body>
    <p>Halo Admin,</p>

    <p>Ada pengajuan baru untuk menjadi MUA:</p>

    <ul>
        <li>Nama User: {{ $muaRequest->user->name }}</li>
        <li>Email User: {{ $muaRequest->user->email }}</li>
        <li>Nama Usaha: {{ $muaRequest->nama_usaha }}</li>
        <li>Kontak WA: {{ $muaRequest->kontak_wa }}</li>
    </ul>

    <p>Silakan review di halaman admin.</p>

    <p>Salam,<br>AdatKu</p>
</body>

</html>