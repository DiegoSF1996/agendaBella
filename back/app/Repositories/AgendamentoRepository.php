<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\Agendamento;
use App\Models\ServicoHorario;

class AgendamentoRepository
{

    protected $agendamento;
    public function __construct(Agendamento $agendamento)
    {
        $this->agendamento = $agendamento;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
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

    public function gerarAgendaServicoMensal(\DateTime $data_base, int $pessoa_juridica_servico_id)
    {
        $data_inicial = clone $data_base->modify('first day of this month');
        $data_final = $data_base->modify('last day of this month');
        $data_inicial_formatada =  $data_inicial->format('Y-m-d');
        $data_final_formatada =  $data_final->format('Y-m-d');
        $servico_horarios = ServicoHorario::query()
            ->select([
                'id',
                'dia_semana',
                DB::raw("concat('$data_inicial_formatada ', hora_inicio) as data_hora_inicial"),
                DB::raw("concat('$data_final_formatada ', hora_fim) as data_hora_final"),
                'tempo_medio'
            ])
            ->where('pessoa_juridica_servico_id', $pessoa_juridica_servico_id)
            ->get();
        $dados_agendamento = array_map(function ($item) {
            $data_inicial = \DateTime::createFromFormat('Y-m-d H:i:s', $item['data_hora_inicial']);
            $data_final = \DateTime::createFromFormat('Y-m-d H:i:s', $item['data_hora_final']);
            return [
                'servico_horario_id' => $item['id'],
                'array_data_hora_agendamento' => $this->gerarArrayMes($data_inicial, $data_final, $item['dia_semana'], 30),
                'status_agendamento_id' => 1,
            ];
        }, $servico_horarios->toArray());
        array_map(function ($agendamento_dia_semana) {
            array_map(function ($datas) use ($agendamento_dia_semana) {
                Agendamento::firstOrCreate(
                    [
                        'servico_horario_id' => $agendamento_dia_semana['servico_horario_id'],
                        'data_hora_agendamento' => $datas['data'],
                        'status_agendamento_id' => $agendamento_dia_semana['status_agendamento_id'],
                    ]
                );
            }, $agendamento_dia_semana['array_data_hora_agendamento']);
        }, $dados_agendamento);
    }

    public function gerarArrayMes(\DateTime $data_inicial, \DateTime $data_final, int $dia_semana, int $tempo_medio)
    {
        $array = [];
        $data_atual = $data_inicial;
        $hora_inicio = $data_atual->format('H:i:s');
        $hora_fim = $data_final->format('H:i:s');
        while ($data_atual <= $data_final) {
            $data_atual_clone = clone $data_atual;

            if ($data_atual->format('w') != $dia_semana) {
                $data_atual->modify('+1 day');
                continue;
            }
            $array[] = [
                'data' => $data_atual->format('Y-m-d H:i:s'),
                'dia_semana' => $data_atual->format('w')
            ];
            if ($data_atual_clone->modify("+$tempo_medio minutes")->format('H:i:s') > $hora_fim) {
                $data_atual->modify('+1 day')->setTime(...explode(':', $hora_inicio));
                continue;
            }
            $data_atual->modify("+$tempo_medio minutes");
        }
        return $array;
    }
}
