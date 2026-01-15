<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiLog extends Model
{
    protected $fillable = [
        'siswa_id','tanggal','jarak','keterangan'
    ];
}


