@extends('layouts.app')
@section('title', 'Add Race Finishtime')
@section('content')
<h2>Add Race Finishtime</h2>
<form method="POST" action="{{ route('race-finishtimes.store') }}">
    @csrf
    <fieldset>
        <legend>Race Finishtime</legend>
        <label>Contestant</label>
        <select name="contestant_id">
            @foreach($contestants as $id => $name)
                <option value="{{ $id }}" {{ old('contestant_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <label>Race</label>
        <select name="race_id">
            @foreach($races as $id => $name)
                <option value="{{ $id }}" {{ old('race_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <label>Finishtime</label>
        <input type="datetime-local" name="finishtime" value="{{ old('finishtime') }}" step="1" required>
    </fieldset>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('race-finishtimes.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
