<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class izin extends Model
{
        protected $table = 'izin_absensis'; // ⬅️ GANTI sesuai nama tabel Anda

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jenis',
        'keterangan',
        'status',
    ];

   public function siswa(){
    return $this->belongsTo(Siswa::class);
}
}
