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

            $user = Auth::user();

            $userName = $user?->Username
                ?? $user?->username
                ?? $user?->email
                ?? 'Admin';

            $data['InputDate'] = $now;
            $data['InputUser'] = $userName;

            $data['ModifDate'] = $now;
            $data['ModifUser'] = $userName;

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

            $user = Auth::user();

            $userName = $user?->Username
                ?? $user?->username
                ?? $user?->email
                ?? 'Admin';

            $newId = $data['ReligionID'] ?? $id;

            $data['ModifDate'] = now();
            $data['ModifUser'] = $userName;

            $updated = $this->repository->update($id, $data);

            if (!$updated) {
                throw ValidationException::withMessages([
                    'ReligionID' => 'Failed to update religion data.',
                ]);
            }

            /*
             * ReligionID adalah Primary Key.
             * Kalau ID berubah dari KAT -> CAT,
             * jangan cari lagi menggunakan ID lama.
             */
            $updatedModel = $this->repository->find($newId);

            if (!$updatedModel) {
                throw ValidationException::withMessages([
                    'ReligionID' => 'Religion data was updated but could not be retrieved.',
                ]);
            }

            return $updatedModel;
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
