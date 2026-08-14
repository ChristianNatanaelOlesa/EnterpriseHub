<?php

namespace App\Repositories\Security;

use App\Models\Security\ScUser;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct(ScUser $model)
    {
        $this->model = $model;
    }

    public function getPaginated(int $perPage = 10)
    {
        return $this->model
            ->whereNull('DeletedDate')
            ->orderBy('UserID')
            ->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }
}
