<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\Master\MsDirectorate;
use App\Models\Master\MsDepartment;

class MsDivision extends BaseModel
{
    protected $table = 'ms_division';

    public function directorate()
    {
        return $this->belongsTo(MsDirectorate::class, 'DirectorateID', 'DirectorateID');
    }

    public function departments()
    {
        return $this->hasMany(MsDepartment::class, 'DivisionID', 'DivisionID');
    }
}
