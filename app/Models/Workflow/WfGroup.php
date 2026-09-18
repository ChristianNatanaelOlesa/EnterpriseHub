<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;

class WfGroup extends BaseModel
{
    protected $table = 'wf_group';

    protected $primaryKey = 'GroupID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'GroupID',
        'ProcessID',
        'GroupName',
        'DivID',
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
