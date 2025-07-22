<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

Route::get('/states/{country_id}', [LocationController::class, 'getStates']);
Route::get('/cities/{state_id}', [LocationController::class, 'getCities']);
