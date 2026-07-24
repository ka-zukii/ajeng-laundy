<?php

namespace App\Console\Commands;

use App\Enums\StatusLaundry;
use App\Models\Transaksi;
use App\Services\Transaksi\Fuzzy\PriorityEvaluator;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:update-laundry-priority')]
#[Description('Update prioritas transaksi secara dinamis berdasarkan waktu tunggu')]
class UpdateLaundryPriority extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(PriorityEvaluator $evaluator)
    {
        // 1. Ambil data transaksi (Query yang terpotong sudah diperbaiki)
        $transaksis = Transaksi::query()
            ->whereIn('status_laundry', [
                StatusLaundry::PENDING,
                StatusLaundry::DIPROSES
            ])
            ->get();

        $updatedCount = 0;

        foreach ($transaksis as $trx) {
            // Hitung lama menunggu secara REALTIME (dari waktu masuk s.d waktu sekarang)
            $lamaMenunggu = $trx->created_at->diffInHours(now());

            // Pastikan kolom tingkat_kekotoran sesuai dengan yang ada di tabel transaksis
            $tingkatKekotoran = $trx->tingkat_kekotoran ?? 0;

            // Evaluasi ulang prioritas dengan logika Fuzzy yang sudah ada
            $newPriority = $evaluator->calculate($tingkatKekotoran, $lamaMenunggu);

            // Jika prioritas dari mesin Fuzzy beda dengan yang ada di DB, Update!
            if ($trx->prioritas !== $newPriority) {
                $trx->update(['prioritas' => $newPriority]);
                $updatedCount++;
            }
        }

        $this->info("Berhasil mengupdate {$updatedCount} prioritas transaksi!");
    }
}
