<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Page routes
Route::get('/', [PageController::class, 'index']);
Route::get('/cek-pesanan', [PageController::class, 'cekPesanan']);
Route::get('/daftar-transaksi', [PageController::class, 'daftarTransaksi']);
Route::get('/detail-transaksi', [PageController::class, 'detailTransaksi']);
Route::get('/dashboard-pengguna', [PageController::class, 'dashboardPengguna']);

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

// Reservation
Route::resource('/reservation', ReservationController::class);
Route::get('/reservation/success/{id}', [ReservationController::class, 'success'])->name('reservation.success');
