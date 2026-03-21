<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\ContestantFinishtime;
use App\Models\ContestantLap;
use App\Models\Race;
use App\Models\RaceContestant;
use Illuminate\Http\Request;

class ContestantFinishtimeController extends Controller
{
    public function index()
    {
        $contestantFinishtimes = ContestantFinishtime::with(['contestant', 'race'])->paginate(20);
        return view('contestant_finishtimes.index', compact('contestantFinishtimes'));
    }

    public function create(Request $request)
    {
        $races = Race::where('active', true)->pluck('name', 'id');
        $contestants = collect();
        $activeRace = $request->query('activerace');

        if ($activeRace) {
            $contestants = RaceContestant::where('race_id', $activeRace)
                ->with('contestant')
                ->get()
                ->pluck('contestant.name', 'contestant_id');
        }

        return view('contestant_finishtimes.create', compact('races', 'contestants', 'activeRace'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contestant_id' => 'required|exists:contestants,id',
            'race_id' => 'required|exists:races,id',
            'finishtime' => 'required|date',
        ]);

        $alreadyFinished = ContestantFinishtime::where('race_id', $validated['race_id'])
            ->where('contestant_id', $validated['contestant_id'])
            ->exists();

        if ($alreadyFinished) {
            return redirect()->route('contestant-finishtimes.create', ['activerace' => $request->query('activerace')])
                ->with('error', 'The contestant has already finished the race. Nothing saved.');
        }

        if ($request->boolean('addLaps')) {
            $lapsCount = (int) $request->input('laps', 0);
            for ($i = 0; $i < $lapsCount; $i++) {
                ContestantLap::create([
                    'contestant_id' => $validated['contestant_id'],
                    'race_id' => $validated['race_id'],
                ]);
            }
            session()->flash('success', "The contestant laps has been saved. Laps saved: {$lapsCount}");
        }

        ContestantFinishtime::create($validated);

        return redirect()->route('contestant-finishtimes.create', ['activerace' => $request->query('activerace')])
            ->with('success', 'The contestant finishtime has been saved.');
    }

    public function destroy(ContestantFinishtime $contestantFinishtime)
    {
        $contestantFinishtime->delete();
        return redirect()->route('contestant-finishtimes.index')->with('success', 'The contestant finishtime has been deleted.');
    }
}
