<?php

namespace App\Imports\Workflow;

class WfTransitionImport extends BaseWorkflowSheetImport
{
    protected function columns(): array
    {
        return [
            'processid',
            'currentstateid',
            'nextstateid',
            'transition',
            'sladays',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ];
    }
}
