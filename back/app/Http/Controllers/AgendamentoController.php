<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\AgendamentoRequest;
use App\Services\AgendamentoService;

class AgendamentoController extends Controller
{

    protected $agendamento_service;
    public function __construct(AgendamentoService $agendamento_service)
    {
        $this->agendamento_service = $agendamento_service;
    }
    /**
     * @OA\Get(
     *     path="/api/agendamentos",
     *    tags={"agendamentos"},
     *     summary="Retorna uma lista de agendamentos",
     *     description="Index",
     *  @OA\Response(response=200, description="Retorna uma lista de agendamentos",
     *          ),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 0);
        $per_page = $request->get('per_page', 0);
        $filtros = [];
        return response()->json($this->agendamento_service->index($filtros, $limit, $per_page), Response::HTTP_OK);
    }
    /**
     * @OA\Post(
     * path="/api/agendamentos",
     * tags={"agendamentos"},
     * summary="Cadastra agendamentos",
     * description="agendamentos cadastro",
     *     @OA\RequestBody(
     *        @OA\JsonContent(
     *
     *	@OA\Property(property="pessoa_fisica_id"),
     *	@OA\Property(property="pessoa_juridica_id"),
     *	@OA\Property(property="servico_id"),
     *	@OA\Property(property="data_hora_agendamento"),
     *	@OA\Property(property="data_hora_conclusao"),
     *	@OA\Property(property="status_agendamento_id"),
     *	@OA\Property(property="observacao"),
     *        ),
     *     ),
     *  security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response=201,
     *          description="Cadastrado com sucesso",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function store(AgendamentoRequest $request)
    {
        try {
            $data = $this->agendamento_service->store($request->all());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível cadastrar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/agendamentos/{id}",
     *     tags={"agendamentos"},
     *     summary="Consulta agendamentos",
     *     description="Index",
     *     @OA\Parameter(name="id", in="path", description="Id de agendamentos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Retorna uma lista de agendamentos"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $data = $this->agendamento_service->show($id);
        if (!$data) {
            return response()->json(['message' => 'Não foi possível executar a ação', 'error' => ['Dados não encontrados']], Response::HTTP_NOT_FOUND);
        }
        return response()->json($data, Response::HTTP_OK);
    }
    /**
     * @OA\Put(
     *     path="/api/agendamentos/{id}",
     *     tags={"agendamentos"},
     *     summary="Atualiza agendamentos",
     *     description="Update agendamentos in DB",
     *     @OA\Parameter(name="id", in="path", description="Id de agendamentos", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *        @OA\JsonContent(
     *
     *	@OA\Property(property="pessoa_fisica_id"),
     *	@OA\Property(property="pessoa_juridica_id"),
     *	@OA\Property(property="servico_id"),
     *	@OA\Property(property="data_hora_agendamento"),
     *	@OA\Property(property="data_hora_conclusao"),
     *	@OA\Property(property="status_agendamento_id"),
     *	@OA\Property(property="observacao"),
     *        ),
     *     ),
     *  security={{ "bearerAuth": {} }},*
     *     @OA\Response(
     *          response=200, description="Atualizado com sucesso",
     *          @OA\JsonContent(
     *             @OA\Property(property="status_code", type="integer", example="200"),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */
    public function update(AgendamentoRequest $request, $id)
    {
        $dataFrom = $request->all();
        try {
            $data = $this->agendamento_service->update($request, $id);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível atualizar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/agendamentos/{id}",
     *     tags={"agendamentos"},
     *     summary="Exclui agendamentos",
     *     description="Destroy",
     *     @OA\Parameter(name="id", in="path", description="Id de agendamentos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Excluído com sucesso"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        try {
            $this->agendamento_service->destroy($id);
            return response()->json(['success' => 'Deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível excluir', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function gerarAgendaServicoMensal(Request $request)
    {
        try {
            $request->validate([
                'pessoa_juridica_servico_id' => 'required|integer|exists:pessoa_juridica_servico,id',
                'data_base' => 'required|date_format:Y-m-d',
            ], [
                'pessoa_juridica_servico_id.required' => 'O campo pessoa_juridica_servico_id é obrigatório',
                'pessoa_juridica_servico_id.integer' => 'O campo pessoa_juridica_servico_id deve ser um número inteiro',
                'pessoa_juridica_servico_id.exists' => 'O campo pessoa_juridica_servico_id não existe na tabela pessoa_juridica_servico',
                'data_base.required' => 'O campo data_base é obrigatório',
                'data_base.date_format' => 'O campo data_base deve ser uma data no formato Y-m-d',
            ]);
            $data_base = \DateTime::createFromFormat('Y-m-d', $request->get('data_base'));
            return $this->agendamento_service->gerarAgendaServicoMensal($data_base, $request->get('pessoa_juridica_servico_id'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Erro de validação', 'errors' => $e->errors()], \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao gerar agenda mensal', 'error' => $e->getMessage()], \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function desativarAgendamento(Request $request)
    {
        try {
            $request->validate([
                'data_hora_inicio' => 'required|date_format:Y-m-d H:i:s',
                'data_hora_fim' => 'required|date_format:Y-m-d H:i:s',
                'servico_horario_id' => 'required|integer|exists:servico_horario,id',
            ], [
                'data_hora_inicio.required' => 'O campo data_hora_inicio é obrigatório',
                'data_hora_inicio.date_format' => 'O campo data_hora_inicio deve ser uma data no formato Y-m-d H:i:s',
                'data_hora_fim.required' => 'O campo data_hora_fim é obrigatório',
                'data_hora_fim.date_format' => 'O campo data_hora_fim deve ser uma data no formato Y-m-d H:i:s',
                'servico_horario_id.required' => 'O campo servico_horario_id é obrigatório',
                'servico_horario_id.integer' => 'O campo servico_horario_id deve ser um número inteiro',
                'servico_horario_id.exists' => 'O campo servico_horario_id não existe na tabela servico_horario',
            ]);
            $data_hora_inicio = \DateTime::createFromFormat('Y-m-d H:i:s', $request->get('data_hora_inicio'));
            $data_hora_fim = \DateTime::createFromFormat('Y-m-d H:i:s', $request->get('data_hora_fim'));
            $this->agendamento_service->desativarAgendamento($data_hora_inicio, $data_hora_fim, $request->get('servico_horario_id'));
            return response()->json(['success' => 'Agendamentos desativados com sucesso.'], Response::HTTP_OK);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Erro de validação', 'errors' => $e->errors()], \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao desativar agendamento', 'error' => $e->getMessage()], \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function agendarPessoaFisica(Request $request, int $agendamento_id)
    {
        try {

            $request->validate([
                'pessoa_fisica_id' => 'required|integer|exists:pessoa_fisica,id',
            ], [
                'pessoa_fisica_id.required' => 'O campo pessoa_fisica_id é obrigatório',
                'pessoa_fisica_id.integer' => 'O campo pessoa_fisica_id deve ser um número inteiro',
                'pessoa_fisica_id.exists' => 'O campo pessoa_fisica_id não existe na tabela pessoa_fisica',
            ]);
            return $this->agendamento_service->agendarPessoaFisica($request->get('pessoa_fisica_id'), $agendamento_id);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Erro de validação', 'errors' => $e->errors()], \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao realizar agendamento', 'error' => $e->getMessage()], \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function obterVagasDisponiveis(Request $request)
    {
        try {
            $request->validate([
                'servico_id' => 'nullable|integer|exists:servico_horario,id',
                'pessoa_juridica_servico_id' => 'nullable|integer|exists:servico_horario,id',
                'pessoa_juridica_id' => 'nullable|integer|exists:pessoa_juridica,id',
                'data_agendamento' => 'nullable|date_format:Y-m-d',
                'dia_semana' => 'nullable|integer|between:0,6',
            ], [
                'servico_id.integer' => 'O campo servico_id deve ser um número inteiro',
                'servico_id.exists' => 'O campo servico_id não existe na tabela servico_horario',
                'pessoa_juridica_servico_id.integer' => 'O campo pessoa_juridica_servico_id deve ser um número inteiro',
                'pessoa_juridica_servico_id.exists' => 'O campo pessoa_juridica_servico_id não existe na tabela servico_horario',
                'data_agendamento.required' => 'O campo data_agendamento é obrigatório',
                'data_agendamento.date_format' => 'O campo data_agendamento deve ser uma data no formato Y-m-d',
                'dia_semana.integer' => 'O campo dia_semana deve ser um número inteiro',
                'dia_semana.between' => 'O campo dia_semana deve estar entre 0 e 6',
                'pessoa_juridica_id.integer' => 'O campo pessoa_juridica_id deve ser um número inteiro',
                'pessoa_juridica_id.exists' => 'O campo pessoa_juridica_id não existe na tabela pessoa_juridica',

            ]);
            $filtros = [];
            if ($request->get('servico_id')) {
                $filtros[] = ['agendamento.servico_horario_id', '=', $request->get('servico_id')];
            }
            if ($request->get('pessoa_juridica_servico_id')) {
                $filtros[] = ['pessoa_juridica_servico.pessoa_juridica_servico_id', '=', $request->get('pessoa_juridica_servico_id')];
            }
            if ($request->get('dia_semana')) {
                $filtros[] = ['servico_horario.dia_semana', '=', $request->get('dia_semana')];
            }
            if ($request->get('data_agendamento')) {
                $filtros[] = ['agendamento.data_hora_agendamento', '>=', \DateTime::createFromFormat('Y-m-d', $request->get('data_agendamento'))->format('Y-m-d 00:00:00')];
                $filtros[] = ['agendamento.data_hora_agendamento', '<=', \DateTime::createFromFormat('Y-m-d', $request->get('data_agendamento'))->format('Y-m-d 23:59:59')];
            }
            return $this->agendamento_service->obterVagasDisponiveis( $filtros);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Erro de validação', 'errors' => $e->errors()], \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao obter vagas disponíveis', 'error' => $e->getMessage()], \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
