@extends('layouts.app')
@section('title', 'Race Contestants')
@section('content')
<h2>Race Contestants</h2>
<div class="actions">
    <a href="{{ route('race-contestants.manage') }}" class="btn">Manage Race Contestants</a>
</div>
<table>
    <thead>
        <tr><th>ID</th><th>Race</th><th>Contestant</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @foreach($raceContestants as $rc)
        <tr>
            <td>{{ $rc->id }}</td>
            <td>{{ $rc->race->name ?? $rc->race_id }}</td>
            <td>{{ $rc->contestant->name ?? $rc->contestant_id }}</td>
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
{{ $raceContestants->links() }}
@endsection
