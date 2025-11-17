<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;
use App\Models\Layanan;

class Pesanan extends Model
{
    use HasUuids;

    protected $table = 'pesanans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pengguna',
        'id_layanan',
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
}
