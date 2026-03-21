@extends('layouts.app')
@section('title', 'Statistics: ' . $race->name)
@section('content')

<div id="TimeLabel" style="font-weight:bold;margin-bottom:10px;"></div>

<p><a href="{{ route('statistics.index') }}" class="btn btn-secondary">&larr; All Statistics</a></p>

<h2>Statistics: {{ $race->name }}</h2>

<h3>Teams</h3>
<table>
    <thead>
        <tr><th>Name</th><th>Laps</th><th>Time</th></tr>
    </thead>
    <tbody>
        @foreach($teamStats as $team)
        <tr>
            <td>{{ $team['name'] }}</td>
            <td>{{ $team['lapscount'] }}</td>
            <td>
                @php
                    $s = $team['time'];
                    printf('%02d:%02d:%02d', floor($s/3600), floor($s/60%60), $s%60);
                @endphp
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Contestants</h3>
<table>
    <thead>
        <tr><th>ID</th><th>Name</th><th>Team</th><th>Laps</th><th>Time</th></tr>
    </thead>
    <tbody>
        @foreach($contestants as $contestant)
        <tr>
            <td>{{ $contestant['id'] }}</td>
            <td>{{ $contestant['name'] }}</td>
            <td>{{ $contestant['team'] }}</td>
            <td>{{ $contestant['lapscount'] }}</td>
            <td>
                @php
                    $s = $contestant['time'];
                    printf('%02d:%02d:%02d', floor($s/3600), floor($s/60%60), $s%60);
                @endphp
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
var countDown = 60;
setInterval(function() {
    document.getElementById('TimeLabel').textContent = 'Automatic refreshing page in: ' + countDown;
    if (--countDown <= 1) {
        document.getElementById('TimeLabel').textContent = 'Refreshing page - please hang tight!';
        location.reload();
    }
}, 1000);
</script>
@endsection
