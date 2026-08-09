<?php

namespace App\Console\Commands;

use App\Enums\StatusLaundry;
use App\Models\Transaksi;
use App\Services\Transaksi\Fuzzy\PriorityEvaluator;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:update-laundry-priority')]
#[Description('Update prioritas transaksi secara dinamis berdasarkan waktu tunggu (Indikator SLA)')]
class UpdateLaundryPriority extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(PriorityEvaluator $evaluator)
    {
        // 1. Ambil data transaksi yang belum selesai dikerjakan
        $transaksis = Transaksi::query()
            ->whereIn('status_laundry', [
                StatusLaundry::PENDING,
                StatusLaundry::DIPROSES
            ])
            ->get();

        $updatedCount = 0;

        foreach ($transaksis as $trx) {
            $waktuAwal = $trx->tanggal_masuk ? Carbon::parse($trx->tanggal_masuk) : $trx->created_at;
            $lamaMenunggu = (int) $waktuAwal->diffInHours(now());
            $tingkatKekotoran = (int) ($trx->tingkat_kekotoran ?? 0);
            // Evaluasi ulang prioritas dengan logika Fuzzy
            $newPriority = $evaluator->calculate($tingkatKekotoran, $lamaMenunggu);

            if ($trx->prioritas !== $newPriority) {
                $trx->update(['prioritas' => $newPriority]);
                $updatedCount++;
                $this->line("Prioritas Transaksi #{$trx->id} naik menjadi: {$newPriority->name}");
            }
        }
        $this->info("Proses Selesai! Berhasil mengupdate {$updatedCount} prioritas transaksi.");
        $this->comment("Catatan: Prioritas ini digunakan sebagai indikator visual (SLA). Pastikan pengerjaan mesin cuci tetap mengikuti urutan FIFO.");
    }
}
