<?php

namespace App\Imports\Workflow;

class WfProcessDeptImport extends BaseWorkflowSheetImport
{
    protected function columns(): array
    {
        return [
            'processid',
            'deptid',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ];
    }
}
