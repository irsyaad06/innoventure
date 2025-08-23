<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seminar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seminars';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'tema',
        'deskripsi',
        'tanggal',
        'waktu',
        'tempat',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal' => 'datetime',
        'is_aktif' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the juri that owns the seminar.
     *
     * @return BelongsTo
     */
    public function juri(): BelongsTo
    {
        return $this->belongsTo(Juri::class, 'juri_id');
    }
}