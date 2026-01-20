<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
  protected $fillable = [
    'user_id',
    'guru_id',
    'tempat_pkl_id',
    'nis',
    'nama',
    'kelas',
    'no_telp_siswa',
    'no_telp_ortu',
    'jenis_kelamin',
    'tempat_lahir',
    'tanggal_lahir',
    'alamat'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function tempatPkl()
    {
        return $this->belongsTo(TempatPkl::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function izins()
    {
        return $this->hasMany(Izin::class);
    }
}

