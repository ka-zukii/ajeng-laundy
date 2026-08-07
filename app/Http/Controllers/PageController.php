<?php

namespace App\Http\Controllers;

use App\Models\Layanan;

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

    public function daftarTransaksi(){
        return view('daftar-transaksi');
    }

    public function detailTransaksi(){
        return view('detail-transaksi');
    }

    public function dashboardPengguna(){
        return view('dashboard-pengguna');
    }
}
