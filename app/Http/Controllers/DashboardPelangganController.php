<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class DashboardPelangganController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pelanggan = $user->pelanggan;

        $transactions = [];
        if ($pelanggan) {
            $transactions = Transaksi::where('pelanggan_id', $pelanggan->id)->orderBy('tanggal_masuk', 'desc')->paginate(5);
        }

        // 4. Kirim ke View
        return view('dashboard', [
            'user'         => $user,
            'pelanggan'    => $pelanggan,
            'transactions' => $transactions,
        ]);
    }
}
