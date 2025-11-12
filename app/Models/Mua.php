<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Mua extends Model
{
    use SoftDeletes, HasUuids;
    protected $table = 'muas';
    public $incrementing = false;      
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'nama_usaha',
        'kontak_wa',
        'deskripsi',
        'alamat',
        'instagram',
        'tiktok',
        'foto',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
