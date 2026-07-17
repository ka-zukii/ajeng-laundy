<?php

use App\Enums\PrioritasLaundry;
use App\Enums\StatusLaundry;
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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->cascadeOnDelete();
            $table->string('kode_transaksi')->unique();
            $table->date('tanggal_masuk')->nullable()->default(now());
            $table->dateTime('estimasi_selesai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status_laundry', array_map(fn($statusLaundry) => $statusLaundry->value, StatusLaundry::cases()))->nullable()->default(StatusLaundry::PENDING);
            $table->enum('prioritas', array_map(fn($prioritas) => $prioritas->value, PrioritasLaundry::cases()))->nullable()->default(PrioritasLaundry::LOW);
            $table->decimal('total_biaya')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
