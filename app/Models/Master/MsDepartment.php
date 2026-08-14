<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\Master\MsDivision;

class MsDepartment extends BaseModel
{
    protected $table = 'ms_department';

    public function division()
    {
        return $this->belongsTo(MsDivision::class, 'DivisionID', 'DivisionID');
    }
}
