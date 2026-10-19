<?php

namespace App\Repositories\Security;

use App\Models\Security\ScPermission;

class PermissionRepository
{
    public function __construct(private ScPermission $model)
    {
    }

    public function getPaginated(?string $search = null)
    {
        return $this->model->newQuery()
            ->when($search, fn ($query) => $query->where(fn ($query) => $query
                ->where('Name', 'like', "%{$search}%")
                ->orWhere('Name', 'like', "%{$search}%")))
            ->withCount([
                'menuPermissions as menu_count' => fn ($query) => $query
                    ->where('IsActive', true)->whereNull('DeletedDate'),
            ])
            ->orderBy('Name')
            ->paginate(15)
            ->withQueryString();
    }

    public function findById(int $id): ScPermission
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): ScPermission
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): ScPermission
    {
        $permission = $this->findById($id);
        $permission->update($data);

        return $permission->refresh();
    }
}
