<?php

namespace App\Repositories\Security;

use App\Models\Security\ScMenu;
use App\Repositories\BaseRepository;

class MenuRepository extends BaseRepository
{
    public function __construct(ScMenu $model)
    {
        $this->model = $model;
    }

    public function getAllMenus(int $perPage = 10, ?string $search = null)
    {
        return $this->model
            ->with('parent')
            ->whereNull('DeletedDate')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('Code', 'like', "%{$search}%")
                        ->orWhere('Name', 'like', "%{$search}%")
                        ->orWhere('Route', 'like', "%{$search}%")
                        ->orWhere('URL', 'like', "%{$search}%")
                        ->orWhereHas('parent', function ($parentQuery) use ($search) {
                            $parentQuery->where('Name', 'like', "%{$search}%")
                                ->orWhere('Code', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('SortOrder')
            ->orderBy('Name')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getParentMenus()
    {
        return $this->model
            ->whereNull('DeletedDate')
            ->whereNull('ParentID')
            ->where('IsActive', true)
            ->where('IsMenu', true)
            ->orderBy('SortOrder')
            ->orderBy('Name')
            ->get();
    }
}
