<?php

namespace App\Services\Security;

use App\Repositories\Security\PermissionRepository;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function __construct(private PermissionRepository $repository)
    {
    }

    public function getAll(?string $search = null)
    {
        return $this->repository->getPaginated($search);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $username = auth()->user()->Username;
            $now = now();
            $data += [
                'InputUser' => $username,
                'InputDate' => $now,
                'ModifUser' => $username,
                'ModifDate' => $now,
            ];

            return $this->repository->create($data);
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $username = auth()->user()->Username;
            $data['ModifUser'] = $username;
            $data['ModifDate'] = now();
            $data['DeletedBy'] = null;
            $data['DeletedDate'] = null;

            return $this->repository->update($id, $data);
        });
    }

    public function deactivate(int $id): void
    {
        $this->repository->update($id, [
            'IsActive' => false,
            'ModifUser' => auth()->user()->Username,
            'ModifDate' => now(),
            'DeletedBy' => auth()->user()->Username,
            'DeletedDate' => now(),
        ]);
    }
}
