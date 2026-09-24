<?php

namespace App\Services\Master;

use App\Repositories\Master\EmailGroupRepository;
use Illuminate\Support\Facades\DB;

class EmailGroupService
{
    protected EmailGroupRepository $repository;

    public function __construct(EmailGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(?string $search = null, int $perPage = 10)
    {
        return $this->repository->search($search, $perPage);
    }

    public function findById(string $id)
    {
        return $this->repository->findById($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['EmailGroupID'] = $this->generateId();
            $data['InputUser'] = auth()->user()->Username;
            $data['InputDate'] = now();
            $data['ModifUser'] = auth()->user()->Username;
            $data['ModifDate'] = now();

            return $this->repository->create($data);
        });
    }


    protected function generateId(): string
    {
        $lastNumber = DB::table('ms_email_group')
            ->where('EmailGroupID', 'like', 'EG%')
            ->pluck('EmailGroupID')
            ->map(function ($id) {
                return preg_match('/^EG(\d{3})$/', $id, $matches)
                    ? (int) $matches[1]
                    : 0;
            })
            ->max() ?? 0;

        $nextNumber = $lastNumber + 1;

        if ($nextNumber > 999) {
            throw new \RuntimeException('Email Group ID sudah mencapai batas EG999.');
        }

        return 'EG' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function update(string $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $data['ModifUser'] = auth()->user()->Username;
            $data['ModifDate'] = now();

            return $this->repository->updateById($id, $data);
        });
    }

    public function delete(string $id)
    {
        return DB::transaction(function () use ($id) {
            $data = [
                'IsActive' => false,
                'DeletedBy' => auth()->user()->Username,
                'DeletedDate' => now(),
                'ModifUser' => auth()->user()->Username,
                'ModifDate' => now(),
            ];

            return $this->repository->updateById($id, $data);
        });
    }
}
