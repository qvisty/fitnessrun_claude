<?php

namespace App\Http\Controllers;

use App\Models\Race;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function index()
    {
        $races = Race::paginate(20);
        return view('races.index', compact('races'));
    }

    public function create()
    {
        return view('races.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'starttime' => 'required|date',
            'endtime' => 'required|date',
            'active' => 'boolean',
        ]);
        $validated['active'] = $request->boolean('active');
        Race::create($validated);
        return redirect()->route('races.index')->with('success', 'The race has been saved.');
    }

    public function show(Race $race)
    {
        $race->load('contestantFinishtimes', 'contestantLaps', 'raceContestants');
        return view('races.show', compact('race'));
    }

    public function edit(Race $race)
    {
        return view('races.edit', compact('race'));
    }

    public function update(Request $request, Race $race)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'starttime' => 'required|date',
            'endtime' => 'required|date',
            'active' => 'boolean',
        ]);
        $validated['active'] = $request->boolean('active');
        $race->update($validated);
        return redirect()->route('races.index')->with('success', 'The race has been saved.');
    }

    public function destroy(Race $race)
    {
        $race->delete(); // cascades to laps, finishtimes, race_contestants
        return redirect()->route('races.index')->with('success', 'The race has been deleted.');
    }
}
