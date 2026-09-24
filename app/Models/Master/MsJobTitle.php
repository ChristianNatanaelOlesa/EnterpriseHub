<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsJobTitle extends BaseModel
{
    protected $table = 'ms_job_title';

    protected $primaryKey = 'JobTitleID';

    protected $fillable = [
        'JobTitle',
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
}
