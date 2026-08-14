<?php

namespace App\Services\Master;

use App\Repositories\Master\CompanyRepository;

class CompanyService
{
    protected CompanyRepository $repository;

    public function __construct(
        CompanyRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function getList(?string $search = null)
    {
        return $this->repository->search($search);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }
}
