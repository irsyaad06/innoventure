<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MlMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'round',
        'tim1_id',
        'tim2_id',
        'best_of',
        'tim1_score',
        'tim2_score',
        'winner_id',
        'status',
        'start_time',
        'end_time',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($match) {
            $neededWins = intval(($match->best_of / 2) + 1);

            if ($match->tim1_score >= $neededWins) {
                $match->winner_id = $match->tim1_id;
                $match->status = 'finished';
            } elseif ($match->tim2_score >= $neededWins) {
                $match->winner_id = $match->tim2_id;
                $match->status = 'finished';
            } else {
                $match->winner_id = null;

                // kalau skor masih kosong / belum selesai
                if ($match->status !== 'live') {
                    $match->status = 'upcoming';
                }
            }
        });
    }

    public function tim1()
    {
        return $this->belongsTo(Tim::class, 'tim1_id');
    }

    public function tim2()
    {
        return $this->belongsTo(Tim::class, 'tim2_id');
    }

    public function winner()
    {
        return $this->belongsTo(Tim::class, 'winner_id');
    }
}
