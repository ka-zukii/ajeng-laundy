<?php

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
            $table->foreignId('users_id')->nullable()->constrained('users')->noActionOnDelete();
            $table->string('kode_transaksi')->unique();
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai');
            $table->enum('status_laundry', array_map(fn($statusLaundry) => $statusLaundry->value, StatusLaundry::cases()))->nullable()->default(StatusLaundry::PENDING);
            $table->decimal('total_biaya');
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
