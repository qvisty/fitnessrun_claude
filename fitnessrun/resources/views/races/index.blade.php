@extends('layouts.app')
@section('title', 'Races')
@section('content')
<h2>Races</h2>
<div class="actions">
    <a href="{{ route('races.create') }}" class="btn">Add Race</a>
</div>
<table>
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Start Time</th><th>End Time</th><th>Active</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($races as $race)
        <tr>
            <td>{{ $race->id }}</td>
            <td>{{ $race->name }}</td>
            <td>{{ $race->starttime }}</td>
            <td>{{ $race->endtime }}</td>
            <td>{{ $race->active ? 'Yes' : 'No' }}</td>
            <td>
                <a href="{{ route('races.show', $race) }}" class="btn btn-secondary">View</a>
                <a href="{{ route('races.edit', $race) }}" class="btn">Edit</a>
                <form class="inline" method="POST" action="{{ route('races.destroy', $race) }}" onsubmit="return confirm('Delete this race? This will remove all related data like laps and finishtimes.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $races->links() }}
@endsection
