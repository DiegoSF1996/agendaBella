<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\Agendamento--table=Agendamento;

class Agendamento--table=AgendamentoRepository
{

    protected $agendamento--table=_agendamento;
    public function __construct(Agendamento--table=Agendamento $agendamento--table=_agendamento){
        $this->agendamento--table=_agendamento = $agendamento--table=_agendamento;
    }

    public function index (array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->agendamento--table=_agendamento;
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
            $data = $this->agendamento--table=_agendamento->create($dataForm);
            DB::commit();
           return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->agendamento--table=_agendamento->find($id);
    }

    public function update(array $dataForm, Agendamento--table=Agendamento $agendamento--table=_agendamento)
    {
        DB::beginTransaction();
        try {
            $agendamento--table=_agendamento->update($dataForm);
            DB::commit();
            return $agendamento--table=_agendamento->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(Agendamento--table=Agendamento $agendamento--table=_agendamento)
    {
        DB::beginTransaction();
        try {
            $agendamento--table=_agendamento->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

}
