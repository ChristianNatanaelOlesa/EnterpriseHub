<?php

namespace App\Repositories\Master;

use App\Models\Master\MsJobLevel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JobLevelRepository
{
    public function __construct(protected MsJobLevel $model) {}

    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->when($search, fn($q) => $q->where('JobLevel', 'like', "%{$search}%"))
            ->orderBy('JobLevelID')->paginate($perPage)->withQueryString();
    }

    public function find(string $id): ?MsJobLevel { return $this->model->newQuery()->find($id); }
    public function create(array $data): MsJobLevel { return $this->model->newQuery()->create($data); }
    public function update(string $id, array $data): bool
    {
        $model = $this->find($id);
        return $model ? $model->update($data) : false;
    }
    public function delete(string $id): bool
    {
        $model = $this->find($id);
        return $model ? $model->delete() : false;
    }
}
