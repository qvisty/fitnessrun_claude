<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use Illuminate\Http\Request;

class ContestantController extends Controller
{
    public function index()
    {
        $contestants = Contestant::paginate(20);
        return view('contestants.index', compact('contestants'));
    }

    public function create()
    {
        return view('contestants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:255|unique:contestants,id',
            'name' => 'required|string|max:255',
            'team' => 'nullable|string|max:255',
            'active' => 'boolean',
        ]);
        $validated['active'] = $request->boolean('active');
        $validated['team'] = $validated['team'] ?? '';
        Contestant::create($validated);
        return redirect()->route('contestants.index')->with('success', 'The contestant has been saved.');
    }

    public function show(Contestant $contestant)
    {
        return view('contestants.show', compact('contestant'));
    }

    public function edit(Contestant $contestant)
    {
        return view('contestants.edit', compact('contestant'));
    }

    public function update(Request $request, Contestant $contestant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'team' => 'nullable|string|max:255',
            'active' => 'boolean',
        ]);
        $validated['active'] = $request->boolean('active');
        $validated['team'] = $validated['team'] ?? '';
        $contestant->update($validated);
        return redirect()->route('contestants.index')->with('success', 'The contestant has been saved.');
    }

    public function destroy(Contestant $contestant)
    {
        $contestant->delete();
        return redirect()->route('contestants.index')->with('success', 'The contestant has been deleted.');
    }
}
