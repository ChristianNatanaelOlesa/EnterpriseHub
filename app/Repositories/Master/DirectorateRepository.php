<?php

namespace App\Repositories\Master;

use App\Models\Master\MsDirectorate;
use App\Repositories\BaseRepository;

class DirectorateRepository extends BaseRepository
{
    public function __construct(MsDirectorate $model)
    {
        $this->model = $model;
    }
}
