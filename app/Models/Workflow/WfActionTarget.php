<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;

class WfActionTarget extends BaseModel
{
    protected $table = 'wf_action_target';

    protected $primaryKey = 'ActionTargetID';

    protected $fillable = [
        'ActionID',
        'TargetID',
        'GroupID',
        'IsActive',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'ActionTargetID' => 'integer',
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function action()
    {
        return $this->belongsTo(
            WfAction::class,
            'ActionID',
            'ActionID'
        );
    }

    public function group()
    {
        return $this->belongsTo(
            WfGroup::class,
            'GroupID',
            'GroupID'
        );
    }
}
