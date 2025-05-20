<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\AvaliacaoAgendamentoRequest;
use App\Services\AvaliacaoAgendamentoService;

class AvaliacaoAgendamentoController extends Controller
{

    protected $avaliacao_agendamento_service;
    public function __construct(AvaliacaoAgendamentoService $avaliacao_agendamento_service){
        $this->avaliacao_agendamento_service = $avaliacao_agendamento_service;
    }
    /**
     * @OA\Get(
     *     path="/api/avaliacaoagendamentos",
     *    tags={"avaliacaoagendamentos"},
     *     summary="Retorna uma lista de avaliacaoagendamentos",
     *     description="Index",
     *  @OA\Response(response=200, description="Retorna uma lista de avaliacaoagendamentos",
     *          ),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit',0);
        $per_page = $request->get('per_page',0);
        $filtros = [];
        return response()->json($this->avaliacao_agendamento_service->index($filtros, $limit, $per_page), Response::HTTP_OK );
    }
    /**
    * @OA\Post(
    * path="/api/avaliacaoagendamentos",
    * tags={"avaliacaoagendamentos"},
    * summary="Cadastra avaliacaoagendamentos",
    * description="avaliacaoagendamentos cadastro",
    *     @OA\RequestBody(
    *        @OA\JsonContent(
    *          
		*	@OA\Property(property="agendamento_id"),
		*	@OA\Property(property="nota_avaliacao_da_pessoa_fisica"),
		*	@OA\Property(property="nota_avaliacao_da_pessoa_juridica"),
		*	@OA\Property(property="observacao_da_pessoa_fisica"),
		*	@OA\Property(property="observacao_da_pessoa_juridica"),
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
    public function store(AvaliacaoAgendamentoRequest $request)
    {
        try {
            $data = $this->avaliacao_agendamento_service->store($request->all());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível cadastrar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/avaliacaoagendamentos/{id}",
     *     tags={"avaliacaoagendamentos"},
     *     summary="Consulta avaliacaoagendamentos",
     *     description="Index",
     *     @OA\Parameter(name="id", in="path", description="Id de avaliacaoagendamentos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Retorna uma lista de avaliacaoagendamentos"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $data = $this->avaliacao_agendamento_service->show($id);
        if(!$data){
            return response()->json(['message' => 'Não foi possível executar a ação', 'error' => ['Dados não encontrados']], Response::HTTP_NOT_FOUND);
        }
        return response()->json($data, Response::HTTP_OK);
    }
    /**
     * @OA\Put(
     *     path="/api/avaliacaoagendamentos/{id}",
     *     tags={"avaliacaoagendamentos"},
     *     summary="Atualiza avaliacaoagendamentos",
     *     description="Update avaliacaoagendamentos in DB",
     *     @OA\Parameter(name="id", in="path", description="Id de avaliacaoagendamentos", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *        @OA\JsonContent(
     *          
		*	@OA\Property(property="agendamento_id"),
		*	@OA\Property(property="nota_avaliacao_da_pessoa_fisica"),
		*	@OA\Property(property="nota_avaliacao_da_pessoa_juridica"),
		*	@OA\Property(property="observacao_da_pessoa_fisica"),
		*	@OA\Property(property="observacao_da_pessoa_juridica"),
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
    public function update(AvaliacaoAgendamentoRequest $request, $id)
    {
        $dataFrom = $request->all();
        try {
            $data = $this->avaliacao_agendamento_service->update($request,$id);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível atualizar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/avaliacaoagendamentos/{id}",
     *     tags={"avaliacaoagendamentos"},
     *     summary="Exclui avaliacaoagendamentos",
     *     description="Destroy",
     *     @OA\Parameter(name="id", in="path", description="Id de avaliacaoagendamentos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Excluído com sucesso"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        try {
            $this->avaliacao_agendamento_service->destroy($id);
            return response()->json(['success' => 'Deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível excluir', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}
