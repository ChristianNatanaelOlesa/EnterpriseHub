<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\Security\ScUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WfInstanceRevision extends BaseModel
{
    protected $table = 'wf_instance_revision';
    protected $primaryKey = 'WorkflowRevisionID';

    protected $fillable = [
        'WorkflowInstanceID', 'RevisionNo', 'RequestedByUserID', 'RequestedAt',
        'RevisionTargetType', 'RevisionTargetUserID', 'RevisionStepNo', 'Reason',
        'ResolvedAt', 'InputDate', 'InputUser', 'ModifDate', 'ModifUser',
    ];

    protected $casts = [
        'RevisionNo' => 'integer',
        'RequestedAt' => 'datetime',
        'RevisionStepNo' => 'integer',
        'ResolvedAt' => 'datetime',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(WfInstance::class, 'WorkflowInstanceID', 'WorkflowInstanceID');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(ScUser::class, 'RequestedByUserID', 'UserID');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(ScUser::class, 'RevisionTargetUserID', 'UserID');
    }
}
