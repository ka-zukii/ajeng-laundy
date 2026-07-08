<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gejala extends Model
{
    protected $table = 'gejala';
    protected $fillable = [
        'nama_gejala',
    ];

    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class);
    }
}
