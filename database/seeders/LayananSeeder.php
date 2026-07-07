<?php

namespace Database\Seeders;

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
                'tipe_layanan' => TipeLayanan::EXPRESS,
                'biaya_layanan' => 15000,
            ],
            [
                'nama_layanan' => 'Daily Kiloan',
                'tipe_layanan' => TipeLayanan::ONEDAY,
                'biaya_layanan' => 12000,
            ],
            [
                'nama_layanan' => 'Daily Kiloan',
                'tipe_layanan' => TipeLayanan::QUICK,
                'biaya_layanan' => 25000,
            ],
            [
                'nama_layanan' => 'Daily Kiloan',
                'tipe_layanan' => TipeLayanan::REGULAR,
                'biaya_layanan' => 8000,
            ],

            // Daily Satuan
            [
                'nama_layanan' => 'Daily Satuan',
                'tipe_layanan' => TipeLayanan::EXPRESS,
                'biaya_layanan' => 10000,
            ],
            [
                'nama_layanan' => 'Daily Satuan',
                'tipe_layanan' => TipeLayanan::ONEDAY,
                'biaya_layanan' => 8000,
            ],
            [
                'nama_layanan' => 'Daily Satuan',
                'tipe_layanan' => TipeLayanan::QUICK,
                'biaya_layanan' => 15000,
            ],
            [
                'nama_layanan' => 'Daily Satuan',
                'tipe_layanan' => TipeLayanan::REGULAR,
                'biaya_layanan' => 5000,
            ],

            // Setrika Kiloan
            [
                'nama_layanan' => 'Setrika Kiloan',
                'tipe_layanan' => TipeLayanan::EXPRESS,
                'biaya_layanan' => 12000,
            ],
            [
                'nama_layanan' => 'Setrika Kiloan',
                'tipe_layanan' => TipeLayanan::ONEDAY,
                'biaya_layanan' => 10000,
            ],
            [
                'nama_layanan' => 'Setrika Kiloan',
                'tipe_layanan' => TipeLayanan::QUICK,
                'biaya_layanan' => 15000,
            ],
            [
                'nama_layanan' => 'Setrika Kiloan',
                'tipe_layanan' => TipeLayanan::REGULAR,
                'biaya_layanan' => 5000,
            ],
        ];

        foreach ($layanan as $item) {
            Layanan::create($item);
        }
    }
}
