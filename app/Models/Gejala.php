<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_gejala'])]
class Gejala extends Model
{
    protected $table = 'gejala';

    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class);
    }
}
