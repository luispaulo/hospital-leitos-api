<?php

namespace App\Services;

use App\Enums\LeitoStatus;
use App\Models\Leito;
use App\Models\Paciente;
use App\Repositories\Contracts\LeitoRepositoryInterface;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class LeitoService
{
    public function __construct(
        private readonly LeitoRepositoryInterface   $leitoRepository,
        private readonly PacienteRepositoryInterface $pacienteRepository,
    ) {}

    public function ocupar(int $leitoId, string $nome, string $cpf): Paciente
    {
        if ($this->pacienteRepository->isInternado($cpf)) {
            throw ValidationException::withMessages([
                'cpf' => 'Paciente já internado.',
            ]);
        }

        $leito = $this->leitoRepository->findById($leitoId);

        if ($leito->estaOcupado()) {
            throw ValidationException::withMessages([
                'leito_id' => 'Leito ocupado.',
            ]);
        }

        return $this->pacienteRepository->upsert($cpf, [
            'nome'     => $nome,
            'leito_id' => $leito->id,
        ]);
    }

    public function desocupar(int $leitoId): void
    {
        $leito = $this->leitoRepository->findByIdWithPaciente($leitoId);

        if ($leito->paciente) {
            $this->pacienteRepository->update($leito->paciente, ['leito_id' => null]);
        }
    }

    public function transferir(string $cpf, int $novoLeitoId): Paciente
    {
        $paciente = $this->pacienteRepository->findByCpf($cpf);

        if (!$paciente) {
            throw new ModelNotFoundException("Paciente não encontrado.");
        }

        $novoLeito = $this->leitoRepository->findById($novoLeitoId);

        if ($novoLeito->estaOcupado()) {
            throw ValidationException::withMessages([
                'leito_id' => 'Leito destino ocupado.',
            ]);
        }

        return $this->pacienteRepository->update($paciente, ['leito_id' => $novoLeito->id]);
    }

    public function buscarPacientePorCpf(string $cpf): Paciente
    {
        $paciente = $this->pacienteRepository->findByCpfWithLeito($cpf);

        if (!$paciente) {
            throw new ModelNotFoundException("Paciente não encontrado.");
        }

        return $paciente;
    }

    public function statusLeito(int $leitoId): array
    {
        $leito  = $this->leitoRepository->findByIdWithPaciente($leitoId);
        $status = $leito->estaOcupado() ? LeitoStatus::Ocupado : LeitoStatus::Livre;

        return [
            'ocupado' => $leito->estaOcupado(),
            'status'  => $status->value,
            'label'   => $status->label(),
        ];
    }

    public function listarLeitos(): Collection
    {
        return $this->leitoRepository->listAll();
    }
}
