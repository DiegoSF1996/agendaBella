<?php

namespace App\Services;

use App\Repositories\PessoaJuridicaServicoRepository;

class PessoaJuridicaServicoService
{

    protected $pessoa_juridica_servico_repository;

    public function __construct(PessoaJuridicaServicoRepository $pessoa_juridica_servico_repository){
        $this->pessoa_juridica_servico_repository = $pessoa_juridica_servico_repository;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
    {
        return $this->pessoa_juridica_servico_repository->index($filtros, $limit, $per_page);
    }

    public function store($request)
    {
        return $this->pessoa_juridica_servico_repository->store($request);
    }

    public function show($id)
    {
        $data = $this->pessoa_juridica_servico_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $data = $this->pessoa_juridica_servico_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $this->pessoa_juridica_servico_repository->update($request->toArray(), $data);
    }

    public function destroy($id)
    {
        $data = $this->pessoa_juridica_servico_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        $this->pessoa_juridica_servico_repository->destroy($data);
    }

}
