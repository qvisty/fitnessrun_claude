@extends('layouts.app')
@section('title', 'Edit Race Contestant')
@section('content')
<h2>Edit Race Contestant #{{ $raceContestant->id }}</h2>
<form method="POST" action="{{ route('race-contestants.edit-update', $raceContestant) }}">
    @csrf @method('PUT')
    <fieldset>
        <legend>Edit Race Contestant</legend>
        <label>Race</label>
        <select name="race_id">
            @foreach($races as $id => $name)
                <option value="{{ $id }}" {{ old('race_id', $raceContestant->race_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <label>Contestant</label>
        <select name="contestant_id">
            @foreach($contestants as $id => $name)
                <option value="{{ $id }}" {{ old('contestant_id', $raceContestant->contestant_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </fieldset>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('race-contestants.index') }}" class="btn btn-secondary">Cancel</a>
</form>
<form method="POST" action="{{ route('race-contestants.destroy', $raceContestant) }}" onsubmit="return confirm('Delete?')" style="display:inline">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
@endsection
