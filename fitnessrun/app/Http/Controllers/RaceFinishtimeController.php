<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Race;
use App\Models\RaceFinishtime;
use Illuminate\Http\Request;

class RaceFinishtimeController extends Controller
{
    public function index()
    {
        $raceFinishtimes = RaceFinishtime::with(['contestant', 'race'])->paginate(20);
        return view('race_finishtimes.index', compact('raceFinishtimes'));
    }

    public function create()
    {
        $contestants = Contestant::where('active', true)->pluck('name', 'id');
        $races = Race::pluck('name', 'id');
        return view('race_finishtimes.create', compact('contestants', 'races'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contestant_id' => 'required|exists:contestants,id',
            'race_id' => 'required|exists:races,id',
            'finishtime' => 'required|date',
        ]);
        RaceFinishtime::create($validated);
        return redirect()->route('race-finishtimes.index')->with('success', 'The race finishtime has been saved.');
    }

    public function show(RaceFinishtime $raceFinishtime)
    {
        return view('race_finishtimes.show', compact('raceFinishtime'));
    }

    public function edit(RaceFinishtime $raceFinishtime)
    {
        $contestants = Contestant::pluck('name', 'id');
        $races = Race::pluck('name', 'id');
        return view('race_finishtimes.edit', compact('raceFinishtime', 'contestants', 'races'));
    }

    public function update(Request $request, RaceFinishtime $raceFinishtime)
    {
        $validated = $request->validate([
            'contestant_id' => 'required|exists:contestants,id',
            'race_id' => 'required|exists:races,id',
            'finishtime' => 'required|date',
        ]);
        $raceFinishtime->update($validated);
        return redirect()->route('race-finishtimes.index')->with('success', 'The race finishtime has been saved.');
    }

    public function destroy(RaceFinishtime $raceFinishtime)
    {
        $raceFinishtime->delete();
        return redirect()->route('race-finishtimes.index')->with('success', 'The race finishtime has been deleted.');
    }
}
