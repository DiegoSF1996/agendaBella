<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\ServicoHorario;

class ServicoHorarioRepository
{

    protected $servico_horario;
    public function __construct(ServicoHorario $servico_horario){
        $this->servico_horario = $servico_horario;
    }

    public function index (array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->servico_horario->withCount(['agendamento']);
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
            $data = $this->servico_horario->create($dataForm);
            DB::commit();
           return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->servico_horario->find($id);
    }

    public function update(array $dataForm, ServicoHorario $servico_horario)
    {
        DB::beginTransaction();
        try {
            $servico_horario->update($dataForm);
            DB::commit();
            return $servico_horario->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(ServicoHorario $servico_horario)
    {
        DB::beginTransaction();
        try {
            $servico_horario->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

}
