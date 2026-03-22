@extends('layouts.app')
@section('title', 'Edit Race')
@section('content')
<h2>Edit Race: {{ $race->name }}</h2>
<form method="POST" action="{{ route('races.update', $race) }}">
    @csrf @method('PUT')
    <fieldset>
        <legend>Race Details</legend>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $race->name) }}" required>
        <label>Start Time</label>
        <input type="datetime-local" name="starttime" value="{{ old('starttime', $race->starttime?->format('Y-m-d\TH:i')) }}" required>
        <label>End Time</label>
        <input type="datetime-local" name="endtime" value="{{ old('endtime', $race->endtime?->format('Y-m-d\TH:i')) }}" required>
        <label><input type="checkbox" name="active" value="1" {{ old('active', $race->active) ? 'checked' : '' }}> Active</label>
    </fieldset>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('races.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
