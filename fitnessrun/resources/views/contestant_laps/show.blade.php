@extends('layouts.app')
@section('title', 'Contestant Lap #' . $contestantLap->id)
@section('content')
<h2>Contestant Lap #{{ $contestantLap->id }}</h2>
<table>
    <tr><th>Contestant</th><td><a href="{{ route('contestants.show', $contestantLap->contestant) }}">{{ $contestantLap->contestant->name }}</a></td></tr>
    <tr><th>Race</th><td><a href="{{ route('races.show', $contestantLap->race) }}">{{ $contestantLap->race->name }}</a></td></tr>
    <tr><th>Registered At</th><td>{{ $contestantLap->created_at }}</td></tr>
</table>
<br>
<a href="{{ route('contestant-laps.edit', $contestantLap) }}" class="btn">Edit</a>
<form class="inline" method="POST" action="{{ route('contestant-laps.destroy', $contestantLap) }}" onsubmit="return confirm('Delete?')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
<a href="{{ route('contestant-laps.index') }}" class="btn btn-secondary">Back</a>
@endsection
