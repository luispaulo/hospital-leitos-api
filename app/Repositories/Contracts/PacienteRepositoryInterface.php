<?php

namespace App\Repositories\Contracts;

use App\Models\Paciente;

interface PacienteRepositoryInterface
{
    public function findByCpf(string $cpf): ?Paciente;
    public function findByCpfWithLeito(string $cpf): ?Paciente;
    public function isInternado(string $cpf): bool;
    public function upsert(string $cpf, array $data): Paciente;
    public function update(Paciente $paciente, array $data): Paciente;
}
