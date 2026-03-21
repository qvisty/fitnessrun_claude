@extends('layouts.app')
@section('title', 'Register Contestant Lap')
@section('content')
<h2>Register Contestant Lap</h2>

@if(session('undo_lap_id'))
<div class="alert alert-success">
    {{ session('success') }}
    <form class="inline" method="POST" action="{{ route('contestant-laps.destroy', session('undo_lap_id')) }}?from=create" style="display:inline">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-secondary" style="margin-left:10px;">Undo</button>
    </form>
</div>
@elseif(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Race selector (GET form) --}}
<form id="raceForm" method="GET" action="{{ route('contestant-laps.create') }}">
    <label>Race</label>
    <select name="activerace" id="activerace">
        @foreach($races as $id => $name)
            <option value="{{ $id }}" {{ $activeRace == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
    <label>Auto Submit <input type="checkbox" name="autosubmit" id="autosubmit" value="1" {{ request('autosubmit') ? 'checked' : '' }}></label>
</form>

<br>
<label>Barcode</label>
<input type="text" id="barcode" placeholder="Scan barcode...">
<div id="nocontestantfound" style="display:none;color:red;">No contestant found with barcode</div>

<form id="mainForm" method="POST" action="{{ route('contestant-laps.store', [], false) }}?activerace={{ $activeRace }}&autosubmit={{ request('autosubmit') }}">
    @csrf
    <fieldset>
        <legend>Add Contestant Lap</legend>
        <label>Contestant</label>
        <select name="contestant_id" id="contestant_id">
            @foreach($contestants as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        <input type="hidden" name="race_id" id="race_id" value="{{ $activeRace }}">
    </fieldset>
    <button type="submit" class="btn">Submit</button>
</form>

<p><a href="{{ route('contestant-laps.index') }}">List Contestant Laps</a></p>

<script src="/js/utils.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    findRace();
    findAutosubmit();

    document.getElementById('activerace').addEventListener('change', function() {
        document.getElementById('raceForm').submit();
    });

    document.getElementById('autosubmit').addEventListener('change', function() {
        document.getElementById('raceForm').submit();
    });

    document.getElementById('barcode').focus();

    document.addEventListener('keypress', function(e) {
        if (e.which === 13) {
            var barcode = removeLeadingZeros(document.getElementById('barcode').value);
            if (inSelect(barcode)) {
                if (getUrlParameter('autosubmit') == 1) {
                    document.getElementById('mainForm').submit();
                }
                document.getElementById('nocontestantfound').style.display = 'none';
            } else {
                document.getElementById('nocontestantfound').style.display = 'block';
                document.getElementById('nocontestantfound').textContent = 'No contestant found with barcode: ' + document.getElementById('barcode').value;
            }
            document.getElementById('barcode').value = '';
            document.getElementById('barcode').focus();
        }
    });
});

function findAutosubmit() {
    var autosubmit = getUrlParameter('autosubmit');
    document.getElementById('autosubmit').checked = !!autosubmit;
}

function findRace() {
    var activeRace = getUrlParameter('activerace');
    if (activeRace) {
        document.getElementById('activerace').value = activeRace;
        document.getElementById('race_id').value = activeRace;
    } else {
        var firstOption = document.getElementById('activerace').options[0];
        if (firstOption) {
            document.getElementById('race_id').value = firstOption.value;
            document.getElementById('raceForm').submit();
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
</script>
@endsection
