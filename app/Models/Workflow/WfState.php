<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;

class WfState extends BaseModel
{
    protected $table = 'wf_state';

    protected $primaryKey = 'StateID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'StateID',
        'ProcessID',
        'StateTypeID',
        'StateName',
        'StateDesc',
        'IsActive',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function process()
    {
        return $this->belongsTo(
            WfProcess::class,
            'ProcessID',
            'ProcessID'
        );
    }
}
