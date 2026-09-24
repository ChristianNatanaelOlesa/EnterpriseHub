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

        'InputUser',
        'InputDate',
        'ModifUser',
        'ModifDate',
        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
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
