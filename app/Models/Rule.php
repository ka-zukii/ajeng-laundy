<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model
{
    protected $table = 'rules';
    protected $fillable = [
        'penyakit_noda_id',
        'gejala_id',
        'cf_pakar',
    ];

    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class);
    }

    public function penyakitNoda(): BelongsTo
    {
        return $this->belongsTo(PenyakitNoda::class);
    }
}
