@extends('layouts.app')
@section('title', 'Edit Contestant Lap')
@section('content')
<h2>Edit Contestant Lap #{{ $contestantLap->id }}</h2>
<form method="POST" action="{{ route('contestant-laps.update', $contestantLap) }}">
    @csrf @method('PUT')
    <fieldset>
        <legend>Edit Contestant Lap</legend>
        <label>Contestant</label>
        <select name="contestant_id">
            @foreach($contestants as $id => $name)
                <option value="{{ $id }}" {{ old('contestant_id', $contestantLap->contestant_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <label>Race</label>
        <select name="race_id">
            @foreach($races as $id => $name)
                <option value="{{ $id }}" {{ old('race_id', $contestantLap->race_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </fieldset>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('contestant-laps.index') }}" class="btn btn-secondary">Cancel</a>
</form>
<form method="POST" action="{{ route('contestant-laps.destroy', $contestantLap) }}" onsubmit="return confirm('Delete?')" style="display:inline">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
@endsection
