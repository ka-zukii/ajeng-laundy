<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyakitNoda extends Model
{
    protected $table = 'penyakit_noda';
    protected $fillable = [
        'nama_penyakit',
        'solusi',
        'biaya_tambahan',
    ];
}
