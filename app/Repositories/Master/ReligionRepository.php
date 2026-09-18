<?php

namespace App\Repositories\Master;

use App\Models\Master\MsReligion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReligionRepository
{
    public function __construct(
        protected MsReligion $model
    ) {
    }

    public function getAll(
        ?string $search = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->model
            ->newQuery()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('ReligionID', 'like', "%{$search}%")
                        ->orWhere('Religion', 'like', "%{$search}%");
                });
            })
            ->orderBy('ReligionID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(string $id): ?MsReligion
    {
        return $this->model
            ->newQuery()
            ->find($id);
    }

    public function create(array $data): MsReligion
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(
        string $id,
        array $data
    ): bool {
        $model = $this->find($id);

        if (!$model) {
            return false;
        }

        return $model->update($data);
    }

    public function delete(string $id): bool
    {
        $model = $this->find($id);

        if (!$model) {
            return false;
        }

        return $model->delete();
    }
}
