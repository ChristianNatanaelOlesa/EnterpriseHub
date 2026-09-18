<?php

namespace App\Services\Master;

use App\Models\Master\MsReligion;
use App\Repositories\Master\ReligionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReligionService
{
    public function __construct(
        protected ReligionRepository $repository
    ) {
    }

    public function getAll(
        ?string $search = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->repository->getAll($search, $perPage);
    }

    public function find(string $id): ?MsReligion
    {
        return $this->repository->find($id);
    }

    public function create(array $data): MsReligion
    {
        return DB::transaction(function () use ($data) {
            $now = now();

            $data['InputDate'] = $now;
            $data['InputUser'] = Auth::user()?->username
                ?? Auth::user()?->email
                ?? 'SYSTEM';

            $data['ModifDate'] = null;
            $data['ModifUser'] = null;

            return $this->repository->create($data);
        });
    }

    public function update(
        string $id,
        array $data
    ): MsReligion {
        return DB::transaction(function () use ($id, $data) {
            $model = $this->repository->find($id);

            if (!$model) {
                throw ValidationException::withMessages([
                    'ReligionID' => 'Religion data not found.',
                ]);
            }

            $data['ModifDate'] = now();
            $data['ModifUser'] = Auth::user()?->username
                ?? Auth::user()?->email
                ?? 'SYSTEM';

            $this->repository->update($id, $data);

            return $this->repository->find($id);
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $model = $this->repository->find($id);

            if (!$model) {
                throw ValidationException::withMessages([
                    'ReligionID' => 'Religion data not found.',
                ]);
            }

            $this->repository->delete($id);
        });
    }
}
