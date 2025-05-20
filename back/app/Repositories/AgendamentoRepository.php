<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\Agendamento;

class AgendamentoRepository
{

    protected $agendamento;
    public function __construct(Agendamento $agendamento){
        $this->agendamento = $agendamento;
    }

    public function index (array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->agendamento;
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
            $data = $this->agendamento->create($dataForm);
            DB::commit();
           return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->agendamento->find($id);
    }

    public function update(array $dataForm, Agendamento $agendamento)
    {
        DB::beginTransaction();
        try {
            $agendamento->update($dataForm);
            DB::commit();
            return $agendamento->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(Agendamento $agendamento)
    {
        DB::beginTransaction();
        try {
            $agendamento->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

}
