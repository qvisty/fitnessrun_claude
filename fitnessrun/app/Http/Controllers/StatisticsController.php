<?php

namespace App\Http\Controllers;

use App\Models\ContestantFinishtime;
use App\Models\ContestantLap;
use App\Models\Race;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $races = Race::all();
        return view('statistics.index', compact('races'));
    }

    public function show($raceId)
    {
        $race = Race::find($raceId);

        if (!$race) {
            return redirect()->route('statistics.index')->with('error', 'Unable to find any race with the given criteria.');
        }

        if (!$race->active) {
            session()->flash('info', 'This race is not active. Maybe it has finished? If a mistake then activate it again in the menu "Races"');
        } else {
            session()->flash('info', 'This race is an active race. For updated statistics please refresh this page once a while');
        }

        $finishtimes = ContestantFinishtime::where('race_id', $raceId)
            ->with('contestant')
            ->get();

        $raceStarttime = $race->starttime;

        $contestants = [];
        $teamStats = [];

        foreach ($finishtimes as $finishtime) {
            $contestant = $finishtime->contestant;
            $stat = [];
            $stat['id'] = $contestant->id;
            $stat['name'] = $contestant->name;
            $stat['team'] = $contestant->team ?: 'Unknown';
            $stat['finishtime'] = $finishtime->finishtime;
            $stat['lapscount'] = ContestantLap::where('contestant_id', $contestant->id)
                ->where('race_id', $raceId)
                ->count();

            $seconds = abs($finishtime->finishtime->timestamp - $raceStarttime->timestamp);
            $stat['time'] = $seconds;

            $contestants[] = $stat;

            // Team stats
            $team = $stat['team'];
            if (isset($teamStats[$team])) {
                $teamStats[$team]['lapscount'] += $stat['lapscount'];
                $teamStats[$team]['time'] += $stat['time'];
            } else {
                $teamStats[$team] = [
                    'name' => $team,
                    'lapscount' => $stat['lapscount'],
                    'time' => $stat['time'],
                ];
            }
        }

        // Sort contestants: most laps first, then by finishtime ascending
        usort($contestants, function ($a, $b) {
            if ($a['lapscount'] === $b['lapscount']) {
                return $a['finishtime'] <=> $b['finishtime'];
            }
            return $b['lapscount'] <=> $a['lapscount'];
        });

        usort($teamStats, function ($a, $b) {
            if ($a['lapscount'] === $b['lapscount']) {
                return $a['time'] <=> $b['time'];
            }
            return $b['lapscount'] <=> $a['lapscount'];
        });

        if (empty($contestants)) {
            session()->flash('info', 'No contestants that have finished this race yet.');
        }

        return view('statistics.show', compact('contestants', 'teamStats', 'race'));
    }
}
