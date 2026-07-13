<?php

namespace App\Services;

use App\Models\Transaksi;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class TransaksiService
{
    public function generateTransactionCode(): string
    {
        return sprintf(
            'AJL-%s-%s',
            now()->format('Ymd'),
            Str::upper(Str::random(6))
        );
    }

    public function create(array $data): Transaksi
    {
        $maxAttempts = 5;
        $attempt = 0;

        do {
            try {
                return Transaksi::create([
                    'kode_transaksi' => $this->generateTransactionCode(),
                    ...$data
                ]);
            } catch (QueryException $e) {
                if ($e->getCode() === '23000') {
                    $attempt++;
                    continue;
                }
                throw $e;
            }
        } while ($attempt < $maxAttempts);

        throw new \Exception("Gagal membuat kode transaksi unik setelah beberapa kali percobaan.");
    }
}
