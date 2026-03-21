@extends('layouts.app')
@section('title', 'Race Contestants')
@section('content')
<h2>Race Contestants</h2>
<div class="actions">
    <a href="{{ route('race-contestants.manage') }}" class="btn">Manage Race Contestants</a>
</div>
<table>
    <thead>
        <tr><th>ID</th><th>Race</th><th>Contestant</th></tr>
    </thead>
    <tbody>
        @foreach($raceContestants as $rc)
        <tr>
            <td>{{ $rc->id }}</td>
            <td>{{ $rc->race->name ?? $rc->race_id }}</td>
            <td>{{ $rc->contestant->name ?? $rc->contestant_id }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $raceContestants->links() }}
@endsection
