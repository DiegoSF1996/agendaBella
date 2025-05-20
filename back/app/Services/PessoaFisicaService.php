<?php

namespace App\Services;

use App\Repositories\PessoaFisicaRepository;

class PessoaFisicaService
{

    protected $pessoa_fisica_repository;

    public function __construct(PessoaFisicaRepository $pessoa_fisica_repository){
        $this->pessoa_fisica_repository = $pessoa_fisica_repository;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
    {
        return $this->pessoa_fisica_repository->index($filtros, $limit, $per_page);
    }

    public function store($request)
    {
        return $this->pessoa_fisica_repository->store($request);
    }

    public function show($id)
    {
        $data = $this->pessoa_fisica_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $data = $this->pessoa_fisica_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $this->pessoa_fisica_repository->update($request->toArray(), $data);
    }

    public function destroy($id)
    {
        $data = $this->pessoa_fisica_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        $this->pessoa_fisica_repository->destroy($data);
    }

}
