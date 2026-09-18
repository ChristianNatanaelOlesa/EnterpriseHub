<?php

namespace App\Imports\Workflow;

class WfGroupImport extends BaseWorkflowSheetImport
{
    protected function columns(): array
    {
        return [
            'groupid',
            'processid',
            'groupname',
            'divid',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ];
    }
}
