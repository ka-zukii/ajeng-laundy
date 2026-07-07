<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'nama' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jl. Kemerdekaan No. 123, Kota Surakarta, Jawa Tengah',
            'role' => 'admin',
        ]);

        // Karyawan
        User::factory()->create([
            'nama' => 'Test Karyawan',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('karyawan123'),
            'nomor_telepon' => '081234567891',
            'alamat' => 'Jl. Imam Bonjol No. 456, Kota Jakarta, DKI Jakarta',
            'role' => 'karyawan',
        ]);

        // Pelanggan
        User::factory(10)->create([
            'role' => 'pelanggan',
        ]);
    }
}
