<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;

class WfTransition extends BaseModel
{
    protected $table = 'wf_transition';

    protected $primaryKey = 'Transition';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'ProcessID',
        'CurrentStateID',
        'NextStateID',
        'Transition',
        'SLADays',
        'IsActive',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'SLADays' => 'integer',
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

    public function currentState()
    {
        return $this->belongsTo(
            WfState::class,
            'CurrentStateID',
            'StateID'
        );
    }

    public function nextState()
    {
        return $this->belongsTo(
            WfState::class,
            'NextStateID',
            'StateID'
        );
    }

    public function transActions()
    {
        return $this->hasMany(
            WfTransAction::class,
            'TransitionID',
            'Transition'
        );
    }

    public function getTransitionIdAttribute(): string
    {
        return $this->CurrentStateID . $this->NextStateID;
    }
}
