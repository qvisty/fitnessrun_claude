<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaceContestant extends Model
{
    protected $fillable = ['race_id', 'contestant_id'];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }
}
