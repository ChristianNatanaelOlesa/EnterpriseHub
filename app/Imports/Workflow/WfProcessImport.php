<?php

namespace App\Imports\Workflow;

class WfProcessImport extends BaseWorkflowSheetImport
{
    protected function columns(): array
    {
        return [
            'processid',
            'process',
            'processdesc',
            'ccyid',
            'limitmin',
            'limitmax',
            'effectivedate',
            'sladays',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ];
    }
}
