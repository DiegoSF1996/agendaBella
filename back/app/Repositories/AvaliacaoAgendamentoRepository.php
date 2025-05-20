<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\AvaliacaoAgendamento;

class AvaliacaoAgendamentoRepository
{

    protected $avaliacao_agendamento;
    public function __construct(AvaliacaoAgendamento $avaliacao_agendamento){
        $this->avaliacao_agendamento = $avaliacao_agendamento;
    }

    public function index (array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->avaliacao_agendamento;
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
            $data = $this->avaliacao_agendamento->create($dataForm);
            DB::commit();
           return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->avaliacao_agendamento->find($id);
    }

    public function update(array $dataForm, AvaliacaoAgendamento $avaliacao_agendamento)
    {
        DB::beginTransaction();
        try {
            $avaliacao_agendamento->update($dataForm);
            DB::commit();
            return $avaliacao_agendamento->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(AvaliacaoAgendamento $avaliacao_agendamento)
    {
        DB::beginTransaction();
        try {
            $avaliacao_agendamento->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

}
