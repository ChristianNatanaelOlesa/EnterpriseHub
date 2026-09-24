<?php

namespace App\Repositories\Master;

use App\Models\Master\MsJobTitle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JobTitleRepository
{
    public function __construct(protected MsJobTitle $model) {}

    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->when($search, fn($q) => $q->where('JobTitle', 'like', "%{$search}%"))
            ->orderBy('JobTitleID')->paginate($perPage)->withQueryString();
    }

    public function find(string $id): ?MsJobTitle { return $this->model->newQuery()->find($id); }
    public function create(array $data): MsJobTitle { return $this->model->newQuery()->create($data); }
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
