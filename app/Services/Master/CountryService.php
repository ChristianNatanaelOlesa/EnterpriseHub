<?php

namespace App\Services\Master;

use App\Repositories\Master\CountryRepository;
use Illuminate\Support\Facades\DB;

class CountryService
{
    protected CountryRepository $repository;

    public function __construct(CountryRepository $repository)
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

            $data['InputUser'] = auth()->user()->UserID;
            $data['InputDate'] = now();

            return $this->repository->create($data);
        });
    }

    public function update(string $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $data['ModifUser'] = auth()->user()->UserID;
            $data['ModifDate'] = now();

            return $this->repository->update($id, $data);
        });
    }

    public function delete(string $id)
    {
        return DB::transaction(function () use ($id) {

            $data = [
                'IsActive' => false,
                'ModifUser' => auth()->user()->UserID,
                'ModifDate' => now(),
            ];

            return $this->repository->update($id, $data);
        });
    }
}
