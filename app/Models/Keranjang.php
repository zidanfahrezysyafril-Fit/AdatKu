<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Keranjang extends Model
{
    use HasUuids;

    protected $table = 'keranjangs';
    protected $fillable = ['id_pengguna', 'id_layanan', 'jumlah'];

    public function pengguna() {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function layanan() {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
}
