<?php
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
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
