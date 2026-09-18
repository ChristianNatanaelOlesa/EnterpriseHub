<?php

namespace App\Imports\Workflow;

class WfTransActionImport extends BaseWorkflowSheetImport
{
    protected function columns(): array
    {
        return [
            'transitionid',
            'actionid',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ];
    }
}
