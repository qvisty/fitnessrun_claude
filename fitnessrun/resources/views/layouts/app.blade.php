<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitnessRun: @yield('title')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        nav { background: #333; color: #fff; padding: 10px 20px; display: flex; align-items: center; justify-content: space-between; }
        nav h1 { margin: 0; font-size: 1.2em; }
        nav h1 a { color: #fff; text-decoration: none; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; gap: 15px; flex-wrap: wrap; }
        nav ul li a { color: #ccc; text-decoration: none; }
        nav ul li a:hover { color: #fff; }
        nav ul li.sep { color: #555; }
        .container { max-width: 1100px; margin: 20px auto; padding: 0 20px; }
        .alert { padding: 10px 15px; margin-bottom: 15px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; }
        th { background: #f5f5f5; }
        tr:nth-child(even) { background: #fafafa; }
        .btn { display: inline-block; padding: 6px 14px; background: #337ab7; color: #fff; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 0.9em; }
        .btn:hover { background: #286090; }
        .btn-danger { background: #d9534f; }
        .btn-danger:hover { background: #c9302c; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #545b62; }
        form.inline { display: inline; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type=text], input[type=datetime-local], input[type=number], select, textarea { width: 100%; padding: 6px 10px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        input[type=checkbox] { width: auto; }
        fieldset { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 4px; }
        legend { font-weight: bold; padding: 0 8px; }
        .actions { margin-bottom: 15px; }
        .pagination { margin-top: 15px; }
    </style>
    @stack('head')
</head>
<body>
    <nav>
        <h1><a href="{{ route('races.index') }}">@yield('title', 'FitnessRun')</a></h1>
        <ul>
            <li><a href="{{ route('races.index') }}">Races</a></li>
            <li><a href="{{ route('contestants.index') }}">Contestants</a></li>
            <li class="sep">|</li>
            <li><a href="{{ route('race-contestants.manage') }}">Modify Race Contestants</a></li>
            <li><a href="{{ route('contestant-laps.create') }}">Register Contestant Laps</a></li>
            <li><a href="{{ route('contestant-finishtimes.create') }}">Register Contestant Finishtime</a></li>
            <li class="sep">|</li>
            <li><a href="{{ route('statistics.index') }}">Statistics</a></li>
        </ul>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('success_delete'))
            <div class="alert alert-success">{{ session('success_delete') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0;padding-left:18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
