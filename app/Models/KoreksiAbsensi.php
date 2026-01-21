<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoreksiAbsensi extends Model
{
    protected $fillable = [
        'absensi_id',
        'siswa_id',
        'tanggal',
        'check_in_time',
        'check_out_time',
        'lat_in',
        'lng_in',
        'lat_out',
        'lng_out',
        'foto_in',
        'foto_out',
        'status',
        'alasan',
        'approved_by',
        'approved_at'
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}

