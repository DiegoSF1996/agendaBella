<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{

    protected $user_repository;

    public function __construct(UserRepository $user_repository){
        $this->user_repository = $user_repository;
    }

    public function index(array $filtros = [], $limit = 0, $per_page = 0)
    {
        return $this->user_repository->index($filtros, $limit, $per_page);
    }

    public function store($request)
    {
        return $this->user_repository->store($request);
    }

    public function show($id)
    {
        $data = $this->user_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $data = $this->user_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        return $this->user_repository->update($request->toArray(), $data);
    }

    public function destroy($id)
    {
        $data = $this->user_repository->show($id);
        if (!$data) {
            throw new \Exception('Dados não encontrados');
        }
        $this->user_repository->destroy($data);
    }

}
