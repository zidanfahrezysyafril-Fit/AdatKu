<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $primaryKey = 'Id_Layanan';
    protected $fillable = [
        'Id_Mua', 'Id_Pengguna', 'Nama_Layanan', 'Kategori',
        'Deskripsi', 'Ukuran_Status', 'Harga'
    ];

    public function mua()
    {
        return $this->belongsTo(Mua::class, 'Id_Mua');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'Id_Pengguna');
    }
}
