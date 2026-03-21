@extends('layouts.app')
@section('title', 'Contestant Laps')
@section('content')
<h2>Contestant Laps</h2>
<div class="actions">
    <a href="{{ route('contestant-laps.create') }}" class="btn">Register Lap</a>
</div>
<table>
    <thead>
        <tr>
            <th>ID</th><th>Contestant</th><th>Race</th><th>Registered At</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contestantLaps as $lap)
        <tr>
            <td>{{ $lap->id }}</td>
            <td>{{ $lap->contestant->name ?? $lap->contestant_id }}</td>
            <td>{{ $lap->race->name ?? $lap->race_id }}</td>
            <td>{{ $lap->created_at }}</td>
            <td>
                <form class="inline" method="POST" action="{{ route('contestant-laps.destroy', $lap) }}" onsubmit="return confirm('Delete this lap?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $contestantLaps->links() }}
@endsection
