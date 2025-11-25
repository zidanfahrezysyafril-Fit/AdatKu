<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'role',
        'division',
        'photo',
        'urutan',
        'is_highlight',
        'is_active',
    ];
}
