<?php

namespace App\Repositories\Master;

use App\Models\Master\MsFolderPath;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FolderPathRepository
{
    public function __construct(protected MsFolderPath $model)
    {
    }

    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with('parent')
            ->when($search, function ($query) use ($search) {
                $like = "%{$search}%";

                $query->where(function ($q) use ($like) {
                    $q->where('FolderPathID', 'like', $like)
                        ->orWhere('FolderName', 'like', $like)
                        ->orWhere('FolderPath', 'like', $like)
                        ->orWhereHas('parent', function ($parent) use ($like) {
                            $parent->where('FolderName', 'like', $like)
                                ->orWhere('FolderPath', 'like', $like);
                        });
                });
            })
            ->orderBy('FolderName')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(string $id): ?MsFolderPath
    {
        return $this->model->newQuery()->with('parent')->find($id);
    }

    public function create(array $data): MsFolderPath
    {
        return $this->model->newQuery()->create($data);
    }

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

    public function activeList()
    {
        return $this->model->newQuery()
            ->where('IsActive', true)
            ->orderBy('FolderName')
            ->get();
    }
}
