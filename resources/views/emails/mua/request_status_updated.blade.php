<p>Halo {{ $muaRequest->user->name }},</p>

<p>Status pengajuanmu untuk menjadi MUA di AdatKu telah diperbarui:</p>

<p>
    <strong>Status:</strong> {{ strtoupper($muaRequest->status) }}
</p>

@if($muaRequest->catatan_admin)
    <p>
        <strong>Catatan dari Admin:</strong><br>
        {{ $muaRequest->catatan_admin }}
    </p>
@endif

<p>
    @if($muaRequest->status === 'approved')
        Selamat! Akunmu sekarang sudah memiliki akses sebagai MUA di AdatKu.
    @else
        Mohon maaf, pengajuanmu belum bisa disetujui saat ini.
    @endif
</p>

<p>Salam,<br>Tim AdatKu</p>
