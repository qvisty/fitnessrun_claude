<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contestant extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['id', 'name', 'team', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function contestantLaps()
    {
        return $this->hasMany(ContestantLap::class);
    }

    public function contestantFinishtimes()
    {
        return $this->hasMany(ContestantFinishtime::class);
    }

    public function raceContestants()
    {
        return $this->hasMany(RaceContestant::class);
    }

    public function races()
    {
        return $this->belongsToMany(Race::class, 'race_contestants');
    }

    public function raceFinishtimes()
    {
        return $this->hasMany(RaceFinishtime::class);
    }
}
