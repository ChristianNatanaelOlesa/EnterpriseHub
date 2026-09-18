<?php

namespace App\Imports\Workflow;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WorkflowMasterImport implements WithMultipleSheets
{
    protected array $imports = [];

    public function __construct()
    {
        $this->imports = [
            'Wf_Process' => new WfProcessImport(),
            'Wf_ProcessDept' => new WfProcessDeptImport(),
            'Wf_Group' => new WfGroupImport(),
            'Wf_GroupMember' => new WfGroupMemberImport(),
            'Wf_Action' => new WfActionImport(),
            'Wf_ActionTarget' => new WfActionTargetImport(),
            'Wf_State' => new WfStateImport(),
            'Wf_Transition' => new WfTransitionImport(),
            'Wf_TransAction' => new WfTransActionImport(),
        ];
    }

    public function sheets(): array
    {
        return $this->imports;
    }

    public function sheet(string $sheetName): BaseWorkflowSheetImport
    {
        if (!isset($this->imports[$sheetName])) {
            throw new \InvalidArgumentException(
                "Workflow sheet '{$sheetName}' tidak ditemukan."
            );
        }

        return $this->imports[$sheetName];
    }

    public function getImports(): array
    {
        return $this->imports;
    }
}
