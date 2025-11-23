<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangActive extends Model
{
    protected $table = 'keranjang_active';
    protected $fillable = ['id_pengguna', 'id_mua'];
    public $incrementing = false;
}
