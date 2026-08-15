<?php

namespace App\Services\Master;

use App\Repositories\Master\DepartmentRepository;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    protected DepartmentRepository $repository;

    public function __construct(
        DepartmentRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function getAll(?string $search = null)
    {
        return $this->repository->search(
            $search,
            10
        );
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            /*
             * CompanyID dan DirectorateID hanya digunakan
             * untuk validasi hierarchy/form.
             *
             * ms_department hanya menyimpan DivisionID.
             */
            unset(
                $data['CompanyID'],
                $data['DirectorateID']
            );

            $data['CreatedBy'] =
                auth()->user()->UserID;

            $data['CreatedDate'] = now();

            return $this->repository->create($data);
        });
    }

    public function update(
        int $id,
        array $data
    ) {
        return DB::transaction(function () use (
            $id,
            $data
        ) {

            /*
             * Jangan kirim CompanyID dan DirectorateID
             * ke ms_department.
             */
            unset(
                $data['CompanyID'],
                $data['DirectorateID']
            );

            $data['UpdatedBy'] =
                auth()->user()->UserID;

            $data['UpdatedDate'] = now();

            return $this->repository->update(
                $id,
                $data
            );
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
