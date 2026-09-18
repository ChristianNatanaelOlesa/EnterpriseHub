<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;

class WfProcessDept extends BaseModel
{
    protected $table = 'wf_process_dept';

    protected $primaryKey = 'ProcessDeptID';

    protected $fillable = [
        'ProcessID',
        'DeptID',
        'IsActive',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'ProcessDeptID' => 'integer',
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
