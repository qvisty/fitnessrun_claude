@extends('layouts.app')
@section('title', 'Manage Race Contestants')
@section('content')
<h2>Manage Race Contestants</h2>

{{-- Race & team selector (GET form) --}}
<form id="raceForm" method="GET" action="{{ route('race-contestants.manage') }}">
    <label>Race</label>
    <select name="activerace" id="activerace">
        @foreach($races as $id => $name)
            <option value="{{ $id }}" {{ $activeRace == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
    <label>Team</label>
    <select name="team" id="team">
        @foreach($teams as $key => $label)
            <option value="{{ $key }}" {{ $teamName == $key ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</form>

<br>
<form id="mainForm" method="POST" action="{{ route('race-contestants.update') }}?activerace={{ $activeRace }}&team={{ $teamName }}">
    @csrf
    <input type="hidden" name="race_id" id="race_id" value="{{ $activeRace }}">
    <fieldset>
        <legend>Add Race Contestants</legend>
        <div style="display:flex;gap:20px;align-items:flex-start;">
            <div>
                <label>Available Contestants</label>
                <select id="contestants" size="15" style="min-width:200px;">
                    @foreach($contestants as $id => $name)
                        @if(!$raceContestants->has($id))
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div style="padding-top:60px;">
                <button type="button" id="addButton" class="btn" style="display:block;margin-bottom:8px;">Add &rarr;</button>
                <button type="button" id="removeButton" class="btn btn-secondary">&larr; Remove</button>
            </div>
            <div>
                <label>Race Contestants</label>
                <select name="raceContestants[]" id="raceContestants" multiple size="15" style="min-width:200px;">
                    @foreach($raceContestants as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </fieldset>
    @if($contestants->isNotEmpty() || $raceContestants->isNotEmpty())
        <button type="submit" id="submitBtn" class="btn">Save</button>
    @endif
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    updateActiveRace();
    updateTeams();

    document.getElementById('activerace').addEventListener('change', function() {
        document.getElementById('raceForm').submit();
    });
    document.getElementById('team').addEventListener('change', function() {
        document.getElementById('raceForm').submit();
    });

    document.getElementById('addButton').addEventListener('click', function() {
        moveOptions('contestants', 'raceContestants');
    });
    document.getElementById('removeButton').addEventListener('click', function() {
        moveOptions('raceContestants', 'contestants');
    });

    document.getElementById('contestants').addEventListener('dblclick', function() {
        moveOptions('contestants', 'raceContestants');
    });
    document.getElementById('raceContestants').addEventListener('dblclick', function() {
        moveOptions('raceContestants', 'contestants');
    });

    var submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            var opts = document.getElementById('raceContestants').options;
            for (var i = 0; i < opts.length; i++) {
                opts[i].selected = true;
            }
        });
    }
});

function moveOptions(fromId, toId) {
    var from = document.getElementById(fromId);
    var to = document.getElementById(toId);
    var selected = Array.from(from.selectedOptions);
    selected.forEach(function(opt) {
        from.removeChild(opt);
        to.appendChild(opt);
    });
}

function updateActiveRace() {
    var activeRace = getUrlParameter('activerace');
    if (!activeRace) {
        var firstOption = document.getElementById('activerace').options[0];
        if (firstOption) {
            document.getElementById('race_id').value = firstOption.value;
            document.getElementById('raceForm').submit();
        }
        return;
    }
    document.getElementById('activerace').value = activeRace;
    document.getElementById('race_id').value = activeRace;
}

function updateTeams() {
    var team = getUrlParameter('team');
    if (!team) {
        var firstOption = document.getElementById('team').options[0];
        if (firstOption) {
            document.getElementById('raceForm').submit();
        }
        return;
    }
    document.getElementById('team').value = team;
}

var getUrlParameter = function(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'), sParameterName, i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
</script>
@endsection
