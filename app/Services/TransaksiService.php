<?php

namespace App\Services;

use App\Enums\JenisPerhitungan;
use App\Enums\StatusLaundry;
use App\Models\Layanan;
use App\Models\NodaPakaian;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiService
{
    public function generateTransactionCode(): string
    {
        do {
            $code = sprintf(
                'AJL-%s-%s',
                now()->format('Ymd'),
                Str::upper(Str::random(6))
            );
        } while (Transaksi::where('kode_transaksi', $code)->exists());

        return $code;
    }

    public function calculateTotal(
        Layanan $layanan,
        ?NodaPakaian $nodaPakaian,
        array $data,
    ): float {

        $subtotal = match ($layanan->jenis_perhitungan) {

            JenisPerhitungan::KILOAN =>
            $layanan->biaya_layanan * ($data['berat'] ?? 0),

            JenisPerhitungan::SATUAN =>
            $layanan->biaya_layanan * ($data['jumlah'] ?? 0),
        };

        return $subtotal + ($nodaPakaian?->biaya_tambahan ?? 0);
    }

    private function prepareTransaction(
        array $data,
        Carbon $tanggalMasuk,
    ): array {

        $layanan = Layanan::findOrFail($data['layanan_id']);

        $nodaPakaian = ! empty($data['noda_pakaian_id'])
            ? NodaPakaian::find($data['noda_pakaian_id'])
            : null;

        return [

            'layanan' => $layanan,

            'tanggal_selesai' => $tanggalMasuk,
            
            'total' => $this->calculateTotal(
                $layanan,
                $nodaPakaian,
                $data,
            ),

        ];
    }

    public function create(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {

            $tanggalMasuk = now();

            $prepared = $this->prepareTransaction(
                $data,
                $tanggalMasuk,
            );

            $transaksi = Transaksi::create([
                'pelanggan_id'    => $data['pelanggan_id'],
                'kode_transaksi'  => $this->generateTransactionCode(),
                'tanggal_masuk'   => $tanggalMasuk,
                'tanggal_selesai' => $prepared['tanggal_selesai'],
                'status_laundry'  => StatusLaundry::PENDING,
                'total_biaya'     => $prepared['total'],
            ]);

            $transaksi->transaksiDetail()->create([
                'layanan_id'       => $data['layanan_id'],
                'noda_pakaian_id' => $data['noda_pakaian_id'],
                'tingkat_kekotoran' => $data['tingkat_kekotoran'],
                'berat'            => $data['berat'] ?? null,
                'jumlah'           => $data['jumlah'] ?? null,
            ]);

            return $transaksi;
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

            $transaksi->update([
                'pelanggan_id'    => $data['pelanggan_id'],
                'tanggal_selesai' => $prepared['tanggal_selesai'],
                'total_biaya'     => $prepared['total'],
            ]);

            $transaksi->transaksiDetail()->update([
                'layanan_id'       => $data['layanan_id'],
                'noda_pakaian_id' => $data['noda_pakaian_id'],
                'tingkat_kekotoran' => $data['tingkat_kekotoran'],
                'berat'            => $data['berat'] ?? null,
                'jumlah'           => $data['jumlah'] ?? null,
            ]);

            return $transaksi->refresh();
        });
    }
}
