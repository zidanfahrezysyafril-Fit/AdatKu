<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MuaPortfolio extends Model
{
    protected $fillable = [
        'mua_id',
        'foto_path',
    ];

    public function mua(): BelongsTo
    {
        return $this->belongsTo(Mua::class);
    }
}
