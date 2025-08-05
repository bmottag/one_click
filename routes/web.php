<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RestaurantController;
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
    Route::post('/events/reserve', [EventController::class, 'reserve'])->name('events.reserve');
    Route::get('/events/{id}/json', [EventController::class, 'showJson'])->name('events.show.json');
    Route::resource('events', EventController::class);

    // Jobs
    Route::get('/jobs/show_all', [JobController::class, 'show_all'])->name('jobs.show_all');
    Route::resource('jobs', JobController::class);

    // Rents
    Route::get('/rents/show_all', [RentController::class, 'show_all'])->name('rents.show_all');
    Route::resource('rents', RentController::class);

    // Services
    Route::get('/services/show_all', [ServiceController::class, 'show_all'])->name('services.show_all');
    Route::resource('services', ServiceController::class);

    // Restaurants
    Route::get('/restaurants/show_all', [RestaurantController::class, 'show_all'])->name('restaurants.show_all');
    Route::resource('restaurants', RestaurantController::class);

});

require __DIR__.'/auth.php';
