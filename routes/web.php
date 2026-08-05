<?php

use App\Http\Controllers\PaymentController;
use App\Models\Layanan;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    $layanans = Layanan::all();
    return view('welcome', compact('layanans'));
});

Route::get('/cek-pesanan', function () {
    return view('cek-pesanan');
});

Route::get(
    '/payment/{transaksi}',
    PaymentController::class,
)->name('payment');

Route::get('/debug', function (Request $request) {
    return [
        'secure' => $request->secure(),
        'scheme' => $request->getScheme(),
        'host' => $request->getHost(),
        'url' => $request->fullUrl(),
    ];
});
