<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class External extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'external';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'logo',
        'email',
        'no_hp',
        'is_aktif',
        'jenis',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_aktif' => 'boolean',
        'jenis' => 'string', // Casting enum sebagai string
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}