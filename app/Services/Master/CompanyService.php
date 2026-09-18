<?php

namespace App\Services\Master;

use App\Repositories\Master\CompanyRepository;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    protected CompanyRepository $repository;

    public function __construct(CompanyRepository $repository)
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

            $data = [
                'DeletedBy' => auth()->user()->UserID,
                'DeletedDate' => now(),
            ];

            return $this->repository->update($id, $data);
        });
    }
}
