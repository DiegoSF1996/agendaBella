<?php

namespace App\Services;

use App\Repositories\StatusAgendamentoRepository;

class StatusAgendamentoService
{

    protected $status_agendamento_repository;

    public function __construct(StatusAgendamentoRepository $status_agendamento_repository){
        $this->status_agendamento_repository = $status_agendamento_repository;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
    {
        return $this->status_agendamento_repository->index($filtros, $limit, $per_page);
    }

    public function store($request)
    {
        return $this->status_agendamento_repository->store($request);
    }

    public function show($id)
    {
        $data = $this->status_agendamento_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $data = $this->status_agendamento_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $this->status_agendamento_repository->update($request->toArray(), $data);
    }

    public function destroy($id)
    {
        $data = $this->status_agendamento_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        $this->status_agendamento_repository->destroy($data);
    }

}
