<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mua extends Model
{
    protected $guarded = [];
    protected $table  = 'mua';

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'mua_id');
    }
}
