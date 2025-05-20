<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\PessoaJuridica;

class PessoaJuridicaRepository
{

    protected $pessoa_juridica;
    public function __construct(PessoaJuridica $pessoa_juridica){
        $this->pessoa_juridica = $pessoa_juridica;
    }

    public function index (array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->pessoa_juridica;
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
            $data = $this->pessoa_juridica->create($dataForm);
            DB::commit();
           return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->pessoa_juridica->find($id);
    }

    public function update(array $dataForm, PessoaJuridica $pessoa_juridica)
    {
        DB::beginTransaction();
        try {
            $pessoa_juridica->update($dataForm);
            DB::commit();
            return $pessoa_juridica->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(PessoaJuridica $pessoa_juridica)
    {
        DB::beginTransaction();
        try {
            $pessoa_juridica->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

}
