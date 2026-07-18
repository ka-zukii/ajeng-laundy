<?php

namespace Database\Seeders;

use App\Models\NodaPakaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        NodaPakaian::create([
            "nama_noda" => "normal",
            "solusi" => "Cuci dengan metode biasa",
            "biaya_tambahan" => 0,
        ]);

        $this->call([
            UserSeeder::class,
            LayananSeeder::class,
        ]);
    }
}
