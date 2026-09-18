<?php

namespace App\Imports\Workflow;

class WfGroupMemberImport extends BaseWorkflowSheetImport
{
    protected function columns(): array
    {
        return [
            'groupid',
            'userid',
            'isactive',
            'isdefault',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ];
    }
}
