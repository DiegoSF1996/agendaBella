<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\Agendamento;
use App\Models\ServicoHorario;
use App\Models\StatusAgendamento;

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
        throw new \Exception('Erro ao cadastrar o agendamento');

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
        throw new \Exception('Erro ao atualizar o agendamento');
        try {
            $agendamento->update($dataForm);
            DB::commit();
            return $agendamento->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function agendarPessoaFisica(int $pessoa_fisica_id, int $agendamento_id)
    {
        try {
            DB::beginTransaction();
            $status_agendamento = StatusAgendamento::query()->where('codigo', '2')->first();
            if (!$this->validarAgendamentoDisponivel($agendamento_id)) {
                throw new \Exception('Não foi possível realizar o agendamento, pois o mesmo já foi cancelado / não existe ou já foi realizado');
            }
            $agendamento = Agendamento::find($agendamento_id);
            $agendamento->update([
                'pessoa_fisica_id' => $pessoa_fisica_id,
                'status_agendamento_id' => $status_agendamento->id
            ]);
            DB::commit();
            return ['data' => $agendamento->refresh()];
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }
    public function validarAgendamentoDisponivel(int $agendamento_id)
    {
        $agendamento = Agendamento::query()
            ->select('agendamento.*')
            ->join('status_agendamento', 'agendamento.status_agendamento_id', '=', 'status_agendamento.id')
            ->where('agendamento.id', $agendamento_id)
            ->whereNull('agendamento.pessoa_fisica_id')
            ->where('status_agendamento.codigo', 1)
            ->whereNull('agendamento.data_hora_conclusao')
            ->first();
        if (!$agendamento) {
            return false;
        }
        return true;
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

    public function obterVagasDisponiveis(array $filtros) {
        $agendamentos = Agendamento::query()
            ->select([
                'agendamento.id',
                'agendamento.data_hora_agendamento',
                'pessoa_juridica.nome_fantasia',
                'servico_horario.dia_semana',
                'pessoa_juridica_servico.pessoa_juridica_id'
            ])
            ->join('status_agendamento', 'agendamento.status_agendamento_id', '=', 'status_agendamento.id')
            ->join('servico_horario', 'agendamento.servico_horario_id', '=', 'servico_horario.id')
            ->join('pessoa_juridica_servico', 'servico_horario.pessoa_juridica_servico_id', '=', 'pessoa_juridica_servico.id')
            ->join('pessoa_juridica', 'pessoa_juridica_servico.pessoa_juridica_id', '=', 'pessoa_juridica.id')
            ->where($filtros)
            ->where('status_agendamento.codigo', '1')
            ->whereNull('agendamento.pessoa_fisica_id')
            ->whereNull('agendamento.data_hora_conclusao');
        return $agendamentos->paginate(15);
    }

    public function gerarAgendaServicoMensal(\DateTime $data_base, int $pessoa_juridica_servico_id)
    {
        try {
            DB::beginTransaction();
            $data_inicial = clone $data_base->modify('first day of this month');
            $data_hoje = new \DateTime();
            if ($data_hoje->format('Y-m-d') > $data_inicial->format('Y-m-d')) {
                $data_inicial = $data_hoje;
            }
            $data_final = $data_base->modify('last day of this month');
            $data_inicial_formatada =  $data_inicial->format('Y-m-d');
            $data_final_formatada =  $data_final->format('Y-m-d');
            $status_agendamento = StatusAgendamento::query()->where('codigo', '1')->first();
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
            $dados_agendamento = array_map(function ($item) use ($status_agendamento) {
                $data_inicial = \DateTime::createFromFormat('Y-m-d H:i:s', $item['data_hora_inicial']);
                $data_final = \DateTime::createFromFormat('Y-m-d H:i:s', $item['data_hora_final']);
                return [
                    'servico_horario_id' => $item['id'],
                    'array_data_hora_agendamento' => $this->gerarArrayMes($data_inicial, $data_final, $item['dia_semana'], 30),
                    'status_agendamento_id' => $status_agendamento->id,
                ];
            }, $servico_horarios->toArray());
            $agendamentos = array_map(function ($agendamento_dia_semana) {
                return array_map(function ($datas) use ($agendamento_dia_semana) {
                    return Agendamento::firstOrCreate(
                        [
                            'servico_horario_id' => $agendamento_dia_semana['servico_horario_id'],
                            'data_hora_agendamento' => $datas['data'],
                            'status_agendamento_id' => $agendamento_dia_semana['status_agendamento_id'],
                        ]
                    );
                }, $agendamento_dia_semana['array_data_hora_agendamento']);
            }, $dados_agendamento);
            DB::commit();
            return ['data' => $agendamentos];
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function desativarAgendamento(\DateTime $data_hora_inicio, \DateTime $data_hora_fim, int $servico_horario_id): void
    {
        try {
            $status_agendamento = StatusAgendamento::query()->where('codigo', '3')->first();
            $agendamentos = Agendamento::query()
                ->join('status_agendamento', 'agendamento.status_agendamento_id', '=', 'status_agendamento.id')
                ->join('servico_horario', 'agendamento.servico_horario_id', '=', 'servico_horario.id')
                ->where('agendamento.data_hora_agendamento', '>=', $data_hora_inicio->format('Y-m-d H:i:s'))
                ->where('agendamento.data_hora_agendamento', '<=', $data_hora_fim->format('Y-m-d H:i:s'))
                ->where('status_agendamento.codigo', 1)
                ->where('agendamento.servico_horario_id', $servico_horario_id)
                ->update(['agendamento.status_agendamento_id' => $status_agendamento->id]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
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
