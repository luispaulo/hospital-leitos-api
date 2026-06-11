<?php

namespace App\Repositories\Contracts;

use App\Models\Leito;
use Illuminate\Database\Eloquent\Collection;

interface LeitoRepositoryInterface
{
    public function findById(int $id): Leito;
    public function findByIdWithPaciente(int $id): Leito;
    public function listAll(): Collection;
}
