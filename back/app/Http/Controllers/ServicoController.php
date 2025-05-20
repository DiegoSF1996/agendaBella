<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\ServicoRequest;
use App\Services\ServicoService;

class ServicoController extends Controller
{

    protected $servico_service;
    public function __construct(ServicoService $servico_service){
        $this->servico_service = $servico_service;
    }
    /**
     * @OA\Get(
     *     path="/api/servicos",
     *    tags={"servicos"},
     *     summary="Retorna uma lista de servicos",
     *     description="Index",
     *  @OA\Response(response=200, description="Retorna uma lista de servicos",
     *          ),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit',0);
        $per_page = $request->get('per_page',0);
        $filtros = [];
        return response()->json($this->servico_service->index($filtros, $limit, $per_page), Response::HTTP_OK );
    }
    /**
    * @OA\Post(
    * path="/api/servicos",
    * tags={"servicos"},
    * summary="Cadastra servicos",
    * description="servicos cadastro",
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
    public function store(ServicoRequest $request)
    {
        try {
            $data = $this->servico_service->store($request->all());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível cadastrar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/servicos/{id}",
     *     tags={"servicos"},
     *     summary="Consulta servicos",
     *     description="Index",
     *     @OA\Parameter(name="id", in="path", description="Id de servicos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Retorna uma lista de servicos"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $data = $this->servico_service->show($id);
        if(!$data){
            return response()->json(['message' => 'Não foi possível executar a ação', 'error' => ['Dados não encontrados']], Response::HTTP_NOT_FOUND);
        }
        return response()->json($data, Response::HTTP_OK);
    }
    /**
     * @OA\Put(
     *     path="/api/servicos/{id}",
     *     tags={"servicos"},
     *     summary="Atualiza servicos",
     *     description="Update servicos in DB",
     *     @OA\Parameter(name="id", in="path", description="Id de servicos", required=true,
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
    public function update(ServicoRequest $request, $id)
    {
        $dataFrom = $request->all();
        try {
            $data = $this->servico_service->update($request,$id);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível atualizar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/servicos/{id}",
     *     tags={"servicos"},
     *     summary="Exclui servicos",
     *     description="Destroy",
     *     @OA\Parameter(name="id", in="path", description="Id de servicos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Excluído com sucesso"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        try {
            $this->servico_service->destroy($id);
            return response()->json(['success' => 'Deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível excluir', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}
