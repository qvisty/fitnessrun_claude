@extends('layouts.app')
@section('title', 'Add Race')
@section('content')
<h2>Add Race</h2>
<form method="POST" action="{{ route('races.store') }}">
    @csrf
    <fieldset>
        <legend>Race Details</legend>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
        <label>Start Time</label>
        <input type="datetime-local" name="starttime" value="{{ old('starttime') }}" required>
        <label>End Time</label>
        <input type="datetime-local" name="endtime" value="{{ old('endtime') }}" required>
        <label><input type="checkbox" name="active" value="1" {{ old('active') ? 'checked' : '' }}> Active</label>
    </fieldset>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('races.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
