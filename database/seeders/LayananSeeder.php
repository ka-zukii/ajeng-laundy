<?php

namespace Database\Seeders;

use App\Enums\JenisPerhitungan;
use App\Enums\TipeLayanan;
use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanan = [

            // Daily Kiloan
            [
                'nama_layanan' => 'Daily Kiloan',
                'jenis_perhitungan' => JenisPerhitungan::KILOAN,
                'biaya_layanan' => 8000,
            ],

            // Daily Satuan
            [
                'nama_layanan' => 'Daily Satuan',
                'jenis_perhitungan' => JenisPerhitungan::SATUAN,
                'biaya_layanan' => 5000,
            ],

            // Setrika Kiloan
            [
                'nama_layanan' => 'Setrika Kiloan',
                'jenis_perhitungan' => JenisPerhitungan::KILOAN,
                'biaya_layanan' => 12000,
            ]
        ];

        foreach ($layanan as $item) {
            Layanan::create($item);
        }
    }
}
