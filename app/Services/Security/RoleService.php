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

    public function findById(string $id)
    {
        return $this->repository->findById($id);
    }

    public function getMenus()
    {
        return $this->repository->getMenus();
    }

    public function getRolePermissions(string $roleId)
    {
        return $this->repository->getRolePermissions($roleId);
    }

    public function getMenuPermissions()
    {
        return $this->repository->getMenuPermissions();
    }

    public function store(
        array $data,
        array $menuPermissions = []
    ) {
        return DB::transaction(function () use ($data, $menuPermissions) {

            $username = auth()->user()->Username;

            $data['InputUser'] = $username;
            $data['InputDate'] = now();
            $data['RoleID'] = SecurityIdGenerator::nextRoleId();

            $role = $this->repository->create($data);

            $this->repository->syncRolePermissions(
                $role->RoleID,
                $menuPermissions,
                $username
            );

            return $role;
        });
    }

    public function update(
        string $id,
        array $data,
        array $menuPermissions = []
    ) {
        return DB::transaction(function () use ($id, $data, $menuPermissions) {

            $username = auth()->user()->Username;

            $data['ModifUser'] = $username;
            $data['ModifDate'] = now();

            $role = $this->repository->update(
                $id,
                $data
            );

            $this->repository->syncRolePermissions(
                $id,
                $menuPermissions,
                $username
            );

            return $role;
        });
    }

    public function delete(string $id)
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
