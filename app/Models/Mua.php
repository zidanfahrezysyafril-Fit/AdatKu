<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mua extends Model
{
    protected $table = 'muas';
    public $incrementing = false;        // UUID bukan auto increment
    protected $keyType = 'string';
    protected $fillable = [
        'nama_usaha',
        'kontak_wa',
        'alamat',
        'instagram',
        'tiktok',
        'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate UUID otomatis saat create
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
