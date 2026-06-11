<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Leito extends Model
{
    protected $fillable = ['numero'];

    public function paciente(): HasOne
    {
        return $this->hasOne(Paciente::class);
    }

    public function estaOcupado(): bool
    {
        return $this->paciente()->exists();
    }
}
