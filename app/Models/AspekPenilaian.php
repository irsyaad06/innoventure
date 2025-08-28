<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AspekPenilaian extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aspek_penilaians';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_cabang_lomba',
        'nama',
        'bobot_penilaian',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'bobot_penilaian' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the cabang lomba that owns the aspek penilaian.
     *
     * @return BelongsTo
     */

    protected $appends = ['nama_with_cabang'];
    public function cabangLomba(): BelongsTo
    {
        return $this->belongsTo(CabangLomba::class, 'id_cabang_lomba');
    }


    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    public function juris()
    {
        return $this->belongsToMany(Juri::class, 'aspek_penilaian_juri');
    }
    protected function namaWithCabang(): Attribute
    {
        return Attribute::make(
            get: fn() => optional($this->cabangLomba)->nama . " | {$this->nama}"
        );
    }
}
