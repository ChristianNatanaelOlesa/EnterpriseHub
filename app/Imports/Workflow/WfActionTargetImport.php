<?php

namespace App\Imports\Workflow;

class WfActionTargetImport extends BaseWorkflowSheetImport
{
    protected function columns(): array
    {
        return [
            'actiontargetid',
            'actionid',
            'targetid',
            'groupid',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ];
    }
}
