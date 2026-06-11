<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferirPacienteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cpf'      => ['required', 'string', 'max:14'],
            'leito_id' => ['required', 'integer', 'exists:leitos,id'],
        ];
    }
}
