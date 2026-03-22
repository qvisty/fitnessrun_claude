@extends('layouts.app')
@section('title', 'Contestant Finishtimes')
@section('content')
<h2>Contestant Finishtimes</h2>
<div class="actions">
    <a href="{{ route('contestant-finishtimes.create') }}" class="btn">Register Finishtime</a>
</div>
<table>
    <thead>
        <tr>
            <th>ID</th><th>Contestant</th><th>Race</th><th>Finishtime</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contestantFinishtimes as $ft)
        <tr>
            <td>{{ $ft->id }}</td>
            <td>{{ $ft->contestant->name ?? $ft->contestant_id }}</td>
            <td>{{ $ft->race->name ?? $ft->race_id }}</td>
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
{{ $contestantFinishtimes->links() }}
@endsection
