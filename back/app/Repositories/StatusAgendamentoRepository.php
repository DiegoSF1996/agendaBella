<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\StatusAgendamento;

class StatusAgendamentoRepository
{

    protected $status_agendamento;
    public function __construct(StatusAgendamento $status_agendamento){
        $this->status_agendamento = $status_agendamento;
    }

    public function index (array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->status_agendamento;
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
            $data = $this->status_agendamento->create($dataForm);
            DB::commit();
           return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->status_agendamento->find($id);
    }

    public function update(array $dataForm, StatusAgendamento $status_agendamento)
    {
        DB::beginTransaction();
        try {
            $status_agendamento->update($dataForm);
            DB::commit();
            return $status_agendamento->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(StatusAgendamento $status_agendamento)
    {
        DB::beginTransaction();
        try {
            $status_agendamento->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

}
