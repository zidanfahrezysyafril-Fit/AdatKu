<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'kategori',
        'judul',
        'deskripsi',
        'image_path',
        'urutan',
        'is_active',
    ];
}