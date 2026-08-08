<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Page routes
Route::get('/', [PageController::class, 'index']);
Route::get('/cek-pesanan', [PageController::class, 'cekPesanan']);
Route::get('/dashboard-pengguna', [PageController::class, 'dashboardPengguna']);

// Fitur Cek Pesanan
Route::get('/cek-pesanan', [PageController::class, 'cekPesanan'])->name('pesanan.cek');
Route::post('/cek-pesanan/proses', [PageController::class, 'prosesCekPesanan'])->name('pesanan.proses');

// Hasil Pencarian
Route::get('/daftar-transaksi', [PageController::class, 'daftarTransaksi'])->name('transaksi.daftar');
Route::get('/daftar-reservasi', [PageController::class, 'daftarReservasi'])->name('reservasi.daftar');

// Payment route
Route::get(
    '/payment/{transaksi}',
    PaymentController::class,
)->name('payment');

// Reservation routes
Route::resource('/reservation', ReservationController::class);
Route::get('/reservation/success/{id}', [ReservationController::class, 'success'])->name('reservation.success');

// Debug route
Route::get('/debug', function (Request $request) {
    return [
        'secure' => $request->secure(),
        'scheme' => $request->getScheme(),
        'host' => $request->getHost(),
        'url' => $request->fullUrl(),
    ];
});

require __DIR__ . '/auth.php';
