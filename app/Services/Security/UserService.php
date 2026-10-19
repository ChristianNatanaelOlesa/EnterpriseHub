<?php

namespace App\Services\Security;

use App\Repositories\Security\UserRepository;
use App\Repositories\Security\UserRoleRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepository $repository;
    protected UserRoleRepository $userRoleRepository;

    public function __construct(
        UserRepository $repository,
        UserRoleRepository $userRoleRepository
    ) {
        $this->repository = $repository;
        $this->userRoleRepository = $userRoleRepository;
    }

    public function getAll(?string $search = null)
    {
        return $this->repository->getPaginated(10, $search);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function getUserRoleIds(int $userId): array
    {
        return $this->userRoleRepository->getUserRoleIds($userId);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $roleIds = array_values(array_unique(array_map('strval', $data['RoleIDs'])));
            unset($data['RoleIDs']);

            $data['Password'] = Hash::make($data['Username'] . '!23');
            $data['InputUser'] = auth()->user()->Username;
            $data['InputDate'] = now();

            $user = $this->repository->create($data);

            $this->userRoleRepository->sync(
                $user->UserID,
                $roleIds,
                auth()->user()->Username
            );

            return $user;
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $roleIds = array_values(array_unique(array_map('strval', $data['RoleIDs'])));
            unset($data['RoleIDs']);

            $data['ModifUser'] = auth()->user()->Username;
            $data['ModifDate'] = now();

            $user = $this->repository->update($id, $data);

            $this->userRoleRepository->sync(
                $id,
                $roleIds,
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
            return $this->repository->update($user->UserID, [
                'IsActive' => ! $user->IsActive,
                'ModifUser' => auth()->user()->Username,
                'ModifDate' => now(),
            ]);
        });
    }
}
