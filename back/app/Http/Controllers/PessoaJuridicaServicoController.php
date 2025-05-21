<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\PessoaJuridicaServicoRequest;
use App\Services\PessoaJuridicaServicoService;

class PessoaJuridicaServicoController extends Controller
{

    protected $pessoa_juridica_servico_service;
    public function __construct(PessoaJuridicaServicoService $pessoa_juridica_servico_service){
        $this->pessoa_juridica_servico_service = $pessoa_juridica_servico_service;
    }
    /**
     * @OA\Get(
     *     path="/api/pessoajuridicaservicos",
     *    tags={"pessoajuridicaservicos"},
     *     summary="Retorna uma lista de pessoajuridicaservicos",
     *     description="Index",
     *  @OA\Response(response=200, description="Retorna uma lista de pessoajuridicaservicos",
     *          ),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit',0);
        $per_page = $request->get('per_page',0);
        $filtros = [];

        return response()->json($this->pessoa_juridica_servico_service->index($filtros, $limit, $per_page), Response::HTTP_OK );
    }
    /**
    * @OA\Post(
    * path="/api/pessoajuridicaservicos",
    * tags={"pessoajuridicaservicos"},
    * summary="Cadastra pessoajuridicaservicos",
    * description="pessoajuridicaservicos cadastro",
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
    public function store(PessoaJuridicaServicoRequest $request)
    {
        try {
            $data = $this->pessoa_juridica_servico_service->store($request->all());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível cadastrar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/pessoajuridicaservicos/{id}",
     *     tags={"pessoajuridicaservicos"},
     *     summary="Consulta pessoajuridicaservicos",
     *     description="Index",
     *     @OA\Parameter(name="id", in="path", description="Id de pessoajuridicaservicos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Retorna uma lista de pessoajuridicaservicos"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $data = $this->pessoa_juridica_servico_service->show($id);
        if(!$data){
            return response()->json(['message' => 'Não foi possível executar a ação', 'error' => ['Dados não encontrados']], Response::HTTP_NOT_FOUND);
        }
        return response()->json($data, Response::HTTP_OK);
    }
    /**
     * @OA\Put(
     *     path="/api/pessoajuridicaservicos/{id}",
     *     tags={"pessoajuridicaservicos"},
     *     summary="Atualiza pessoajuridicaservicos",
     *     description="Update pessoajuridicaservicos in DB",
     *     @OA\Parameter(name="id", in="path", description="Id de pessoajuridicaservicos", required=true,
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
    public function update(PessoaJuridicaServicoRequest $request, $id)
    {
        $dataFrom = $request->all();
        try {
            $data = $this->pessoa_juridica_servico_service->update($request,$id);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível atualizar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/pessoajuridicaservicos/{id}",
     *     tags={"pessoajuridicaservicos"},
     *     summary="Exclui pessoajuridicaservicos",
     *     description="Destroy",
     *     @OA\Parameter(name="id", in="path", description="Id de pessoajuridicaservicos", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Excluído com sucesso"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        try {
            $this->pessoa_juridica_servico_service->destroy($id);
            return response()->json(['success' => 'Deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível excluir', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}
