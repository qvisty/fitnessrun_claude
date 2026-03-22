@extends('layouts.app')
@section('title', 'Add Contestant')
@section('content')
<h2>Add Contestant</h2>
<form method="POST" action="{{ route('contestants.store') }}">
    @csrf
    <fieldset>
        <legend>Contestant Details</legend>
        <label>ID (Barcode)</label>
        <input type="text" name="id" value="{{ old('id') }}" required>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
        <label>Team</label>
        <input type="text" name="team" value="{{ old('team') }}">
        <label><input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}> Active</label>
    </fieldset>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('contestants.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
