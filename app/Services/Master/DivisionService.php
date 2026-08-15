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

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            unset($data['CompanyID']);

            $data['CreatedBy'] = auth()->user()->UserID;
            $data['CreatedDate'] = now();

            return $this->repository->create($data);
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            unset($data['CompanyID']);

            $data['UpdatedBy'] = auth()->user()->UserID;
            $data['UpdatedDate'] = now();

            return $this->repository->update($id, $data);
        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {

            return $this->repository->update(
                $id,
                [
                    'IsActive' => false,
                    'DeletedBy' => auth()->user()->UserID,
                    'DeletedDate' => now(),
                ]
            );
        });
    }
}
