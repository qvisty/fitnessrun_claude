@extends('layouts.app')
@section('title', 'Contestants')
@section('content')
<h2>Contestants</h2>
<div class="actions">
    <a href="{{ route('contestants.create') }}" class="btn">Add Contestant</a>
</div>
<table>
    <thead>
        <tr>
            <th>ID (Barcode)</th><th>Name</th><th>Team</th><th>Active</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contestants as $contestant)
        <tr>
            <td>{{ $contestant->id }}</td>
            <td>{{ $contestant->name }}</td>
            <td>{{ $contestant->team ?: '-' }}</td>
            <td>{{ $contestant->active ? 'Yes' : 'No' }}</td>
            <td>
                <a href="{{ route('contestants.edit', $contestant) }}" class="btn">Edit</a>
                <form class="inline" method="POST" action="{{ route('contestants.destroy', $contestant) }}" onsubmit="return confirm('Delete this contestant?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $contestants->links() }}
@endsection
