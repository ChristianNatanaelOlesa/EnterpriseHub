<?php

namespace App\Services\Security;

use App\Repositories\Security\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
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
        $user = $this->repository->findById($id);

        if ($user) {
            $user->RoleID = DB::table('sc_user_role')
                ->where('UserID', $id)
                ->where('IsActive', true)
                ->value('RoleID');
        }

        return $user;
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $roleId = $data['RoleID'];

            unset($data['RoleID']);

            $data['Password'] = Hash::make(
                $data['Password']
            );

            $data['CreatedBy'] = auth()->user()->UserID;
            $data['CreatedDate'] = now();

            $user = $this->repository->create($data);

            $this->repository->syncRole(
                $user->UserID,
                $roleId,
                auth()->user()->UserID
            );

            return $user;
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $roleId = $data['RoleID'];

            unset($data['RoleID']);

            $data['UpdatedBy'] = auth()->user()->UserID;
            $data['UpdatedDate'] = now();

            $user = $this->repository->update(
                $id,
                $data
            );

            $this->repository->syncRole(
                $id,
                $roleId,
                auth()->user()->UserID
            );

            return $user;
        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {

            return $this->repository->update($id, [
                'IsActive' => false,
                'DeletedBy' => auth()->user()->UserID,
                'DeletedDate' => now(),
            ]);
        });
    }

    public function resetPassword(int $id)
    {
        return DB::transaction(function () use ($id) {

            return $this->repository->update($id, [
                'Password' => Hash::make('admin123'),
                'UpdatedBy' => auth()->user()->UserID,
                'UpdatedDate' => now(),
            ]);
        });
    }

    public function toggleStatus(int $id)
    {
        $user = $this->repository->findById($id);

        return DB::transaction(function () use ($user) {

            return $this->repository->update(
                $user->UserID,
                [
                    'IsActive' => ! $user->IsActive,
                    'UpdatedBy' => auth()->user()->UserID,
                    'UpdatedDate' => now(),
                ]
            );
        });
    }
}
