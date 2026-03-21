@extends('layouts.app')
@section('title', 'Register Contestant Finishtime')
@section('content')
<h2>Register Contestant Finishtime</h2>

<p id="timerStoppedMsg" style="display:none;"><b>NOTE:</b> The automatic timer has stopped due to manual intervention of the timestamp. To start timer again please reload this page.</p>

{{-- Race selector (GET form) --}}
<form id="raceForm" method="GET" action="{{ route('contestant-finishtimes.create') }}">
    <label>Race</label>
    <select name="activerace" id="activerace">
        @foreach($races as $id => $name)
            <option value="{{ $id }}" {{ $activeRace == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
</form>

<br>
<label>Barcode</label>
<input type="text" id="barcode" placeholder="Scan barcode...">

<form id="mainForm" method="POST" action="{{ route('contestant-finishtimes.store', [], false) }}?activerace={{ $activeRace }}">
    @csrf
    <fieldset>
        <legend>Add Contestant Finishtime</legend>
        <label>Contestant</label>
        <select name="contestant_id" id="contestant_id">
            @foreach($contestants as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        <input type="hidden" name="race_id" id="race_id" value="{{ $activeRace }}">
        <label>Finishtime</label>
        <input type="datetime-local" name="finishtime" id="finishtime" step="1">
        <label><input type="checkbox" name="addLaps" id="addLaps" value="1"> Enter laps</label>
        <label>Laps Count</label>
        <input type="number" name="laps" id="laps" min="0" max="100" value="0" disabled>
    </fieldset>
    <button type="submit" class="btn">Submit</button>
</form>

<p><a href="{{ route('contestant-finishtimes.index') }}">List Contestant Finishtimes</a></p>

<script src="/js/utils.js"></script>
<script>
var idUpdateTime;

document.addEventListener('DOMContentLoaded', function() {
    idUpdateTime = setInterval(updateTime, 1000);
    updateTime();

    document.getElementById('addLaps').addEventListener('change', function() {
        document.getElementById('laps').disabled = !this.checked;
    });

    findRace();

    document.getElementById('activerace').addEventListener('change', function() {
        document.getElementById('raceForm').submit();
    });

    document.getElementById('barcode').focus();

    document.getElementById('finishtime').addEventListener('click', function() {
        clearInterval(idUpdateTime);
        document.getElementById('timerStoppedMsg').style.display = 'block';
    });

    document.addEventListener('keypress', function(e) {
        if (e.which === 13) {
            var barcode = removeLeadingZeros(document.getElementById('barcode').value);
            inSelect(barcode);
            document.getElementById('barcode').value = '';
            document.getElementById('barcode').focus();
        }
    });
});

function findRace() {
    var activeRace = getUrlParameter('activerace');
    if (activeRace) {
        document.getElementById('activerace').value = activeRace;
        document.getElementById('race_id').value = activeRace;
    } else {
        var firstOption = document.getElementById('activerace').options[0];
        if (firstOption) {
            document.getElementById('race_id').value = firstOption.value;
        }
    }
}

function inSelect(barcode) {
    var select = document.getElementById('contestant_id');
    for (var i = 0; i < select.options.length; i++) {
        if (select.options[i].value == barcode) {
            select.value = barcode;
            return true;
        }
    }
    return false;
}

function pad(num, size) {
    var s = num + '';
    while (s.length < size) s = '0' + s;
    return s;
}

function updateTime() {
    var d = new Date();
    var iso = d.getFullYear() + '-' + pad(d.getMonth()+1,2) + '-' + pad(d.getDate(),2)
        + 'T' + pad(d.getHours(),2) + ':' + pad(d.getMinutes(),2) + ':' + pad(d.getSeconds(),2);
    document.getElementById('finishtime').value = iso;
}
</script>
@endsection
