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
    'status',
];


    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function koreksi()
{
    return $this->hasOne(KoreksiAbsensi::class);
}
 public function approver()
{
    return $this->belongsTo(User::class, 'approved_by');
}
}
