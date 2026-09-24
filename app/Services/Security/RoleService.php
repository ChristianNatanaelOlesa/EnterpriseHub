<?php

namespace App\Services\Security;

use App\Repositories\Security\RoleRepository;
use Illuminate\Support\Facades\DB;

class RoleService
{
    protected RoleRepository $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(?string $search = null)
    {
        return $this->repository->getPaginated(10, $search);
    }

    public function getActiveRoles()
    {
        return $this->repository->getActiveRoles();
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function getMenus()
    {
        return $this->repository->getMenus();
    }

    public function getRolePermissions(int $roleId)
    {
        return $this->repository->getRolePermissions($roleId);
    }

    public function store(
        array $data,
        array $permissions = []
    ) {
        return DB::transaction(function () use (
            $data,
            $permissions
        ) {

            $username = auth()->user()->Username;

            $data['InputUser'] = $username;
            $data['InputDate'] = now();

            $role = $this->repository->create($data);

            $this->repository->syncPermissions(
                $role->RoleID,
                $permissions,
                $username
            );

            return $role;
        });
    }

    public function update(
        int $id,
        array $data,
        array $permissions = []
    ) {
        return DB::transaction(function () use (
            $id,
            $data,
            $permissions
        ) {

            $username = auth()->user()->Username;

            $data['ModifUser'] = $username;
            $data['ModifDate'] = now();

            $role = $this->repository->update(
                $id,
                $data
            );

            $this->repository->syncPermissions(
                $id,
                $permissions,
                $username
            );

            return $role;
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
}
