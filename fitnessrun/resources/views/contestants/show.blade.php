@extends('layouts.app')
@section('title', 'Contestant: ' . $contestant->name)
@section('content')
<h2>Contestant: {{ $contestant->name }}</h2>
<table>
    <tr><th>ID (Barcode)</th><td>{{ $contestant->id }}</td></tr>
    <tr><th>Name</th><td>{{ $contestant->name }}</td></tr>
    <tr><th>Team</th><td>{{ $contestant->team ?: '-' }}</td></tr>
    <tr><th>Active</th><td>{{ $contestant->active ? 'Yes' : 'No' }}</td></tr>
</table>
<br>
<a href="{{ route('contestants.edit', $contestant) }}" class="btn">Edit</a>
<form class="inline" method="POST" action="{{ route('contestants.destroy', $contestant) }}" onsubmit="return confirm('Delete this contestant?')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
<a href="{{ route('contestants.index') }}" class="btn btn-secondary">Back</a>
@endsection
