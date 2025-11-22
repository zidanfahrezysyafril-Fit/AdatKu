<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    // HAPUS HasUuids dan pengaturan UUID

    protected $table = 'layanans';

    // biarkan default: $incrementing = true, keyType = int
    protected $fillable = [
        'mua_id',
        'nama',
        'harga',
        'kategori',
        'deskripsi',
        'foto',
    ];

    public function mua()
    {
        return $this->belongsTo(Mua::class, 'mua_id');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_layanan');
    }
}
