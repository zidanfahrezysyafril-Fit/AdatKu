<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Layanan extends Model
{
    use HasUuids;

    protected $table = 'layanans';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['mua_id', 'nama', 'harga', 'kategori', 'deskripsi', 'foto'];

    public function mua()
    {
        return $this->belongsTo(Mua::class, 'mua_id');
    }
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_layanan');
    }
}
