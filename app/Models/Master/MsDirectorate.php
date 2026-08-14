<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\Master\MsCompany;
use App\Models\Master\MsDivision;

class MsDirectorate extends BaseModel
{
    protected $table = 'ms_directorate';

    protected $primaryKey = 'DirectorateID';

    public $timestamps = false;

    public function company()
    {
        return $this->belongsTo(MsCompany::class, 'CompanyID', 'CompanyID');
    }

    public function divisions()
    {
        return $this->hasMany(MsDivision::class, 'DirectorateID', 'DirectorateID');
    }
}
