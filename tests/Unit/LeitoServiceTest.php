<?php

namespace Tests\Unit;

use App\Models\Leito;
use App\Models\Paciente;
use App\Repositories\Contracts\LeitoRepositoryInterface;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\Services\LeitoService;
use Illuminate\Validation\ValidationException;
use Mockery;
use Tests\TestCase;

class LeitoServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_paciente_nao_pode_ocupar_dois_leitos(): void
    {
        $leitoRepository = Mockery::mock(LeitoRepositoryInterface::class);
        $pacienteRepository = Mockery::mock(PacienteRepositoryInterface::class);

        $pacienteRepository
            ->shouldReceive('isInternado')
            ->once()
            ->with('12345678901')
            ->andReturn(true);

        $leitoRepository
            ->shouldNotReceive('findById');

        $pacienteRepository
            ->shouldNotReceive('upsert');

        $service = new LeitoService($leitoRepository, $pacienteRepository);

        $this->expectException(ValidationException::class);

        $service->ocupar(1, 'Luis Paulo', '12345678901');
    }

    public function test_leito_nao_aceita_dois_pacientes(): void
    {
        $leitoRepository = Mockery::mock(LeitoRepositoryInterface::class);
        $pacienteRepository = Mockery::mock(PacienteRepositoryInterface::class);

        $leito = Mockery::mock(Leito::class);

        $leito
            ->shouldReceive('estaOcupado')
            ->once()
            ->andReturn(true);

        $pacienteRepository
            ->shouldReceive('isInternado')
            ->once()
            ->with('12345678901')
            ->andReturn(false);

        $leitoRepository
            ->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($leito);

        $pacienteRepository
            ->shouldNotReceive('upsert');

        $service = new LeitoService($leitoRepository, $pacienteRepository);

        $this->expectException(ValidationException::class);

        $service->ocupar(1, 'Luis Paulo', '12345678901');
    }

    public function test_paciente_pode_ocupar_leito_livre(): void
    {
        $leitoRepository = Mockery::mock(LeitoRepositoryInterface::class);
        $pacienteRepository = Mockery::mock(PacienteRepositoryInterface::class);

        $leito = Mockery::mock(Leito::class);

        $leito
            ->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(1);

        $leito
            ->shouldReceive('__get')
            ->with('id')
            ->andReturn(1);

        $paciente = new Paciente([
            'nome' => 'Luis Paulo',
            'cpf' => '12345678901',
            'leito_id' => 1,
        ]);

        $pacienteRepository
            ->shouldReceive('isInternado')
            ->once()
            ->with('12345678901')
            ->andReturn(false);

        $leitoRepository
            ->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($leito);

        $leito
            ->shouldReceive('estaOcupado')
            ->once()
            ->andReturn(false);

        $pacienteRepository
            ->shouldReceive('upsert')
            ->once()
            ->with('12345678901', [
                'nome' => 'Luis Paulo',
                'leito_id' => 1,
            ])
            ->andReturn($paciente);

        $service = new LeitoService($leitoRepository, $pacienteRepository);

        $resultado = $service->ocupar(1, 'Luis Paulo', '12345678901');

        $this->assertInstanceOf(Paciente::class, $resultado);
        $this->assertEquals('Luis Paulo', $resultado->nome);
        $this->assertEquals('12345678901', $resultado->cpf);
        $this->assertEquals(1, $resultado->leito_id);
    }
}
