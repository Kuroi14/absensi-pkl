<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'mapel',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
