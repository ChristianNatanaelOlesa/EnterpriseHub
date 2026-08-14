<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\Master\MsDirectorate;

class MsCompany extends BaseModel
{
    protected $table = 'ms_company';

    protected $primaryKey = 'CompanyID';

    public $timestamps = false;

    protected $fillable = [
        'CompanyCode',
        'CompanyName',
        'Address',
        'Phone',
        'Email',
        'IsActive',
        'CreatedBy',
        'CreatedDate',
        'UpdatedBy',
        'UpdatedDate'
    ];

    public function directorates()
    {
        return $this->hasMany(MsDirectorate::class, 'CompanyID', 'CompanyID');
    }
}
