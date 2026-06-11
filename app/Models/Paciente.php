<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paciente extends Model
{
    protected $fillable = ['nome', 'cpf', 'leito_id'];

    public function leito(): BelongsTo
    {
        return $this->belongsTo(Leito::class);
    }

    public function estaInternado(): bool
    {
        return !is_null($this->leito_id);
    }
}
