<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = ['name', 'starttime', 'endtime', 'active'];

    protected $casts = [
        'starttime' => 'datetime',
        'endtime' => 'datetime',
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

    public function contestants()
    {
        return $this->belongsToMany(Contestant::class, 'race_contestants');
    }
}
