<?php

namespace App\Services;

use App\Repositories\PessoaJuridicaRepository;

class PessoaJuridicaService
{

    protected $pessoa_juridica_repository;

    public function __construct(PessoaJuridicaRepository $pessoa_juridica_repository){
        $this->pessoa_juridica_repository = $pessoa_juridica_repository;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
    {
        return $this->pessoa_juridica_repository->index($filtros, $limit, $per_page);
    }

    public function store($request)
    {
        return $this->pessoa_juridica_repository->store($request);
    }

    public function show($id)
    {
        $data = $this->pessoa_juridica_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $data = $this->pessoa_juridica_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $this->pessoa_juridica_repository->update($request->toArray(), $data);
    }

    public function destroy($id)
    {
        $data = $this->pessoa_juridica_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        $this->pessoa_juridica_repository->destroy($data);
    }

}
