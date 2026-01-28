<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinAbsensi extends Model
{
    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jenis',
        'keterangan',
        'bukti',
        'status',
        'approved_by',
        'approved_at'
    ];
    protected $casts = [
        'tanggal' => 'date',
        'approved_at' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
