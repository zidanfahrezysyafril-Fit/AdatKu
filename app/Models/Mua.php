<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mua extends Model
{
    use HasFactory;
    protected $primaryKey = 'Id_Mua';
    protected $fillable = ['Id_Pengguna', 'Nama_Usaha', 'Kontak_WA', 'Rekening_Bank', 'Profile_MUA'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'Id_Pengguna');
    }

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'Id_Mua');
    }
}
