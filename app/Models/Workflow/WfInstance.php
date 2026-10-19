<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\Security\ScUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class WfInstance extends BaseModel
{
    protected $table = 'wf_instance';
    protected $primaryKey = 'WorkflowInstanceID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted(): void
    {
        parent::booted();

        static::creating(function (self $model) {
            if (empty($model->WorkflowInstanceID)) {
                $model->WorkflowInstanceID = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'WorkflowInstanceID', 'ProcessID', 'ApprovalRuleID', 'Module', 'TransactionID',
        'RequesterUserID', 'RequesterEmpFormID', 'TargetEmpFormID', 'CurrentStepNo',
        'Status', 'RevisionNo', 'StartedAt', 'CompletedAt',
        'InputDate', 'InputUser', 'ModifDate', 'ModifUser',
    ];

    protected $casts = [
        'CurrentStepNo' => 'integer',
        'RevisionNo' => 'integer',
        'StartedAt' => 'datetime',
        'CompletedAt' => 'datetime',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(WfProcess::class, 'ProcessID', 'ProcessID');
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(WfApprovalRule::class, 'ApprovalRuleID', 'ApprovalRuleID');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(ScUser::class, 'RequesterUserID', 'UserID');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(WfInstanceStep::class, 'WorkflowInstanceID', 'WorkflowInstanceID')
            ->orderBy('RevisionNo')
            ->orderBy('StepNo');
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(WfInstanceRevision::class, 'WorkflowInstanceID', 'WorkflowInstanceID')
            ->orderBy('RevisionNo');
    }
}
