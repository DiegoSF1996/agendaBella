<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\PessoaJuridicaRequest;
use App\Services\PessoaJuridicaService;

class PessoaJuridicaController extends Controller
{

    protected $pessoa_juridica_service;
    public function __construct(PessoaJuridicaService $pessoa_juridica_service){
        $this->pessoa_juridica_service = $pessoa_juridica_service;
    }
    /**
     * @OA\Get(
     *     path="/api/pessoajuridicas",
     *    tags={"pessoajuridicas"},
     *     summary="Retorna uma lista de pessoajuridicas",
     *     description="Index",
     *  @OA\Response(response=200, description="Retorna uma lista de pessoajuridicas",
     *          ),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit',0);
        $per_page = $request->get('per_page',0);
        $filtros = [];
        return response()->json($this->pessoa_juridica_service->index($filtros, $limit, $per_page), Response::HTTP_OK );
    }
    /**
    * @OA\Post(
    * path="/api/pessoajuridicas",
    * tags={"pessoajuridicas"},
    * summary="Cadastra pessoajuridicas",
    * description="pessoajuridicas cadastro",
    *     @OA\RequestBody(
    *        @OA\JsonContent(
    *          
		*	@OA\Property(property="pessoa_juridica_id"),
		*	@OA\Property(property="servico_id"),
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
    public function store(PessoaJuridicaRequest $request)
    {
        try {
            $data = $this->pessoa_juridica_service->store($request->all());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível cadastrar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/pessoajuridicas/{id}",
     *     tags={"pessoajuridicas"},
     *     summary="Consulta pessoajuridicas",
     *     description="Index",
     *     @OA\Parameter(name="id", in="path", description="Id de pessoajuridicas", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Retorna uma lista de pessoajuridicas"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $data = $this->pessoa_juridica_service->show($id);
        if(!$data){
            return response()->json(['message' => 'Não foi possível executar a ação', 'error' => ['Dados não encontrados']], Response::HTTP_NOT_FOUND);
        }
        return response()->json($data, Response::HTTP_OK);
    }
    /**
     * @OA\Put(
     *     path="/api/pessoajuridicas/{id}",
     *     tags={"pessoajuridicas"},
     *     summary="Atualiza pessoajuridicas",
     *     description="Update pessoajuridicas in DB",
     *     @OA\Parameter(name="id", in="path", description="Id de pessoajuridicas", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *        @OA\JsonContent(
     *          
		*	@OA\Property(property="pessoa_juridica_id"),
		*	@OA\Property(property="servico_id"),
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
    public function update(PessoaJuridicaRequest $request, $id)
    {
        $dataFrom = $request->all();
        try {
            $data = $this->pessoa_juridica_service->update($request,$id);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível atualizar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/pessoajuridicas/{id}",
     *     tags={"pessoajuridicas"},
     *     summary="Exclui pessoajuridicas",
     *     description="Destroy",
     *     @OA\Parameter(name="id", in="path", description="Id de pessoajuridicas", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Excluído com sucesso"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        try {
            $this->pessoa_juridica_service->destroy($id);
            return response()->json(['success' => 'Deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível excluir', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}
