<?php

use App\Http\Controllers\ContestantController;
use App\Http\Controllers\ContestantFinishtimeController;
use App\Http\Controllers\ContestantLapController;
use App\Http\Controllers\RaceContestantController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\RaceFinishtimeController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('races.index'));

Route::resource('races', RaceController::class);
Route::resource('contestants', ContestantController::class);

// Contestant Laps: index, create/store, delete
Route::get('/contestant-laps', [ContestantLapController::class, 'index'])->name('contestant-laps.index');
Route::get('/contestant-laps/create', [ContestantLapController::class, 'create'])->name('contestant-laps.create');
Route::post('/contestant-laps', [ContestantLapController::class, 'store'])->name('contestant-laps.store');
Route::delete('/contestant-laps/{contestantLap}', [ContestantLapController::class, 'destroy'])->name('contestant-laps.destroy');

// Contestant Finishtimes: index, create/store, delete
Route::get('/contestant-finishtimes', [ContestantFinishtimeController::class, 'index'])->name('contestant-finishtimes.index');
Route::get('/contestant-finishtimes/create', [ContestantFinishtimeController::class, 'create'])->name('contestant-finishtimes.create');
Route::post('/contestant-finishtimes', [ContestantFinishtimeController::class, 'store'])->name('contestant-finishtimes.store');
Route::delete('/contestant-finishtimes/{contestantFinishtime}', [ContestantFinishtimeController::class, 'destroy'])->name('contestant-finishtimes.destroy');

// Race Contestants
Route::get('/race-contestants', [RaceContestantController::class, 'index'])->name('race-contestants.index');
Route::get('/race-contestants/manage', [RaceContestantController::class, 'manage'])->name('race-contestants.manage');
Route::post('/race-contestants/update', [RaceContestantController::class, 'update'])->name('race-contestants.update');

// Race Finishtimes
Route::resource('race-finishtimes', RaceFinishtimeController::class)->except(['show']);

// Statistics
Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
Route::get('/statistics/{raceId}', [StatisticsController::class, 'show'])->name('statistics.show');
