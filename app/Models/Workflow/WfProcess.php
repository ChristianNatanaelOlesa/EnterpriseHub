<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;

class WfProcess extends BaseModel
{
    protected $table = 'wf_process';

    protected $primaryKey = 'ProcessID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'ProcessID',
        'Process',
        'ProcessDesc',
        'CcyID',
        'LimitMin',
        'LimitMax',
        'EffectiveDate',
        'SLADays',
        'IsActive',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'LimitMin' => 'decimal:2',
        'LimitMax' => 'decimal:2',
        'EffectiveDate' => 'date',
        'SLADays' => 'integer',
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];
}
