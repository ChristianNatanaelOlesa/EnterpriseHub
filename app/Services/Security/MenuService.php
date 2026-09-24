<?php

namespace App\Services\Security;

use App\Repositories\Security\MenuRepository;
use Illuminate\Support\Facades\DB;

class MenuService
{
    protected MenuRepository $repository;

    public function __construct(MenuRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(?string $search = null)
    {
        return $this->repository->getAllMenus(10, $search);
    }

    public function getParents()
    {
        return $this->repository->getParentMenus();
    }

    public function findById(int $id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $data['InputUser'] = auth()->user()->Username;
            $data['InputDate'] = now();

            return $this->repository->create($data);
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $data['ModifUser'] = auth()->user()->Username;
            $data['ModifDate'] = now();

            return $this->repository->update($id, $data);
        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {

            return $this->repository->update($id, [

                'IsActive'    => false,
                'DeletedBy'   => auth()->user()->Username,
                'DeletedDate' => now(),

            ]);
        });
    }
}
