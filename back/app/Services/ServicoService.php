<?php

namespace App\Services;

use App\Repositories\ServicoRepository;

class ServicoService
{

    protected $servico_repository;

    public function __construct(ServicoRepository $servico_repository){
        $this->servico_repository = $servico_repository;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
    {
        return $this->servico_repository->index($filtros, $limit, $per_page);
    }

    public function store($request)
    {
        return $this->servico_repository->store($request);
    }

    public function show($id)
    {
        $data = $this->servico_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $data = $this->servico_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $this->servico_repository->update($request->toArray(), $data);
    }

    public function destroy($id)
    {
        $data = $this->servico_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        $this->servico_repository->destroy($data);
    }

}
