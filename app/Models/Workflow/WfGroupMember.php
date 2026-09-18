<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;

class WfGroupMember extends BaseModel
{
    protected $table = 'wf_group_member';

    protected $primaryKey = 'GroupMemberID';

    protected $fillable = [
        'GroupID',
        'UserID',
        'IsActive',
        'IsDefault',
        'InputDate',
        'InputUser',
        'ModifDate',
        'ModifUser',
    ];

    protected $casts = [
        'GroupMemberID' => 'integer',
        'IsActive' => 'boolean',
        'IsDefault' => 'boolean',
        'InputDate' => 'datetime',
        'ModifDate' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(
            WfGroup::class,
            'GroupID',
            'GroupID'
        );
    }
}
