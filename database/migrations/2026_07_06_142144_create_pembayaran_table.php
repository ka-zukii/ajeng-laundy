<?php

use App\Enums\StatusPembayaran;
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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')
                ->constrained('transaksi')
                ->cascadeOnDelete();
            $table->decimal('jumlah_pembayaran', 12, 2);
            $table->string('metode_pembayaran')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->dateTime('tanggal_pembayaran')->nullable();
            $table->enum(
                'status_pembayaran',
                array_map(
                    fn($status) => $status->value,
                    StatusPembayaran::cases()
                )
            )->default(StatusPembayaran::MENGUNGGU->value);

            // Midtrans
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('bank')->nullable();
            $table->string('va_number')->nullable();
            $table->timestamp('expired_at')->nullable();

            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
