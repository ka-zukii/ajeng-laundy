<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Reservation;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('welcome', compact('layanans'));
    }

    public function cekPesanan()
    {
        return view('cek-pesanan');
    }

    public function prosesCekPesanan(Request $request)
    {
       $validate =  $request->validate([
            'tipe_pencarian' => 'required|in:reservasi,transaksi',
            'keyword' => 'required',
        ]);

        $tipe = $validate['tipe_pencarian'];
        $keyword = $validate['keyword'];

        if($tipe === 'transaksi'){
           $request->validate([
                'keyword' => ['required', 'string', 'starts_with:AJL-']
            ], [
                'keyword.starts_with' => 'Format salah! Kode transaksi harus diawali dengan AJL-',
            ]);

            return redirect()->route('transaksi.daftar', ['keyword' => $keyword]);
        }else {
            $request->validate([
                'keyword' => ['required', 'numeric']
            ], [
                'keyword.numeric' => 'Format salah! Harap masukkan nomor WhatsApp yang valid.',
            ]);

            return redirect()->route('reservasi.daftar', ['keyword' => $keyword]);
        }
    }

    public function daftarTransaksi(Request $request)
    {
        $keyword = $request->keyword;
        $transaksis = Transaksi::where('kode_transaksi', $keyword)->paginate(10);
        $transaksis->appends(['keyword' => $keyword]);
        return view('daftar-transaksi', compact('transaksis'));
    }

    public function daftarReservasi(Request $request)
    {
        $keyword = $request->keyword;

        $reservasis = Reservation::whereHas('pelanggan', function ($query) use ($keyword) {
            $query->where('nomor_telepon', $keyword);
        })->paginate(10);

        $reservasis->appends(['keyword' => $keyword]);

        return view('daftar-reservasi', compact('reservasis'));
    }

    public function detailTransaksi(string $kodeTransaksi){
         $transaksi = Transaksi::where('kode_transaksi', $kodeTransaksi)
            ->with(['pelanggan', 'transaksiDetail.layanan', 'pembayaran'])
            ->first();
        return view('detail-transaksi', compact('transaksi'));
    }

    public function dashboardPengguna(){
        return view('dashboard-pengguna');
    }
}
