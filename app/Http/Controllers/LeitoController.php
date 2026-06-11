<?php

namespace App\Http\Controllers;

use App\Http\Requests\OcuparLeitoRequest;
use App\Http\Requests\TransferirPacienteRequest;
use App\Services\LeitoService;
use Illuminate\Http\JsonResponse;

class LeitoController extends Controller
{
    public function __construct(private readonly LeitoService $leitoService) {}

    public function ocupar(OcuparLeitoRequest $request, int $id): JsonResponse
    {
        $paciente = $this->leitoService->ocupar($id, $request->nome, $request->cpf);

        return response()->json($paciente, 201);
    }

    public function desocupar(int $id): JsonResponse
    {
        $this->leitoService->desocupar($id);

        return response()->json(['message' => 'Leito liberado']);
    }

    public function transferir(TransferirPacienteRequest $request): JsonResponse
    {
        $paciente = $this->leitoService->transferir($request->cpf, $request->leito_id);

        return response()->json(['message' => 'Transferência realizada', 'paciente' => $paciente]);
    }

    public function buscarPorCpf(string $cpf): JsonResponse
    {
        $paciente = $this->leitoService->buscarPacientePorCpf($cpf);

        return response()->json($paciente);
    }

    public function status(int $id): JsonResponse
    {
        return response()->json($this->leitoService->statusLeito($id));
    }

    public function index(): JsonResponse
    {
        return response()->json($this->leitoService->listarLeitos());
    }
}
