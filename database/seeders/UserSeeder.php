<?php

namespace Database\Seeders;

use App\Enums\UserRole;
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
        // Owner
        User::factory()->create([
            'username' => 'owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('owner123'),
            'role' => UserRole::OWNER->value,
        ]);

        // Karyawan
        User::factory()->create([
            'username' => 'karyawan',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('karyawan123'),
            'role' => UserRole::KARYAWAN->value,
        ]);

        // Pelanggan
        User::factory(10)->create([
            'role' => UserRole::PELANGGAN->value,
        ]);
    }
}
