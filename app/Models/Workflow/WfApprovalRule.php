<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WfApprovalRule extends BaseModel
{
    protected $table = 'wf_approval_rule';
    protected $primaryKey = 'ApprovalRuleID';

    protected $fillable = [
        'ProcessID', 'RuleCode', 'RuleName', 'ConditionType', 'ConditionValue',
        'Priority', 'RevisionMode', 'EffectiveDate', 'IsActive',
        'InputDate', 'InputUser', 'ModifDate', 'ModifUser',
    ];

    protected $casts = [
        'Priority' => 'integer',
        'EffectiveDate' => 'date',
        'IsActive' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(WfProcess::class, 'ProcessID', 'ProcessID');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(WfApprovalStep::class, 'ApprovalRuleID', 'ApprovalRuleID')
            ->orderBy('StepNo');
    }
}
