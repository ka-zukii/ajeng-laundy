<?php

use App\Enums\JenisPerhitungan;
use App\Enums\TipeLayanan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->enum('tipe_layanan', array_map(fn($tipeLayanan) => $tipeLayanan->value, TipeLayanan::cases()));
            $table->enum('jenis_perhitungan', array_map(fn($jenis) => $jenis->value, JenisPerhitungan::cases()));
            $table->decimal('biaya_layanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
