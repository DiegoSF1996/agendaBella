<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\PessoaJuridicaServico;

class PessoaJuridicaServicoRepository
{

    protected $pessoa_juridica_servico;
    public function __construct(PessoaJuridicaServico $pessoa_juridica_servico)
    {
        $this->pessoa_juridica_servico = $pessoa_juridica_servico;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->pessoa_juridica_servico
            ->select([
                'pessoa_juridica_servico.id',
                'pessoa_juridica_servico.pessoa_juridica_id',
                'pessoa_juridica_servico.servico_id',
                'pessoa_juridica.nome_fantasia as pessoa_juridica_nome_fantasia',
                'servico.nome as servico_nome'
            ])
            ->join('pessoa_juridica', 'pessoa_juridica_servico.pessoa_juridica_id', '=', 'pessoa_juridica.id')
            ->leftJoin('servico', 'pessoa_juridica_servico.servico_id', '=', 'servico.id');
        if (!empty($filtros)) {
            $query = $query->where($filtros);
        }
        if ($limit == '-1') {
            return ["data" => $query->get()];
        } else {
            $page_limit = $per_page ?: config('app.pageLimit');
            return $query->paginate($page_limit);
        }
    }

    public function store(array $dataForm)
    {
        DB::beginTransaction();
        try {
            $data = $this->pessoa_juridica_servico->create($dataForm);
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->pessoa_juridica_servico->find($id);
    }

    public function update(array $dataForm, PessoaJuridicaServico $pessoa_juridica_servico)
    {
        DB::beginTransaction();
        try {
            $pessoa_juridica_servico->update($dataForm);
            DB::commit();
            return $pessoa_juridica_servico->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(PessoaJuridicaServico $pessoa_juridica_servico)
    {
        DB::beginTransaction();
        try {
            $pessoa_juridica_servico->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }
}
