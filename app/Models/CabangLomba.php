<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CabangLomba extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'jenis_penilaian', 'tanggal_mulai', 'tanggal_berakhir'
    ];

    public function tims()
    {
        return $this->hasMany(Tim::class);
    }
}
