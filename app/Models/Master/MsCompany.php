<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsCompany extends BaseModel
{
    protected $table = 'ms_company';

    protected $primaryKey = 'CompanyID';

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
        'UpdatedDate',

        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
    ];

    public function directorates()
    {
        return $this->hasMany(
            MsDirectorate::class,
            'CompanyID',
            'CompanyID'
        );
    }

    public function divisions()
    {
        return $this->hasMany(
            MsDivision::class,
            'CompanyID',
            'CompanyID'
        );
    }

    public function departments()
    {
        return $this->hasMany(
            MsDepartment::class,
            'CompanyID',
            'CompanyID'
        );
    }
}
