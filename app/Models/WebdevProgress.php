<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebdevProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'tim_id',
        'email_ketua',
        'judul_proyek',
        'deskripsi_pdf',
        'link_repository',
        'link_demo',
        'link_hosting',
        'ppt',
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
}
