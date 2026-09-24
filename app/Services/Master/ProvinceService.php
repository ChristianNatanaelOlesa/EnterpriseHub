<?php

namespace App\Services\Master;

use App\Repositories\Master\ProvinceRepository;
use Illuminate\Support\Facades\Auth;

class ProvinceService
{
    protected ProvinceRepository $repository;

    public function __construct(ProvinceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search(?string $keyword = null, int $perPage = 10)
    {
        return $this->repository->search($keyword, $perPage);
    }

    public function findById(string $id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
    {
        $data['InputDate'] = now();
        $data['InputUser'] = Auth::user()->Username;
        $data['IsActive'] = $data['IsActive'] ?? true;

        return $this->repository->create($data);
    }

    public function update(string $id, array $data)
    {
        $data['ModifDate'] = now();
        $data['ModifUser'] = Auth::user()->Username;

        return $this->repository->update($id, $data);
    }

    public function delete(string $id)
    {
        return $this->repository->update($id, [
            'IsActive' => false,
            'ModifUser' => Auth::user()->Username,
            'ModifDate' => now(),
            'DeletedBy' => Auth::user()->Username,
            'DeletedDate' => now(),
        ]);
    }
}
