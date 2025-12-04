<?php

namespace App\Models;

use App\Models\Mua;
use App\Models\MuaRequest;
use App\Models\Pesanan;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'google_id',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ================= RELASI =================

    public function mua()
    {
        return $this->hasOne(Mua::class);
    }

    public function pesananPengguna()
    {
        return $this->hasMany(Pesanan::class, 'id_pengguna');
    }

    public function muaRequest()
    {
        return $this->hasOne(MuaRequest::class);
    }

    // ================= HELPER ROLE =================

    public function isAdmin(): bool
    {
        return strtolower($this->role ?? '') === 'admin';
    }

    public function isMua(): bool
    {
        return strtolower($this->role ?? '') === 'mua';
    }

    public function isPengguna(): bool
    {
        return strtolower($this->role ?? '') === 'pengguna';
    }
}
