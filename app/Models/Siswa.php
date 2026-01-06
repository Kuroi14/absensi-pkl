<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'user_id','guru_id','tempat_pkl_id',
        'nis','nama','kelas'
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

}
