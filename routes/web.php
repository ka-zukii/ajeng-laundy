<?php

use App\Http\Controllers\DashboardPelangganController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TransaksiController;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardPelangganController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/transaksi/{id}', [TransaksiController::class, 'show'])
        ->name('detail-transaksi');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Download invoice route
Route::get('/invoice/{kode_transaksi}/download', function ($kode_transaksi) {
    $transaksi = Transaksi::with(['pelanggan', 'transaksiDetail.layanan', 'pembayaran'])
                    ->where('kode_transaksi', $kode_transaksi)
                    ->firstOrFail();
    $pdf = Pdf::loadView('pdf.invoice-pelanggan', ['transaksi' => $transaksi]);
    return $pdf->download("Invoice-{$transaksi->kode_transaksi}.pdf");
})->name('pelanggan.invoice.download');

// Page routes
Route::get('/', [PageController::class, 'index']);
Route::get('/cek-pesanan', [PageController::class, 'cekPesanan']);
Route::get('/dashboard-pengguna', [PageController::class, 'dashboardPengguna']);

// Fitur Cek Pesanan
Route::get('/cek-pesanan', [PageController::class, 'cekPesanan'])->name('pesanan.cek');
Route::post('/cek-pesanan/proses', [PageController::class, 'prosesCekPesanan'])->name('pesanan.proses');
Route::get('/detail-transaksi/{kodeTransaksi}', [PageController::class, 'detailTransaksi'])->name('transaksi.detail');

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
