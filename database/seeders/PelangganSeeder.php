<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            'nama'          => 'Budi Santoso',
            'nomor_telepon' => '081234567890',
            'alamat'        => 'Jl. Merdeka No. 10, Jakarta Selatan',
            'user_id'       => null,
        ]);

        Pelanggan::create([
            'nama'          => 'Siti Aminah',
            'nomor_telepon' => '089876543210',
            'alamat'        => 'Perumahan Indah Blok C2, Bandung',
            'user_id'       => null,
        ]);
    }
}