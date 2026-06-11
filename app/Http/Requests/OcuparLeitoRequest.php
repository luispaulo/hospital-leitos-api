<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OcuparLeitoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'cpf'  => ['required', 'string', 'max:14'],
        ];
    }
}
