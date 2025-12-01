<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Mua extends Model
{

    protected $fillable = [
        'user_id',
        'nama_usaha',
        'kontak_wa',
        'alamat',
        'deskripsi',
        'instagram',
        'tiktok',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'mua_id');
    }

    public function portfolios()
    {
        return $this->hasMany(MuaPortfolio::class, 'mua_id');
    }
}
