<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Layanan extends Model
{
    use HasUuids;

    protected $table = 'layanans'; // <- PENTING kalau tabelnya bukan "layanans"
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['mua_id', 'nama', 'harga', 'kategori', 'deskripsi', 'foto'];

    public function mua()
    {
        return $this->belongsTo(Mua::class, 'mua_id');
    }
}
