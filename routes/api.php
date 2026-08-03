<?php

use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Reservation
Route::resource('/reservation', ReservationController::class);

// Midtrans Callback
Route::post('/midtrans/callback', MidtransCallbackController::class);
