@extends('layouts.app')
@section('title', 'Race: ' . $race->name)
@section('content')
<h2>{{ $race->name }}</h2>
<table>
    <tr><th>Name</th><td>{{ $race->name }}</td></tr>
    <tr><th>ID</th><td>{{ $race->id }}</td></tr>
    <tr><th>Start Time</th><td>{{ $race->starttime }}</td></tr>
    <tr><th>End Time</th><td>{{ $race->endtime }}</td></tr>
    <tr><th>Active</th><td>{{ $race->active ? 'Yes' : 'No' }}</td></tr>
</table>
<br>
<a href="{{ route('races.edit', $race) }}" class="btn">Edit</a>
<form class="inline" method="POST" action="{{ route('races.destroy', $race) }}" onsubmit="return confirm('Delete this race? This will remove all related data like laps and finishtimes.')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
<a href="{{ route('races.index') }}" class="btn btn-secondary">Back</a>

<h3>Related Contestant Finishtimes</h3>
@if($race->contestantFinishtimes->isNotEmpty())
<table>
    <thead><tr><th>ID</th><th>Contestant ID</th><th>Finishtime</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach($race->contestantFinishtimes as $ft)
        <tr>
            <td>{{ $ft->id }}</td>
            <td>{{ $ft->contestant_id }}</td>
            <td>{{ $ft->finishtime }}</td>
            <td>
                <a href="{{ route('contestant-finishtimes.show', $ft) }}" class="btn btn-secondary">View</a>
                <a href="{{ route('contestant-finishtimes.edit', $ft) }}" class="btn">Edit</a>
                <form class="inline" method="POST" action="{{ route('contestant-finishtimes.destroy', $ft) }}" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No finishtimes recorded.</p>
@endif

<h3>Related Contestant Laps</h3>
@if($race->contestantLaps->isNotEmpty())
<table>
    <thead><tr><th>ID</th><th>Contestant ID</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach($race->contestantLaps as $lap)
        <tr>
            <td>{{ $lap->id }}</td>
            <td>{{ $lap->contestant_id }}</td>
            <td>
                <a href="{{ route('contestant-laps.show', $lap) }}" class="btn btn-secondary">View</a>
                <a href="{{ route('contestant-laps.edit', $lap) }}" class="btn">Edit</a>
                <form class="inline" method="POST" action="{{ route('contestant-laps.destroy', $lap) }}" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No laps recorded.</p>
@endif

<h3>Related Race Contestants</h3>
@if($race->raceContestants->isNotEmpty())
<table>
    <thead><tr><th>ID</th><th>Contestant ID</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach($race->raceContestants as $rc)
        <tr>
            <td>{{ $rc->id }}</td>
            <td>{{ $rc->contestant_id }}</td>
            <td>
                <a href="{{ route('race-contestants.show', $rc) }}" class="btn btn-secondary">View</a>
                <a href="{{ route('race-contestants.edit', $rc) }}" class="btn">Edit</a>
                <form class="inline" method="POST" action="{{ route('race-contestants.destroy', $rc) }}" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No contestants registered.</p>
@endif
@endsection
