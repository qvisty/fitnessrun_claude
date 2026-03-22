@extends('layouts.app')
@section('title', 'Race Contestant #' . $raceContestant->id)
@section('content')
<h2>Race Contestant #{{ $raceContestant->id }}</h2>
<table>
    <tr><th>Race</th><td><a href="{{ route('races.show', $raceContestant->race) }}">{{ $raceContestant->race->name }}</a></td></tr>
    <tr><th>Contestant</th><td><a href="{{ route('contestants.show', $raceContestant->contestant) }}">{{ $raceContestant->contestant->name }}</a></td></tr>
</table>
<br>
<a href="{{ route('race-contestants.edit', $raceContestant) }}" class="btn">Edit</a>
<form class="inline" method="POST" action="{{ route('race-contestants.destroy', $raceContestant) }}" onsubmit="return confirm('Delete?')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
<a href="{{ route('race-contestants.index') }}" class="btn btn-secondary">Back</a>
@endsection
