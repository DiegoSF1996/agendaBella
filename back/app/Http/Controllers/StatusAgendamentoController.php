<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\StatusAgendamentoRequest;
use App\Services\StatusAgendamentoService;

class StatusAgendamentoController extends Controller
{

    protected $status_agendamento_service;
    public function __construct(StatusAgendamentoService $status_agendamento_service){
        $this->status_agendamento_service = $status_agendamento_service;
    }
    /**
     * @OA\Get(
     *     path="/api/statusagendamentos",
     *    tags={"statusagendamentos"},
     *     summary="Retorna uma lista de statusagendamentos",
     *     description="Index",
     *  @OA\Response(response=200, description="Retorna uma lista de statusagendamentos",
     *          ),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit',0);
        $per_page = $request->get('per_page',0);
        $filtros = [];
        return response()->json($this->status_agendamento_service->index($filtros, $limit, $per_page), Response::HTTP_OK );
    }
    /**
    * @OA\Post(
    * path="/api/statusagendamentos",
    * tags={"statusagendamentos"},
    * summary="Cadastra statusagendamentos",
    * description="statusagendamentos cadastro",
    *     @OA\RequestBody(
    *        @OA\JsonContent(
    *          
		*	@OA\Property(property="descricao"),
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
    public function store(StatusAgendamentoRequest $request)
    {
        try {
            $data = $this->status_agendamento_service->store($request->all());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível cadastrar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/statusagendamentos/{id}",
     *     tags={"statusagendamentos"},
     *     summary="Consulta statusagendamentos",
     *     description="Index",
     *     @OA\Parameter(name="id", in="path", description="Id de statusagendamentos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Retorna uma lista de statusagendamentos"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $data = $this->status_agendamento_service->show($id);
        if(!$data){
            return response()->json(['message' => 'Não foi possível executar a ação', 'error' => ['Dados não encontrados']], Response::HTTP_NOT_FOUND);
        }
        return response()->json($data, Response::HTTP_OK);
    }
    /**
     * @OA\Put(
     *     path="/api/statusagendamentos/{id}",
     *     tags={"statusagendamentos"},
     *     summary="Atualiza statusagendamentos",
     *     description="Update statusagendamentos in DB",
     *     @OA\Parameter(name="id", in="path", description="Id de statusagendamentos", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *        @OA\JsonContent(
     *          
		*	@OA\Property(property="descricao"),
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
    public function update(StatusAgendamentoRequest $request, $id)
    {
        $dataFrom = $request->all();
        try {
            $data = $this->status_agendamento_service->update($request,$id);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível atualizar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/statusagendamentos/{id}",
     *     tags={"statusagendamentos"},
     *     summary="Exclui statusagendamentos",
     *     description="Destroy",
     *     @OA\Parameter(name="id", in="path", description="Id de statusagendamentos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Excluído com sucesso"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        try {
            $this->status_agendamento_service->destroy($id);
            return response()->json(['success' => 'Deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível excluir', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}
