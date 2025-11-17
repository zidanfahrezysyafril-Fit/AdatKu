<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

public function mua()
{
    return $this->belongsTo(\App\Models\Mua::class);
}

public function layanan()
{
    return $this->belongsTo(\App\Models\Layanan::class);
}
}
