<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Contracts\View\View;

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
}
