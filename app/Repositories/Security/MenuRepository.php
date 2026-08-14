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

    public function getAllMenus()
    {
        return $this->model
            ->whereNull('DeletedDate')
            ->orderBy('SortOrder')
            ->orderBy('Name')
            ->paginate(10);
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
