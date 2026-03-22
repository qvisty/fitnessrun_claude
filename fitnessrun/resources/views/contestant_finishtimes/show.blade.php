@extends('layouts.app')
@section('title', 'Contestant Finishtime #' . $contestantFinishtime->id)
@section('content')
<h2>Contestant Finishtime #{{ $contestantFinishtime->id }}</h2>
<table>
    <tr><th>Contestant</th><td><a href="{{ route('contestants.show', $contestantFinishtime->contestant) }}">{{ $contestantFinishtime->contestant->name }}</a></td></tr>
    <tr><th>Race</th><td><a href="{{ route('races.show', $contestantFinishtime->race) }}">{{ $contestantFinishtime->race->name }}</a></td></tr>
    <tr><th>Finishtime</th><td>{{ $contestantFinishtime->finishtime }}</td></tr>
</table>
<br>
<a href="{{ route('contestant-finishtimes.edit', $contestantFinishtime) }}" class="btn">Edit</a>
<form class="inline" method="POST" action="{{ route('contestant-finishtimes.destroy', $contestantFinishtime) }}" onsubmit="return confirm('Delete?')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
<a href="{{ route('contestant-finishtimes.index') }}" class="btn btn-secondary">Back</a>
@endsection
