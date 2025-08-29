<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenilaianSayembara extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'penilaian_sayembara';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sayembara_progress_id',
        'aspek_penilaian_id',
        'juri_id',
        'skor',
    ];

    /** 
     * Get the project submission that owns the score.
     */
    public function sayembaraProgress(): BelongsTo
    {
        return $this->belongsTo(SayembaraProgress::class);
    }

    /**
     * Get the assessment aspect that owns the score.
     */
    public function aspekPenilaian(): BelongsTo
    {
        return $this->belongsTo(AspekPenilaian::class);
    }

    /**
     * Get the user (judge) who gave the score.
     */
    public function juri(): BelongsTo
    {
        return $this->belongsTo(User::class, 'juri_id');
    }
}