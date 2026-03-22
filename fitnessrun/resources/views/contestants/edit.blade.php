@extends('layouts.app')
@section('title', 'Edit Contestant')
@section('content')
<h2>Edit Contestant: {{ $contestant->name }}</h2>
<form method="POST" action="{{ route('contestants.update', $contestant) }}">
    @csrf @method('PUT')
    <fieldset>
        <legend>Contestant Details</legend>
        <label>ID (Barcode)</label>
        <input type="text" value="{{ $contestant->id }}" disabled>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $contestant->name) }}" required>
        <label>Team</label>
        <input type="text" name="team" value="{{ old('team', $contestant->team) }}">
        <label><input type="checkbox" name="active" value="1" {{ old('active', $contestant->active) ? 'checked' : '' }}> Active</label>
    </fieldset>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('contestants.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
