<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class izin extends Model
{
   public function siswa(){
    return $this->belongsTo(Siswa::class);
}
}
