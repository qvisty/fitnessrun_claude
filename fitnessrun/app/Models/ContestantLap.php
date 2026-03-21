<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestantLap extends Model
{
    protected $fillable = ['contestant_id', 'race_id'];

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }

    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
