<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MsJobLevel extends BaseModel
{
    protected $table = 'ms_job_level';

    protected $primaryKey = 'JobLevelID';

    protected $fillable = [
        'JobLevel',
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
