<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\PessoaFisica;

class PessoaFisicaRepository
{

    protected $pessoa_fisica;
    public function __construct(PessoaFisica $pessoa_fisica){
        $this->pessoa_fisica = $pessoa_fisica;
    }

    public function index (array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->pessoa_fisica;
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
            $data = $this->pessoa_fisica->create($dataForm);
            DB::commit();
           return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->pessoa_fisica->find($id);
    }

    public function update(array $dataForm, PessoaFisica $pessoa_fisica)
    {
        DB::beginTransaction();
        try {
            $pessoa_fisica->update($dataForm);
            DB::commit();
            return $pessoa_fisica->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(PessoaFisica $pessoa_fisica)
    {
        DB::beginTransaction();
        try {
            $pessoa_fisica->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

}
