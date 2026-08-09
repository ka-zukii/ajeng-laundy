<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function show($id)
    {
        $transaksi = Transaksi::with(['transaksiDetail.layanan', 'pelanggan', 'pembayaran'])->findOrFail($id);

        return view('detail-transaksi', compact('transaksi'));
    }
}
