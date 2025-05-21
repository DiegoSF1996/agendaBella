<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\User;

class UserRepository
{

    protected $user;
    public function __construct(User $user){
        $this->user = $user;
    }

    public function index (array $filtros = [], $limit = 0, $per_page = 0)
    {
        $query = $this->user;
        if (!empty($filtros)) {
            $query = $query->where($filtros);
        }
        if ($limit == '-1') {
            return ["data" => $query->get()];
        } else {
            $page_limit = $per_page ?: config('app.pageLimit');
            return $query->paginate($page_limit);
        }
    }

    public function store(array $dataForm)
    {
        DB::beginTransaction();
        try {
            $data = $this->user->create($dataForm);
            DB::commit();
           return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->user->find($id);
    }

    public function update(array $dataForm, User $user)
    {
        DB::beginTransaction();
        try {
            $user->update($dataForm);
            DB::commit();
            return $user->refresh();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

}
