<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WfApprovalStep extends BaseModel
{
    protected $table = 'wf_approval_step';
    protected $primaryKey = 'ApprovalStepID';

    protected $fillable = [
        'ApprovalRuleID', 'StepNo', 'StepCode', 'StepName', 'ResolverType',
        'ResolverConfig', 'IsMandatory', 'AllowSelfSkip', 'SLADays', 'IsActive',
        'InputDate', 'InputUser', 'ModifDate', 'ModifUser',
    ];

    protected $casts = [
        'StepNo' => 'integer',
        'ResolverConfig' => 'array',
        'IsMandatory' => 'boolean',
        'AllowSelfSkip' => 'boolean',
        'SLADays' => 'integer',
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function rule(): BelongsTo
    {
        return $this->belongsTo(WfApprovalRule::class, 'ApprovalRuleID', 'ApprovalRuleID');
    }
}
