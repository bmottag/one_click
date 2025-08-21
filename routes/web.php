<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

    Route::middleware('role:super_admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/json', [UserController::class, 'showJson'])->name('users.show.json');
        Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
    });


    // ---------------------------
    // Events
    // ---------------------------

    // Todos los usuarios autenticados (registered, admin, super) → pueden ver y reservar
    Route::get('/events/show_all', [EventController::class, 'show_all'])->name('events.show_all');
    Route::post('/events/reserve', [EventController::class, 'reserve'])->name('events.reserve');
    Route::get('/events/{id}/json', [EventController::class, 'showJson'])->name('events.show.json');

    // Solo administrator y super_admin
    Route::middleware('role:administrator,super_admin')->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });

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
