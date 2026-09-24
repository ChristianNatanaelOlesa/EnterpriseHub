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

    public function getAll(?string $search = null)
    {
        return $this->repository->getPaginated(10, $search);
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
                $data['Username'] . '!23'
            );

            $data['InputUser'] = auth()->user()->Username;
            $data['InputDate'] = now();

            $user = $this->repository->create($data);

            $this->repository->syncRole(
                $user->UserID,
                $roleId,
                auth()->user()->Username
            );

            return $user;
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $roleId = $data['RoleID'];

            unset($data['RoleID']);

            $data['ModifUser'] = auth()->user()->Username;
            $data['ModifDate'] = now();

            $user = $this->repository->update(
                $id,
                $data
            );

            $this->repository->syncRole(
                $id,
                $roleId,
                auth()->user()->Username
            );

            return $user;
        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {

            return $this->repository->update($id, [
                'IsActive' => false,
                'DeletedBy' => auth()->user()->Username,
                'DeletedDate' => now(),
            ]);
        });
    }

    public function resetPassword(int $id)
    {
        return DB::transaction(function () use ($id) {

            $user = $this->repository->findById($id);

            return $this->repository->update($id, [
                'Password' => Hash::make($user->Username . '!23'),
                'ModifUser' => auth()->user()->Username,
                'ModifDate' => now(),
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
                    'ModifUser' => auth()->user()->Username,
                    'ModifDate' => now(),
                ]
            );
        });
    }
}
