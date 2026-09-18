<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;

class WfAction extends BaseModel
{
    protected $table = 'wf_action';

    protected $primaryKey = 'ActionID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'Keterangan',
        'ActionID',
        'ProcessID',
        'ActionTypeID',
        'Action',
        'ActionDesc',
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

    public function targets()
    {
        return $this->hasMany(
            WfActionTarget::class,
            'ActionID',
            'ActionID'
        );
    }

    public function transActions()
    {
        return $this->hasMany(
            WfTransAction::class,
            'ActionID',
            'ActionID'
        );
    }
}
