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

    public function getAll()
    {
        return $this->repository->getPaginated(10);
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

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

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

    public function syncPermissions(
        int $roleId,
        array $permissions
    ): void {
        DB::transaction(function () use ($roleId, $permissions) {

            $this->repository->syncPermissions(
                $roleId,
                $permissions,
                auth()->user()->UserID
            );

        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {

            return $this->repository->update($id, [

                'IsActive'    => false,
                'DeletedBy'   => auth()->user()->UserID,
                'DeletedDate' => now(),

            ]);

        });
    }
}
