<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Services\Pembayaran\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __invoke(
        Transaksi $transaksi,
    ): View {

        $transaksi->load([
            'pelanggan',
            'pembayaran',
        ]);

        abort_if(
            ! $transaksi->pembayaran,
            404,
            'Pembayaran tidak ditemukan.'
        );

        return view(
            'payment',
            [
                'transaksi' => $transaksi,
                'pembayaran' => $transaksi->pembayaran,
            ],
        );
    }

    public function proses(Request $request, $id, PaymentService $paymentService)
    {
        $request->validate([
            'metode' => 'required|string'
        ]);

        $transaksi = Transaksi::with('pembayaran')->findOrFail($id);
        $pembayaran = $transaksi->pembayaran;

        try {
            $response = $paymentService->chargeCoreApi($pembayaran, $request->metode);

            return redirect()->route('pembayaran.instruksi', $pembayaran->id)
                ->with('success', 'Metode pembayaran berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghubungi Midtrans: ' . $e->getMessage());
        }
    }

    public function instruksi($pembayaranId)
    {
        $pembayaran = \App\Models\Pembayaran::with('transaksi.pelanggan')->findOrFail($pembayaranId);

        return view('pembayaran-instruksi', compact('pembayaran'));
    }

    public function checkStatus($pembayaranId)
    {
        $pembayaran = \App\Models\Pembayaran::with('transaksi')->findOrFail($pembayaranId);

        try {
            // 1. Tanya status terbaru ke Midtrans
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);

            $statusResponse = \Midtrans\Transaction::status($pembayaran->midtrans_order_id);

            // 2. Mengatasi Error "Expected object, found mixed[]"
            $transactionStatus = is_array($statusResponse)
                ? ($statusResponse['transaction_status'] ?? null)
                : ($statusResponse->transaction_status ?? null);

            // 3. Update database
            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                $pembayaran->update(['status_pembayaran' => \App\Enums\StatusPembayaran::SUKSES]);
            } elseif ($transactionStatus === 'pending') {
                $pembayaran->update(['status_pembayaran' => \App\Enums\StatusPembayaran::MENGUNGGU]);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $pembayaran->update(['status_pembayaran' => \App\Enums\StatusPembayaran::DIBATALKAN]);
            }
        } catch (\Exception $e) {
            // Abaikan jika order belum terdaftar di Midtrans
        }

        // 4. Logika Redirect menggunakan Enum yang benar!
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user && in_array($user->role, [\App\Enums\UserRole::OWNER, \App\Enums\UserRole::KARYAWAN])) {
            return redirect(\App\Filament\Resources\Pembayarans\PembayaranResource::getUrl('view', ['record' => $pembayaran->id]))
                ->with('success', 'Status pembayaran berhasil diperbarui.');
        }

        return redirect()->route('detail-transaksi', $pembayaran->transaksi->id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
