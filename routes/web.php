<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\BeautyController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\TourismController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ReserveController;
use Illuminate\Support\Facades\Route;

use App\Mail\ReservePaymentConfirmedMail;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/reserve', [ReserveController::class, 'create'])->name('reserve');
    Route::post('/reserve', [ReserveController::class, 'store']);
    // ---------------------------
    // RESERVATION PAYMENT
    // ---------------------------
    Route::post('/reserve/create-checkout-session', [ReserveController::class, 'createSession']);
    Route::get('/reserve/return', [ReserveController::class, 'return'])->name('reserve.return');











Route::get('/test-mail', function () {

    $reserve = App\Models\Reserve::where('id', 2)->first();

    // Enviar usando la cola (recomendado con Mailpit)
    Mail::to($reserve->email)->queue(new ReservePaymentConfirmedMail($reserve));

    // Renderizar para ver en pantalla
    return (new ReservePaymentConfirmedMail($reserve))->render();
});















});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/billing', [ProfileController::class, 'billing'])->name('profile.billing');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update_email', [ProfileController::class, 'updateEmail'])->name('profile.updateEmail');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:super_admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/json', [UserController::class, 'showJson'])->name('users.show.json');
        Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
    });

    // ---------------------------
    // EVENTS
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

    // ---------------------------
    // JOBS
    // ---------------------------
    Route::get('/jobs/show_all', [JobController::class, 'show_all'])->name('jobs.show_all');

    // Solo administrator y super_admin
    Route::middleware('role:administrator,super_admin')->group(function () {
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::delete('/jobs/{event}', [JobController::class, 'destroy'])->name('jobs.destroy');
    });

    // ---------------------------
    // RENTS
    // ---------------------------
    Route::get('/rents/show_all', [RentController::class, 'show_all'])->name('rents.show_all');
    // Solo administrator y super_admin
    Route::middleware('role:administrator,super_admin')->group(function () {
        Route::get('/rents', [RentController::class, 'index'])->name('rents.index');
        Route::post('/rents', [RentController::class, 'store'])->name('rents.store');
        Route::delete('/rents/{event}', [RentController::class, 'destroy'])->name('rents.destroy');
    });

    // ---------------------------
    // SERVICES
    // ---------------------------
    Route::get('/services/show_all', [ServiceController::class, 'show_all'])->name('services.show_all');
    // Solo administrator y super_admin
    Route::middleware('role:administrator,super_admin')->group(function () {
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::delete('/services/{event}', [ServiceController::class, 'destroy'])->name('services.destroy');
    });

    // ---------------------------
    // RESTAURANTS
    // ---------------------------
    Route::get('/restaurants/show_all', [RestaurantController::class, 'show_all'])->name('restaurants.show_all');
    // Solo administrator y super_admin
    Route::middleware('role:administrator,super_admin')->group(function () {
        Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
        Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
        Route::delete('/restaurants/{event}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
    });

    // ---------------------------
    // BEAUTY
    // ---------------------------
    Route::get('/beauty/show_all', [BeautyController::class, 'show_all'])->name('beauty.show_all');
    // Solo administrator y super_admin
    Route::middleware('role:administrator,super_admin')->group(function () {
        Route::get('/beauty', [BeautyController::class, 'index'])->name('beauty.index');
        Route::post('/beauty', [BeautyController::class, 'store'])->name('beauty.store');
        Route::delete('/beauty/{event}', [BeautyController::class, 'destroy'])->name('beauty.destroy');
    });

    // ---------------------------
    // INVESTMENTS
    // ---------------------------
    Route::get('/investment/show_all', [InvestmentController::class, 'show_all'])->name('investment.show_all');
    // Solo administrator y super_admin
    Route::middleware('role:administrator,super_admin')->group(function () {
        Route::get('/investment', [InvestmentController::class, 'index'])->name('investment.index');
        Route::post('/investment', [InvestmentController::class, 'store'])->name('investment.store');
        Route::delete('/investment/{event}', [InvestmentController::class, 'destroy'])->name('investment.destroy');
    });

    // ---------------------------
    // TOURISM
    // ---------------------------
    Route::get('/tourism/show_all', [TourismController::class, 'show_all'])->name('tourism.show_all');
    // Solo administrator y super_admin
    Route::middleware('role:administrator,super_admin')->group(function () {
        Route::get('/tourism', [TourismController::class, 'index'])->name('tourism.index');
        Route::post('/tourism', [TourismController::class, 'store'])->name('tourism.store');
        Route::delete('/tourism/{event}', [TourismController::class, 'destroy'])->name('tourism.destroy');
    });

    // ---------------------------
    // SUBSCRIPTION & BILLING
    // ---------------------------
    Route::get('/subscription/pricing', [SubscriptionController::class, 'pricing'])->name('subscription.pricing');
    Route::post('/subscription/create-checkout-session', [SubscriptionController::class, 'createSession']);
    Route::get('/subscription/return', [SubscriptionController::class, 'return'])->name('subscription.return');







});

require __DIR__.'/auth.php';
