<?php

namespace App\Services\Master;

use App\Repositories\Master\DivisionRepository;
use Illuminate\Support\Facades\DB;

class DivisionService
{
    protected DivisionRepository $repository;

    public function __construct(DivisionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(?string $search = null)
    {
        return $this->repository->search($search, 10);
    }

    public function findById(string $id)
    {
        return $this->repository->findById($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            unset($data['CompID']);

            $data['InputUser'] = auth()->user()->Username;
            $data['InputDate'] = now();

            return $this->repository->create($data);
        });
    }

    public function update(string $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            unset($data['CompID']);

            $data['ModifUser'] = auth()->user()->Username;
            $data['ModifDate'] = now();

            return $this->repository->update($id, $data);
        });
    }

    public function delete(string $id)
    {
        return DB::transaction(function () use ($id) {

            return $this->repository->update(
                $id,
                [
                    'IsActive' => false,
                    'DeletedBy' => auth()->user()->Username,
                    'DeletedDate' => now(),
                ]
            );
        });
    }
}
