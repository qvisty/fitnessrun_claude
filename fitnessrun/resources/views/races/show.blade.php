@extends('layouts.app')
@section('title', 'Race: ' . $race->name)
@section('content')
<h2>Race: {{ $race->name }}</h2>
<p><strong>Start:</strong> {{ $race->starttime }} | <strong>End:</strong> {{ $race->endtime }} | <strong>Active:</strong> {{ $race->active ? 'Yes' : 'No' }}</p>
<p>
    <a href="{{ route('races.edit', $race) }}" class="btn">Edit</a>
    <a href="{{ route('races.index') }}" class="btn btn-secondary">Back</a>
</p>
<h3>Contestants ({{ $race->raceContestants->count() }})</h3>
<h3>Laps ({{ $race->contestantLaps->count() }})</h3>
<h3>Finishtimes ({{ $race->contestantFinishtimes->count() }})</h3>
@endsection
