<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsDirectorate extends BaseModel
{
    protected $table = 'ms_directorate';

    protected $primaryKey = 'DirectorateID';

    protected $fillable = [
        'CompanyID',
        'DirectorateCode',
        'DirectorateName',
        'IsActive',

        'CreatedBy',
        'CreatedDate',

        'UpdatedBy',
        'UpdatedDate',

        'DeletedBy',
        'DeletedDate',
    ];

    protected $casts = [
        'CompanyID' => 'integer',
        'IsActive' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(
            MsCompany::class,
            'CompanyID',
            'CompanyID'
        );
    }

    public function divisions()
    {
        return $this->hasMany(
            MsDivision::class,
            'DirectorateID',
            'DirectorateID'
        );
    }
}
