<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mua extends Model
{
    use HasUuids, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

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
}
