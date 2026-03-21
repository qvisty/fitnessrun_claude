@extends('layouts.app')
@section('title', 'Race Finishtime')
@section('content')
<h2>Race Finishtime</h2>
<table>
    <tr><th>ID</th><td>{{ $raceFinishtime->id }}</td></tr>
    <tr><th>Contestant</th><td>{{ $raceFinishtime->contestant->name ?? $raceFinishtime->contestant_id }}</td></tr>
    <tr><th>Race</th><td>{{ $raceFinishtime->race->name ?? $raceFinishtime->race_id }}</td></tr>
    <tr><th>Finishtime</th><td>{{ $raceFinishtime->finishtime }}</td></tr>
</table>
<br>
<a href="{{ route('race-finishtimes.edit', $raceFinishtime) }}" class="btn">Edit</a>
<form class="inline" method="POST" action="{{ route('race-finishtimes.destroy', $raceFinishtime) }}" onsubmit="return confirm('Delete this race finishtime?')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
<a href="{{ route('race-finishtimes.index') }}" class="btn btn-secondary">Back</a>
@endsection
