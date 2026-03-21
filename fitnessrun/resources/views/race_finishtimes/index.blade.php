@extends('layouts.app')
@section('title', 'Race Finishtimes')
@section('content')
<h2>Race Finishtimes</h2>
<div class="actions">
    <a href="{{ route('race-finishtimes.create') }}" class="btn">Add Race Finishtime</a>
</div>
<table>
    <thead>
        <tr><th>ID</th><th>Contestant</th><th>Race</th><th>Finishtime</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @foreach($raceFinishtimes as $ft)
        <tr>
            <td>{{ $ft->id }}</td>
            <td>{{ $ft->contestant->name ?? $ft->contestant_id }}</td>
            <td>{{ $ft->race->name ?? $ft->race_id }}</td>
            <td>{{ $ft->finishtime }}</td>
            <td>
                <a href="{{ route('race-finishtimes.show', $ft) }}" class="btn btn-secondary">View</a>
                <a href="{{ route('race-finishtimes.edit', $ft) }}" class="btn">Edit</a>
                <form class="inline" method="POST" action="{{ route('race-finishtimes.destroy', $ft) }}" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $raceFinishtimes->links() }}
@endsection
