<?php

namespace App\Services;

use App\Repositories\AvaliacaoAgendamentoRepository;

class AvaliacaoAgendamentoService
{

    protected $avaliacao_agendamento_repository;

    public function __construct(AvaliacaoAgendamentoRepository $avaliacao_agendamento_repository){
        $this->avaliacao_agendamento_repository = $avaliacao_agendamento_repository;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
    {
        return $this->avaliacao_agendamento_repository->index($filtros, $limit, $per_page);
    }

    public function store($request)
    {
        return $this->avaliacao_agendamento_repository->store($request);
    }

    public function show($id)
    {
        $data = $this->avaliacao_agendamento_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $data = $this->avaliacao_agendamento_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $this->avaliacao_agendamento_repository->update($request->toArray(), $data);
    }

    public function destroy($id)
    {
        $data = $this->avaliacao_agendamento_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        $this->avaliacao_agendamento_repository->destroy($data);
    }

}
