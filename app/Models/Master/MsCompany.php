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
        'CreatedDate' => 'datetime',
        'UpdatedDate' => 'datetime',
        'DeletedDate' => 'datetime',
    ];

    public function directorates()
    {
        return $this->hasMany(
            MsDirectorate::class,
            'CompanyID',
            'CompanyID'
        );
    }
}
