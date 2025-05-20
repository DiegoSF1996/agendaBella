<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\PessoaFisicaRequest;
use App\Services\PessoaFisicaService;

class PessoaFisicaController extends Controller
{

    protected $pessoa_fisica_service;
    public function __construct(PessoaFisicaService $pessoa_fisica_service){
        $this->pessoa_fisica_service = $pessoa_fisica_service;
    }
    /**
     * @OA\Get(
     *     path="/api/pessoafisicas",
     *    tags={"pessoafisicas"},
     *     summary="Retorna uma lista de pessoafisicas",
     *     description="Index",
     *  @OA\Response(response=200, description="Retorna uma lista de pessoafisicas",
     *          ),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit',0);
        $per_page = $request->get('per_page',0);
        $filtros = [];
        return response()->json($this->pessoa_fisica_service->index($filtros, $limit, $per_page), Response::HTTP_OK );
    }
    /**
    * @OA\Post(
    * path="/api/pessoafisicas",
    * tags={"pessoafisicas"},
    * summary="Cadastra pessoafisicas",
    * description="pessoafisicas cadastro",
    *     @OA\RequestBody(
    *        @OA\JsonContent(
    *          
		*	@OA\Property(property="nome"),
		*	@OA\Property(property="user_id"),
		*	@OA\Property(property="cpf"),
		*	@OA\Property(property="data_nascimento"),
		*	@OA\Property(property="telefone"),
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
    public function store(PessoaFisicaRequest $request)
    {
        try {
            $data = $this->pessoa_fisica_service->store($request->all());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível cadastrar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/pessoafisicas/{id}",
     *     tags={"pessoafisicas"},
     *     summary="Consulta pessoafisicas",
     *     description="Index",
     *     @OA\Parameter(name="id", in="path", description="Id de pessoafisicas", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Retorna uma lista de pessoafisicas"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $data = $this->pessoa_fisica_service->show($id);
        if(!$data){
            return response()->json(['message' => 'Não foi possível executar a ação', 'error' => ['Dados não encontrados']], Response::HTTP_NOT_FOUND);
        }
        return response()->json($data, Response::HTTP_OK);
    }
    /**
     * @OA\Put(
     *     path="/api/pessoafisicas/{id}",
     *     tags={"pessoafisicas"},
     *     summary="Atualiza pessoafisicas",
     *     description="Update pessoafisicas in DB",
     *     @OA\Parameter(name="id", in="path", description="Id de pessoafisicas", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *        @OA\JsonContent(
     *          
		*	@OA\Property(property="nome"),
		*	@OA\Property(property="user_id"),
		*	@OA\Property(property="cpf"),
		*	@OA\Property(property="data_nascimento"),
		*	@OA\Property(property="telefone"),
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
    public function update(PessoaFisicaRequest $request, $id)
    {
        $dataFrom = $request->all();
        try {
            $data = $this->pessoa_fisica_service->update($request,$id);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível atualizar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/pessoafisicas/{id}",
     *     tags={"pessoafisicas"},
     *     summary="Exclui pessoafisicas",
     *     description="Destroy",
     *     @OA\Parameter(name="id", in="path", description="Id de pessoafisicas", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Excluído com sucesso"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        try {
            $this->pessoa_fisica_service->destroy($id);
            return response()->json(['success' => 'Deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível excluir', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}
