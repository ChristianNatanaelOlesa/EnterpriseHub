<?php

namespace App\Imports\Workflow;

class WfActionImport extends BaseWorkflowSheetImport
{
    protected function columns(): array
    {
        return [
            'actionid',
            'processid',
            'actiontypeid',
            'action',
            'actiondesc',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ];
    }
}
