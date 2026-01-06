<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempatPkl extends Model
{
    protected $table = 'tempat_pkls';

    protected $fillable = [
        'nama',
        'alamat',
        'pembimbing',
        'telp',
        'latitude',
        'longitude',
        'radius'
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}
