<?php

namespace App\Repositories\Master;

use App\Models\Master\MsDivision;
use App\Repositories\BaseRepository;

class DivisionRepository extends BaseRepository
{
    public function __construct(MsDivision $model)
    {
        $this->model = $model;
    }
}
