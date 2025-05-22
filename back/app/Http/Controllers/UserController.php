<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $user_service;
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }
    /**
     * @OA\Get(
     *     path="/api/users",
     *    tags={"users"},
     *     summary="Retorna uma lista de users",
     *     description="Index",
     *  @OA\Response(response=200, description="Retorna uma lista de users",
     *          ),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 0);
        $per_page = $request->get('per_page', 0);
        $filtros = [];
        return response()->json($this->user_service->index($filtros, $limit, $per_page), Response::HTTP_OK);
    }
    /**
     * @OA\Post(
     * path="/api/users",
     * tags={"users"},
     * summary="Cadastra users",
     * description="users cadastro",
     *     @OA\RequestBody(
     *        @OA\JsonContent(
     *
     *	@OA\Property(property="name"),
     *	@OA\Property(property="email"),
     *	@OA\Property(property="password"),
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
    public function store(UserRequest $request)
    {
        try {
            $data = $this->user_service->store($request->all());
            return response()->json($data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível cadastrar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Consulta users",
     *     description="Index",
     *     @OA\Parameter(name="id", in="path", description="Id de users", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Retorna uma lista de users"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function show($id)
    {
        $data = $this->user_service->show($id);
        if (!$data) {
            return response()->json(['message' => 'Não foi possível executar a ação', 'error' => ['Dados não encontrados']], Response::HTTP_NOT_FOUND);
        }
        return response()->json($data, Response::HTTP_OK);
    }
    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Atualiza users",
     *     description="Update users in DB",
     *     @OA\Parameter(name="id", in="path", description="Id de users", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *        @OA\JsonContent(
     *
     *	@OA\Property(property="name"),
     *	@OA\Property(property="email"),
     *	@OA\Property(property="password"),
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
    public function update(UserRequest $request, $id)
    {
        $dataFrom = $request->all();
        try {
            $data = $this->user_service->update($request, $id);
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível atualizar', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Exclui users",
     *     description="Destroy",
     *     @OA\Parameter(name="id", in="path", description="Id de users", required=true,
     *         @OA\Schema(type="integer")
     *     ),*
     *  @OA\Response(response=200, description="Excluído com sucesso"),
     *  security={{ "bearerAuth": {} }}
     * )
     */
    public function destroy($id)
    {
        try {
            $this->user_service->destroy($id);
            return response()->json(['success' => 'Deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível excluir', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function login(Request $request)
    {
        try {

            $email = $request->input('email');
            $password = $request->input('password');
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            $user = User::where('email', $email)
            ->firstOrFail();
            if(!Hash::check($password, $user->password)){
                return response()->json(["message" => 'Não foi possível realizar o login', "error" => 'E-mail ou Senha inválida'], Response::HTTP_NOT_ACCEPTABLE);
            }
            return response()->json([
                'data' => [
                    'user' => $user->load('pessoaJuridica', 'pessoaFisica'),
                    'token' => $user->createToken('token')->plainTextToken,
                ]
            ], Response::HTTP_OK);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(["message" => 'Não foi possível realizar o login', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível realizar o login', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Não foi possível realizar o logout', "error" => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
