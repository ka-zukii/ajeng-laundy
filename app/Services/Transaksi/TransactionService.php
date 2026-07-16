<?php

namespace App\Services\Transaksi;

use App\Enums\StatusLaundry;
use App\Enums\StatusPembayaran;
use App\Models\Layanan;
use App\Models\NodaPakaian;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function __construct(
        protected TransactionCalculator $calculator,
        protected FuzzyLaundryService $fuzzyService,
    ) {}

    public function create(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {

            $tanggalMasuk = now();

            $prepared = $this->prepareTransaction(
                $data,
                $tanggalMasuk,
            );

            $transaksi = $this->createTransaction(
                $data,
                $prepared,
                $tanggalMasuk,
            );

            $this->createTransactionDetail(
                $transaksi,
                $data,
            );

            $this->createPayment(
                $transaksi,
                $prepared['total'],
            );

            return $transaksi->refresh();
        });
    }

    public function update(
        Transaksi $transaksi,
        array $data,
    ): Transaksi {
        return DB::transaction(function () use ($transaksi, $data) {

            $prepared = $this->prepareTransaction(
                $data,
                Carbon::parse($transaksi->tanggal_masuk),
            );

            $this->updateTransaction(
                $transaksi,
                $data,
                $prepared,
            );

            $this->updateTransactionDetail(
                $transaksi,
                $data,
            );

            $this->updatePayment(
                $transaksi,
                $prepared['total'],
            );

            return $transaksi->refresh();
        });
    }

    private function prepareTransaction(
        array $data,
        Carbon $tanggalMasuk,
    ): array {
        $layanan = Layanan::findOrFail($data['layanan_id']);

        $noda = ! empty($data['noda_pakaian_id'])
            ? NodaPakaian::find($data['noda_pakaian_id'])
            : null;

        $total = $this->calculator->total(
            $layanan,
            $noda,
            $data,
        );

        $fuzzy = $this->fuzzyService->calculate(
            $layanan,
            $noda,
            $data,
            $tanggalMasuk,
        );

        return [
            'layanan'            => $layanan,
            'total'              => $total,
            'estimasi_selesai'   => $fuzzy['estimasi_selesai'],
            'prioritas'          => $fuzzy['prioritas'],
        ];
    }

    private function createTransaction(
        array $data,
        array $prepared,
        Carbon $tanggalMasuk,
    ): Transaksi {
        return Transaksi::create([
            'pelanggan_id'      => $data['pelanggan_id'],
            // kode_transaksi otomatis dari model booted()
            'tanggal_masuk'     => $tanggalMasuk,
            'estimasi_selesai'  => $prepared['estimasi_selesai'],
            'prioritas'         => $prepared['prioritas'],
            'status_laundry'    => StatusLaundry::PENDING,
            'total_biaya'       => $prepared['total'],
        ]);
    }

    private function updateTransaction(
        Transaksi $transaksi,
        array $data,
        array $prepared,
    ): void {
        $transaksi->update([
            'pelanggan_id'      => $data['pelanggan_id'],
            'estimasi_selesai'  => $prepared['estimasi_selesai'],
            'prioritas'         => $prepared['prioritas'],
            'total_biaya'       => $prepared['total'],
        ]);
    }

    private function createTransactionDetail(
        Transaksi $transaksi,
        array $data,
    ): void {
        $transaksi->transaksiDetail()->create([
            'layanan_id'         => $data['layanan_id'],
            'noda_pakaian_id'    => $data['noda_pakaian_id'] ?? null,
            'tingkat_kekotoran'  => $data['tingkat_kekotoran'],
            'berat'              => $data['berat'] ?? null,
            'jumlah'             => $data['jumlah'] ?? null,
        ]);
    }

    private function updateTransactionDetail(
        Transaksi $transaksi,
        array $data,
    ): void {
        $transaksi->transaksiDetail()->update([
            'layanan_id'         => $data['layanan_id'],
            'noda_pakaian_id'    => $data['noda_pakaian_id'] ?? null,
            'tingkat_kekotoran'  => $data['tingkat_kekotoran'],
            'berat'              => $data['berat'] ?? null,
            'jumlah'             => $data['jumlah'] ?? null,
        ]);
    }

    private function createPayment(
        Transaksi $transaksi,
        float $total,
    ): void {
        $transaksi->pembayaran()->create([
            'metode_pembayaran'   => null,
            'tanggal_pembayaran'  => null,
            'jumlah_pembayaran'   => $total,
            'status_pembayaran'   => StatusPembayaran::MENGUNGGU,
        ]);
    }

    private function updatePayment(
        Transaksi $transaksi,
        float $total,
    ): void {
        $transaksi->pembayaran()->updateOrCreate(
            [],
            [
                'jumlah_pembayaran' => $total,
            ]
        );
    }
}
