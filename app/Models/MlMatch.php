<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'end_time'
    ];

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
