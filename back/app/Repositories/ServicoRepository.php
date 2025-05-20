<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\Servico;

class ServicoRepository
{

    protected $servico;
    public function __construct(Servico $servico){
        $this->servico = $servico;
    }

    public function index (array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->servico;
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
            $data = $this->servico->create($dataForm);
            DB::commit();
           return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->servico->find($id);
    }

    public function update(array $dataForm, Servico $servico)
    {
        DB::beginTransaction();
        try {
            $servico->update($dataForm);
            DB::commit();
            return $servico->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(Servico $servico)
    {
        DB::beginTransaction();
        try {
            $servico->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

}
