<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    protected $table = 'rules';
    protected $fillable = [
        'penyakit_noda_id',
        'gejala_id',
        'cf_pakar',
    ];
}
