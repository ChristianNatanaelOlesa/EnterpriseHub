<?php

namespace App\Services\Security;

use App\Repositories\Security\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getPaginated(10);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $data['Password'] = Hash::make($data['Password']);

            $data['CreatedBy'] = auth()->user()->UserID;
            $data['CreatedDate'] = now();

            return $this->repository->create($data);

        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $data['UpdatedBy'] = auth()->user()->UserID;
            $data['UpdatedDate'] = now();

            return $this->repository->update($id, $data);

        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {

            return $this->repository->update($id, [

                'IsActive'   => false,
                'DeletedBy'  => auth()->user()->UserID,
                'DeletedDate' => now(),

            ]);

        });
    }

    public function resetPassword(int $id)
    {
        return DB::transaction(function () use ($id) {

            return $this->repository->update($id, [

                'Password'    => Hash::make('admin123'),
                'UpdatedBy'   => auth()->user()->UserID,
                'UpdatedDate' => now(),

            ]);

        });
    }

    public function toggleStatus(int $id)
    {
        $user = $this->repository->findById($id);

        return DB::transaction(function () use ($user) {

            return $this->repository->update($user->UserID, [

                'IsActive'   => !$user->IsActive,
                'UpdatedBy'  => auth()->user()->UserID,
                'UpdatedDate' => now(),

            ]);

        });
    }
}
