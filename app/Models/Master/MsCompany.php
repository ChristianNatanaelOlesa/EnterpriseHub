<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsCompany extends BaseModel
{
    protected $table = 'ms_company';

    protected $primaryKey = 'CompID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'CompID',
        'Company',
        'Description',
        'Address',
        'Phone1',
        'Phone2',
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
    ];

    public function directorates()
    {
        return $this->hasMany(
            MsDirectorate::class,
            'CompID',
            'CompID'
        );
    }
}
