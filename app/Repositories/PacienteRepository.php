<?php

namespace App\Repositories;

use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;

class PacienteRepository implements PacienteRepositoryInterface
{
    public function __construct(private readonly Paciente $model) {}

    public function findByCpf(string $cpf): ?Paciente
    {
        return $this->model->where('cpf', $cpf)->first();
    }

    public function findByCpfWithLeito(string $cpf): ?Paciente
    {
        return $this->model->with('leito')->where('cpf', $cpf)->first();
    }

    public function isInternado(string $cpf): bool
    {
        return $this->model
            ->where('cpf', $cpf)
            ->whereNotNull('leito_id')
            ->exists();
    }

    public function upsert(string $cpf, array $data): Paciente
    {
        return $this->model->updateOrCreate(['cpf' => $cpf], $data);
    }

    public function update(Paciente $paciente, array $data): Paciente
    {
        $paciente->update($data);
        return $paciente->fresh();
    }
}
