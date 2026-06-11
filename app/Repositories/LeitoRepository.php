<?php

namespace App\Repositories;

use App\Models\Leito;
use App\Repositories\Contracts\LeitoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LeitoRepository implements LeitoRepositoryInterface
{
    public function __construct(private readonly Leito $model) {}

    public function findById(int $id): Leito
    {
        return $this->model->findOrFail($id);
    }

    public function findByIdWithPaciente(int $id): Leito
    {
        return $this->model->with('paciente')->findOrFail($id);
    }

    public function listAll(): Collection
    {
        return $this->model->with('paciente')->get();
    }
}
