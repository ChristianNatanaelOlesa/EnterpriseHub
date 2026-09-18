<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;

class WfTransAction extends BaseModel
{
    protected $table = 'wf_trans_action';

    protected $primaryKey = 'TransActionID';

    protected $fillable = [
        'TransitionID',
        'ActionID',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'TransActionID' => 'integer',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function transition()
    {
        return $this->belongsTo(
            WfTransition::class,
            'TransitionID',
            'Transition'
        );
    }

    public function action()
    {
        return $this->belongsTo(
            WfAction::class,
            'ActionID',
            'ActionID'
        );
    }
}
