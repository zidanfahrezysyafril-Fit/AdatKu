<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $guarded = [];
    protected $table  = 'layanan';

    public function mua()
    {
        return $this->belongsTo(Mua::class, 'mua_id');
    }
}
