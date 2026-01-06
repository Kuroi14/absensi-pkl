<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'siswa_id','tanggal',
        'check_in_time','check_out_time',
        'check_in_lat','check_in_lng',
        'check_out_lat','check_out_lng',
        'check_in_foto','check_out_foto',
        'status'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
