@extends('layouts.app')
@section('title', 'Edit Contestant Finishtime')
@section('content')
<h2>Edit Contestant Finishtime #{{ $contestantFinishtime->id }}</h2>
<form method="POST" action="{{ route('contestant-finishtimes.update', $contestantFinishtime) }}">
    @csrf @method('PUT')
    <fieldset>
        <legend>Edit Contestant Finishtime</legend>
        <label>Contestant</label>
        <select name="contestant_id">
            @foreach($contestants as $id => $name)
                <option value="{{ $id }}" {{ old('contestant_id', $contestantFinishtime->contestant_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <label>Race</label>
        <select name="race_id">
            @foreach($races as $id => $name)
                <option value="{{ $id }}" {{ old('race_id', $contestantFinishtime->race_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <label>Finishtime</label>
        <input type="datetime-local" name="finishtime" value="{{ old('finishtime', $contestantFinishtime->finishtime?->format('Y-m-d\TH:i:s')) }}" step="1" required>
    </fieldset>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('contestant-finishtimes.index') }}" class="btn btn-secondary">Cancel</a>
</form>
<form method="POST" action="{{ route('contestant-finishtimes.destroy', $contestantFinishtime) }}" onsubmit="return confirm('Delete?')" style="display:inline">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
@endsection
