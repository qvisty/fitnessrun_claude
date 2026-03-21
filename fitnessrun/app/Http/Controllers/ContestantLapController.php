<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\ContestantLap;
use App\Models\Race;
use App\Models\RaceContestant;
use Illuminate\Http\Request;

class ContestantLapController extends Controller
{
    public function index()
    {
        $contestantLaps = ContestantLap::with(['contestant', 'race'])->paginate(20);
        return view('contestant_laps.index', compact('contestantLaps'));
    }

    public function create(Request $request)
    {
        $races = Race::pluck('name', 'id');
        $contestants = collect();
        $activeRace = $request->query('activerace');

        if ($activeRace) {
            $contestants = RaceContestant::where('race_id', $activeRace)
                ->with('contestant')
                ->get()
                ->pluck('contestant.name', 'contestant_id');

            if ($contestants->isEmpty()) {
                session()->flash('error', 'Currently no contestants added to this race. Add some in "Race Contestants"');
            }
        }

        return view('contestant_laps.create', compact('races', 'contestants', 'activeRace'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contestant_id' => 'required|exists:contestants,id',
            'race_id' => 'required|exists:races,id',
        ]);

        $lap = ContestantLap::create($validated);
        $contestantName = Contestant::find($validated['contestant_id'])->name;

        session()->flash('success', "Successfully added lap for {$contestantName}");
        session()->flash('undo_lap_id', $lap->id);

        return redirect()->route('contestant-laps.create', [
            'activerace' => $request->query('activerace'),
            'autosubmit' => $request->query('autosubmit'),
        ]);
    }

    public function show(ContestantLap $contestantLap)
    {
        $contestantLap->load(['contestant', 'race']);
        return view('contestant_laps.show', compact('contestantLap'));
    }

    public function edit(ContestantLap $contestantLap)
    {
        $contestants = Contestant::pluck('name', 'id');
        $races = Race::pluck('name', 'id');
        return view('contestant_laps.edit', compact('contestantLap', 'contestants', 'races'));
    }

    public function update(Request $request, ContestantLap $contestantLap)
    {
        $validated = $request->validate([
            'contestant_id' => 'required|exists:contestants,id',
            'race_id' => 'required|exists:races,id',
        ]);
        $contestantLap->update($validated);
        return redirect()->route('contestant-laps.create')->with('success', 'The contestant lap has been saved.');
    }

    public function destroy(ContestantLap $contestantLap, Request $request)
    {
        $raceId = $contestantLap->race_id;
        $contestantLap->delete();

        if ($request->query('from') === 'create') {
            return redirect()->route('contestant-laps.create', ['activerace' => $raceId])
                ->with('success', 'The contestant lap has been deleted.');
        }
        return redirect()->route('contestant-laps.index')->with('success', 'The contestant lap has been deleted.');
    }
}
