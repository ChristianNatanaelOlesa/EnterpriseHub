<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\Security\ScUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WfInstanceStep extends BaseModel
{
    protected $table = 'wf_instance_step';
    protected $primaryKey = 'WorkflowInstanceStepID';

    protected $fillable = [
        'WorkflowInstanceID', 'ApprovalStepID', 'RevisionNo', 'StepNo', 'StepCode',
        'StepName', 'ResolverType', 'ResolverConfig', 'ApproverUserID', 'ApproverEmpFormID',
        'Status', 'Action', 'Comments', 'DueDate', 'StartedAt', 'CompletedAt',
        'IsSkipped', 'SkipReason', 'InputDate', 'InputUser', 'ModifDate', 'ModifUser',
    ];

    protected $casts = [
        'RevisionNo' => 'integer',
        'StepNo' => 'integer',
        'ResolverConfig' => 'array',
        'DueDate' => 'datetime',
        'StartedAt' => 'datetime',
        'CompletedAt' => 'datetime',
        'IsSkipped' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(WfInstance::class, 'WorkflowInstanceID', 'WorkflowInstanceID');
    }

    public function approvalStep(): BelongsTo
    {
        return $this->belongsTo(WfApprovalStep::class, 'ApprovalStepID', 'ApprovalStepID');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(ScUser::class, 'ApproverUserID', 'UserID');
    }
}
