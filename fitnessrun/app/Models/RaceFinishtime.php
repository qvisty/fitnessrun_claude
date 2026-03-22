<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaceFinishtime extends Model
{
    protected $fillable = ['contestant_id', 'race_id', 'finishtime'];

    protected $casts = [
        'finishtime' => 'datetime',
    ];

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }

    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
