<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Race;
use App\Models\RaceContestant;
use Illuminate\Http\Request;

class RaceContestantController extends Controller
{
    public function index()
    {
        $raceContestants = RaceContestant::with(['race', 'contestant'])->paginate(20);
        return view('race_contestants.index', compact('raceContestants'));
    }

    public function manage(Request $request)
    {
        $activeRace = $request->query('activerace');
        $teamName = $request->query('team', 'all');

        $races = Race::where('active', true)->pluck('name', 'id');

        // Build teams list
        $teamRows = Contestant::select('team')->distinct()->get();
        $teams = ['all' => 'View all'];
        foreach ($teamRows as $row) {
            if (empty($row->team)) {
                $teams['unknown'] = 'Unknown';
            } else {
                $teams[$row->team] = $row->team;
            }
        }

        // All available contestants filtered by team
        $contestantsQuery = Contestant::where('active', true);
        if ($teamName !== 'all') {
            $contestantsQuery->where('team', $teamName === 'unknown' ? '' : $teamName);
        }
        $contestants = $contestantsQuery->pluck('name', 'id');

        // Current race contestants
        $raceContestants = collect();
        if ($activeRace) {
            $raceContestants = RaceContestant::where('race_id', $activeRace)
                ->with('contestant')
                ->get()
                ->pluck('contestant.name', 'contestant_id');
        }

        return view('race_contestants.manage', compact('races', 'contestants', 'raceContestants', 'activeRace', 'teams', 'teamName'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'race_id' => 'required|exists:races,id',
        ]);

        $raceId = $request->input('race_id');
        $modifiedContestants = $request->input('raceContestants', []);

        $currentContestants = RaceContestant::where('race_id', $raceId)
            ->pluck('contestant_id')
            ->toArray();

        $toAdd = array_diff($modifiedContestants, $currentContestants);
        $toDelete = array_diff($currentContestants, $modifiedContestants);

        $added = 0;
        foreach ($toAdd as $contestantId) {
            RaceContestant::create(['race_id' => $raceId, 'contestant_id' => $contestantId]);
            $added++;
        }

        $deleted = 0;
        foreach ($toDelete as $contestantId) {
            RaceContestant::where('race_id', $raceId)->where('contestant_id', $contestantId)->delete();
            $deleted++;
        }

        if ($added > 0) {
            session()->flash('success', "The race contestants saved: {$added}");
        }
        if ($deleted > 0) {
            session()->flash('success_delete', "The race contestants removed: {$deleted}");
        }

        return redirect()->route('race-contestants.manage', [
            'activerace' => $raceId,
            'team' => $request->query('team', 'all'),
        ]);
    }
}
