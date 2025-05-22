<?php

namespace App\Services;

use App\Repositories\AgendamentoRepository;

class AgendamentoService
{

    protected $agendamento_repository;

    public function __construct(AgendamentoRepository $agendamento_repository){
        $this->agendamento_repository = $agendamento_repository;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
    {
        return $this->agendamento_repository->index($filtros, $limit, $per_page);
    }

    public function store($request)
    {
        return $this->agendamento_repository->store($request);
    }

    public function show($id)
    {
        $data = $this->agendamento_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $data = $this->agendamento_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $this->agendamento_repository->update($request->toArray(), $data);
    }

    public function destroy($id)
    {
        $data = $this->agendamento_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        $this->agendamento_repository->destroy($data);
    }
    public function gerarAgendaServicoMensal(\DateTime $data_base, int $pessoa_juridica_servico_id)
    {
        return $this->agendamento_repository->gerarAgendaServicoMensal($data_base, $pessoa_juridica_servico_id);
    }
    public function desativarAgendamento(\DateTime $data_hora_inicio, \DateTime $data_hora_fim, int $servico_horario_id )
    {
        $this->agendamento_repository->desativarAgendamento($data_hora_inicio, $data_hora_fim, $servico_horario_id );
    }
    public function agendarPessoaFisica(int $pessoa_fisica_id, int $agendamento_id)
    {
        return $this->agendamento_repository->agendarPessoaFisica($pessoa_fisica_id, $agendamento_id);
    }

    public function obterVagasDisponiveis(array $filtros)
    {
        return $this->agendamento_repository->obterVagasDisponiveis($filtros);
    }

}
