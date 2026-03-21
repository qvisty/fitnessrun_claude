@extends('layouts.app')
@section('title', 'Race Statistics')
@section('content')
<h2>Race Statistics</h2>
<table>
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Start Time</th><th>End Time</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($races as $race)
        <tr>
            <td>{{ $race->id }}</td>
            <td>{{ $race->name }}</td>
            <td>{{ $race->starttime }}</td>
            <td>{{ $race->endtime }}</td>
            <td><a href="{{ route('statistics.show', $race->id) }}" class="btn">View</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
