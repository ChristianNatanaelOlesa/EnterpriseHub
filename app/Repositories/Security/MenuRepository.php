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
                    $q->where('MenuID', 'like', "%{$search}%")
                        ->orWhere('Menu', 'like', "%{$search}%")
                        ->orWhere('Description', 'like', "%{$search}%")
                        ->orWhere('Route', 'like', "%{$search}%")
                        ->orWhereHas('parent', function ($parentQuery) use ($search) {
                            $parentQuery->where('Menu', 'like', "%{$search}%")
                                ->orWhere('MenuID', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('MenuID')
            ->orderBy('Menu')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getParentMenus()
    {
        return $this->model
            ->whereNull('DeletedDate')
            ->where('IsActive', true)
            ->where('IsMenu', true)
            ->orderBy('SortOrder')
            ->orderBy('Menu')
            ->get();
    }
}
