<?php

namespace App\Repositories\Master;

use App\Models\Master\MsDepartment;
use App\Repositories\BaseRepository;

class DepartmentRepository extends BaseRepository
{
    public function __construct(MsDepartment $model)
    {
        $this->model = $model;
    }
}
