<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Events
    Route::get('/events/show_all', [EventController::class, 'show_all'])->name('events.show_all');
    Route::resource('events', EventController::class);

    // Jobs
    Route::get('/jobs/show_all', [JobController::class, 'show_all'])->name('jobs.show_all');
    Route::resource('jobs', JobController::class);

    // Rents
    Route::get('/rents/show_all', [RentController::class, 'show_all'])->name('rents.show_all');
    Route::resource('rents', RentController::class);

});

require __DIR__.'/auth.php';
