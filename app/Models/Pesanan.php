<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Pembayaran;

class Pesanan extends Model
{
    protected $table = 'pesanans';
    // primaryKey default sudah 'id', jadi gak perlu di-set lagi

    // BIARKAN auto increment default (true) dan keyType 'int'
    protected $fillable = [
        'id_pengguna',
        'id_layanan',
        'kode_checkout',
        'tanggal_booking',
        'alamat',
        'total_harga',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'total_harga'     => 'decimal:2',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan');
    }
}
