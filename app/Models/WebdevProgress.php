<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebdevProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'tim_id',
        'web_app_uploaded',
        'ppt_uploaded'
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
}
