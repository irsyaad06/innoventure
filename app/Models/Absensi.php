<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';

    protected $fillable = [
        'daftar_seminar_id',
        'waktu_absen',
        'keterangan',
    ];

    protected $casts = [
        'waktu_absen' => 'datetime',
    ];

    public function peserta()
    {
        return $this->belongsTo(DaftarSeminar::class, 'daftar_seminar_id');
    }
}
