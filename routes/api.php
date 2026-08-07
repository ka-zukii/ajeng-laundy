<?php

use App\Http\Controllers\MidtransCallbackController;
use Illuminate\Support\Facades\Route;

// Midtrans Callback
Route::post('/midtrans/callback', MidtransCallbackController::class);
