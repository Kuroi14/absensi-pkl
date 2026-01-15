<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
    'siswa_id',
    'tanggal',
    'check_in',
    'check_out',
    'lat_in',
    'lng_in',
    'lat_out',
    'lng_out',
    'foto_in',
    'foto_out',
];


    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
