<?php

namespace App\Providers;

use App\Repositories\Contracts\LeitoRepositoryInterface;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\Repositories\LeitoRepository;
use App\Repositories\PacienteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LeitoRepositoryInterface::class, LeitoRepository::class);
        $this->app->bind(PacienteRepositoryInterface::class, PacienteRepository::class);
    }
}
