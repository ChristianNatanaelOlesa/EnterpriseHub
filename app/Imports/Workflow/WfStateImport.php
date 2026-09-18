<?php

namespace App\Imports\Workflow;

class WfStateImport extends BaseWorkflowSheetImport
{
    protected function columns(): array
    {
        return [
            'stateid',
            'processid',
            'statetypeid',
            'statename',
            'statedesc',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ];
    }
}
