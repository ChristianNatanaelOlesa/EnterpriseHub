<?php

namespace App\Services\Workflow;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkflowExcelValidator
{
    protected array $requiredSheets = [
        'Wf_Process',
        'Wf_ProcessDept',
        'Wf_Group',
        'Wf_GroupMember',
        'Wf_Action',
        'Wf_ActionTarget',
        'Wf_State',
        'Wf_Transition',
        'Wf_TransAction',
    ];

    protected array $requiredColumns = [
        'Wf_Process' => [
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
        ],

        'Wf_ProcessDept' => [
            'processid',
            'deptid',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ],

        'Wf_Group' => [
            'groupid',
            'processid',
            'groupname',
            'divid',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ],

        'Wf_GroupMember' => [
            'groupid',
            'userid',
            'isactive',
            'isdefault',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ],

        'Wf_Action' => [
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
        ],

        'Wf_ActionTarget' => [
            'actiontargetid',
            'actionid',
            'targetid',
            'groupid',
            'isactive',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ],

        'Wf_State' => [
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
        ],

        'Wf_Transition' => [
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
        ],

        'Wf_TransAction' => [
            'transitionid',
            'actionid',
            'inputdate',
            'inputuser',
            'modifdate',
            'modifuser',
        ],
    ];

    public function validate(string $file): array
    {
        $errors = [];
        $warnings = [];
        $summary = [];

        if (!file_exists($file)) {
            return [
                'summary' => [],
                'warnings' => [],
                'errors' => [
                    "File tidak ditemukan: {$file}",
                ],
            ];
        }

        try {
            $spreadsheet = IOFactory::load($file);
        } catch (\Throwable $e) {
            return [
                'summary' => [],
                'warnings' => [],
                'errors' => [
                    'File Excel tidak dapat dibaca: ' . $e->getMessage(),
                ],
            ];
        }

        /*
         * ============================================================
         * 1. VALIDATE SHEETS
         * ============================================================
         */
        foreach ($this->requiredSheets as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);

            if (!$sheet) {
                $errors[] = "Sheet '{$sheetName}' tidak ditemukan.";
                continue;
            }

            $summary[$sheetName] = [
                'rows' => max(0, $sheet->getHighestDataRow() - 1),
            ];
        }

        if (!empty($errors)) {
            return [
                'summary' => $summary,
                'warnings' => $warnings,
                'errors' => $errors,
            ];
        }

        /*
         * ============================================================
         * 2. VALIDATE COLUMNS
         * ============================================================
         */
        foreach ($this->requiredColumns as $sheetName => $columns) {
            $sheet = $spreadsheet->getSheetByName($sheetName);

            $headers = $this->getHeaders($sheet);

            foreach ($columns as $column) {
                if (!in_array($column, $headers, true)) {
                    $errors[] = "Sheet '{$sheetName}' tidak memiliki kolom '{$column}'.";
                }
            }
        }

        if (!empty($errors)) {
            return [
                'summary' => $summary,
                'warnings' => $warnings,
                'errors' => $errors,
            ];
        }

        /*
         * ============================================================
         * 3. DUPLICATE VALIDATION
         * ============================================================
         */

        // Wf_Process
        $this->validateDuplicates(
            $spreadsheet,
            'Wf_Process',
            ['processid'],
            $errors
        );

        // Wf_ProcessDept
        $this->validateDuplicates(
            $spreadsheet,
            'Wf_ProcessDept',
            ['processid', 'deptid'],
            $errors
        );

        // Wf_Group
        $this->validateDuplicates(
            $spreadsheet,
            'Wf_Group',
            ['groupid'],
            $errors
        );

        // Wf_GroupMember
        $this->validateDuplicates(
            $spreadsheet,
            'Wf_GroupMember',
            ['groupid', 'userid'],
            $errors
        );

        // Wf_Action
        $this->validateDuplicates(
            $spreadsheet,
            'Wf_Action',
            ['actionid'],
            $errors
        );

        // Wf_ActionTarget
        $this->validateDuplicates(
            $spreadsheet,
            'Wf_ActionTarget',
            ['actiontargetid'],
            $errors
        );

        // Wf_State
        $this->validateDuplicates(
            $spreadsheet,
            'Wf_State',
            ['stateid'],
            $errors
        );

        /*
         * Wf_Transition
         *
         * Transition adalah DESCRIPTION.
         *
         * Unique key:
         * ProcessID + CurrentStateID + NextStateID
         */
        $this->validateDuplicates(
            $spreadsheet,
            'Wf_Transition',
            [
                'processid',
                'currentstateid',
                'nextstateid',
            ],
            $errors
        );

        /*
         * Wf_TransAction
         *
         * TransitionID + ActionID
         */
        $this->validateDuplicates(
            $spreadsheet,
            'Wf_TransAction',
            [
                'transitionid',
                'actionid',
            ],
            $errors
        );

        /*
         * ============================================================
         * 4. FOREIGN KEY / REFERENCE VALIDATION
         * ============================================================
         */
        $this->validateForeignKeys(
            $spreadsheet,
            $errors
        );

        /*
         * ============================================================
         * 5. TRANSITION VALIDATION
         * ============================================================
         */
        $this->validateTransitionStructure(
            $spreadsheet,
            $errors
        );

        return [
            'summary' => $summary,
            'warnings' => $warnings,
            'errors' => $errors,
        ];
    }

    /*
     * ================================================================
     * HEADERS
     * ================================================================
     */

    protected function getHeaders(Worksheet $sheet): array
    {
        $headers = [];

        foreach ($sheet->getRowIterator(1, 1) as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $value = trim((string) $cell->getFormattedValue());

                if ($value !== '') {
                    $headers[] = strtolower($value);
                }
            }
        }

        return $headers;
    }

    protected function getHeaderMap(Worksheet $sheet): array
    {
        $map = [];

        foreach ($sheet->getRowIterator(1, 1) as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $value = trim((string) $cell->getFormattedValue());

                if ($value === '') {
                    continue;
                }

                $column = strtolower($value);

                if (!isset($map[$column])) {
                    $map[$column] = $cell->getColumn();
                }
            }
        }

        return $map;
    }

    /*
     * ================================================================
     * DUPLICATE VALIDATION
     * ================================================================
     */

    protected function validateDuplicates(
        $spreadsheet,
        string $sheetName,
        array $columns,
        array &$errors
    ): void {
        $sheet = $spreadsheet->getSheetByName($sheetName);

        if (!$sheet) {
            return;
        }

        $headerMap = $this->getHeaderMap($sheet);

        foreach ($columns as $column) {
            if (!isset($headerMap[$column])) {
                return;
            }
        }

        $seen = [];

        for (
            $rowNumber = 2;
            $rowNumber <= $sheet->getHighestDataRow();
            $rowNumber++
        ) {
            $values = [];

            foreach ($columns as $column) {
                $cell = $sheet->getCell(
                    $headerMap[$column] . $rowNumber
                );

                $values[] = trim(
                    (string) $cell->getFormattedValue()
                );
            }

            if (count(array_filter($values, fn ($value) => $value !== '')) === 0) {
                continue;
            }

            $key = implode('|', $values);

            if (isset($seen[$key])) {
                $errors[] = sprintf(
                    "Sheet '%s' memiliki duplicate key [%s] pada row %d dan row %d.",
                    $sheetName,
                    implode(', ', $values),
                    $seen[$key],
                    $rowNumber
                );

                continue;
            }

            $seen[$key] = $rowNumber;
        }
    }

    /*
     * ================================================================
     * FOREIGN KEY VALIDATION
     * ================================================================
     */

    protected function validateForeignKeys(
        $spreadsheet,
        array &$errors
    ): void {
        /*
         * ------------------------------------------------------------
         * Wf_ProcessDept -> Wf_Process
         * ------------------------------------------------------------
         */
        $processIds = $this->getColumnValues(
            $spreadsheet,
            'Wf_Process',
            'processid'
        );

        $this->checkReference(
            $spreadsheet,
            'Wf_ProcessDept',
            'processid',
            $processIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_Group -> Wf_Process
         * ------------------------------------------------------------
         */
        $this->checkReference(
            $spreadsheet,
            'Wf_Group',
            'processid',
            $processIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_GroupMember -> Wf_Group
         * ------------------------------------------------------------
         */
        $groupIds = $this->getColumnValues(
            $spreadsheet,
            'Wf_Group',
            'groupid'
        );

        $this->checkReference(
            $spreadsheet,
            'Wf_GroupMember',
            'groupid',
            $groupIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_Action -> Wf_Process
         * ------------------------------------------------------------
         */
        $this->checkReference(
            $spreadsheet,
            'Wf_Action',
            'processid',
            $processIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_ActionTarget -> Wf_Action
         * ------------------------------------------------------------
         */
        $actionIds = $this->getColumnValues(
            $spreadsheet,
            'Wf_Action',
            'actionid'
        );

        $this->checkReference(
            $spreadsheet,
            'Wf_ActionTarget',
            'actionid',
            $actionIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_ActionTarget -> Wf_Group
         * ------------------------------------------------------------
         */
        $this->checkReference(
            $spreadsheet,
            'Wf_ActionTarget',
            'groupid',
            $groupIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_State -> Wf_Process
         * ------------------------------------------------------------
         */
        $this->checkReference(
            $spreadsheet,
            'Wf_State',
            'processid',
            $processIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_Transition -> Wf_Process
         * ------------------------------------------------------------
         */
        $this->checkReference(
            $spreadsheet,
            'Wf_Transition',
            'processid',
            $processIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_Transition -> CurrentState / NextState
         * ------------------------------------------------------------
         */
        $stateIds = $this->getColumnValues(
            $spreadsheet,
            'Wf_State',
            'stateid'
        );

        $this->checkReference(
            $spreadsheet,
            'Wf_Transition',
            'currentstateid',
            $stateIds,
            $errors
        );

        $this->checkReference(
            $spreadsheet,
            'Wf_Transition',
            'nextstateid',
            $stateIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_TransAction -> Wf_Action
         * ------------------------------------------------------------
         */
        $this->checkReference(
            $spreadsheet,
            'Wf_TransAction',
            'actionid',
            $actionIds,
            $errors
        );

        /*
         * ------------------------------------------------------------
         * Wf_TransAction -> Derived TransitionID
         * ------------------------------------------------------------
         *
         * TransitionID bukan kolom langsung di Wf_Transition.
         *
         * Dibentuk dari:
         *
         * CurrentStateID + NextStateID
         * ------------------------------------------------------------
         */
        $transitionIds = $this->getTransitionIds(
            $spreadsheet
        );

        $this->checkReference(
            $spreadsheet,
            'Wf_TransAction',
            'transitionid',
            $transitionIds,
            $errors
        );
    }

    /*
     * ================================================================
     * GET TRANSITION IDS
     * ================================================================
     */

    protected function getTransitionIds($spreadsheet): array
    {
        $sheet = $spreadsheet->getSheetByName('Wf_Transition');

        if (!$sheet) {
            return [];
        }

        $headerMap = $this->getHeaderMap($sheet);

        $required = [
            'processid',
            'currentstateid',
            'nextstateid',
        ];

        foreach ($required as $column) {
            if (!isset($headerMap[$column])) {
                return [];
            }
        }

        $transitionIds = [];

        for (
            $rowNumber = 2;
            $rowNumber <= $sheet->getHighestDataRow();
            $rowNumber++
        ) {
            $processId = trim(
                (string) $sheet
                    ->getCell(
                        $headerMap['processid'] . $rowNumber
                    )
                    ->getFormattedValue()
            );

            $currentStateId = trim(
                (string) $sheet
                    ->getCell(
                        $headerMap['currentstateid'] . $rowNumber
                    )
                    ->getFormattedValue()
            );

            $nextStateId = trim(
                (string) $sheet
                    ->getCell(
                        $headerMap['nextstateid'] . $rowNumber
                    )
                    ->getFormattedValue()
            );

            if (
                $processId === '' ||
                $currentStateId === '' ||
                $nextStateId === ''
            ) {
                continue;
            }

            $transitionIds[] =
                $currentStateId . $nextStateId;
        }

        return array_values(
            array_unique($transitionIds)
        );
    }

    /*
     * ================================================================
     * TRANSITION STRUCTURE
     * ================================================================
     */

    protected function validateTransitionStructure(
        $spreadsheet,
        array &$errors
    ): void {
        $sheet = $spreadsheet->getSheetByName(
            'Wf_Transition'
        );

        if (!$sheet) {
            return;
        }

        $headerMap = $this->getHeaderMap($sheet);

        $required = [
            'processid',
            'currentstateid',
            'nextstateid',
            'transition',
        ];

        foreach ($required as $column) {
            if (!isset($headerMap[$column])) {
                return;
            }
        }

        for (
            $rowNumber = 2;
            $rowNumber <= $sheet->getHighestDataRow();
            $rowNumber++
        ) {
            $processId = trim(
                (string) $sheet
                    ->getCell(
                        $headerMap['processid'] . $rowNumber
                    )
                    ->getFormattedValue()
            );

            $currentStateId = trim(
                (string) $sheet
                    ->getCell(
                        $headerMap['currentstateid'] . $rowNumber
                    )
                    ->getFormattedValue()
            );

            $nextStateId = trim(
                (string) $sheet
                    ->getCell(
                        $headerMap['nextstateid'] . $rowNumber
                    )
                    ->getFormattedValue()
            );

            $transition = trim(
                (string) $sheet
                    ->getCell(
                        $headerMap['transition'] . $rowNumber
                    )
                    ->getFormattedValue()
            );

            if (
                $processId === '' &&
                $currentStateId === '' &&
                $nextStateId === '' &&
                $transition === ''
            ) {
                continue;
            }

            if ($currentStateId === $nextStateId) {
                $errors[] = sprintf(
                    "Sheet 'Wf_Transition' row %d memiliki CurrentStateID dan NextStateID yang sama: '%s'.",
                    $rowNumber,
                    $currentStateId
                );
            }

            if ($transition === '') {
                $errors[] = sprintf(
                    "Sheet 'Wf_Transition' row %d memiliki Transition description kosong.",
                    $rowNumber
                );
            }
        }
    }

    /*
     * ================================================================
     * COLUMN VALUES
     * ================================================================
     */

    protected function getColumnValues(
        $spreadsheet,
        string $sheetName,
        string $column
    ): array {
        $sheet = $spreadsheet->getSheetByName($sheetName);

        if (!$sheet) {
            return [];
        }

        $headerMap = $this->getHeaderMap($sheet);

        if (!isset($headerMap[$column])) {
            return [];
        }

        $values = [];

        for (
            $rowNumber = 2;
            $rowNumber <= $sheet->getHighestDataRow();
            $rowNumber++
        ) {
            $value = trim(
                (string) $sheet
                    ->getCell(
                        $headerMap[$column] . $rowNumber
                    )
                    ->getFormattedValue()
            );

            if ($value !== '') {
                $values[] = $value;
            }
        }

        return array_values(
            array_unique($values)
        );
    }

    /*
     * ================================================================
     * CHECK REFERENCE
     * ================================================================
     */

    protected function checkReference(
        $spreadsheet,
        string $sheetName,
        string $column,
        array $allowedValues,
        array &$errors
    ): void {
        $sheet = $spreadsheet->getSheetByName($sheetName);

        if (!$sheet) {
            return;
        }

        $headerMap = $this->getHeaderMap($sheet);

        if (!isset($headerMap[$column])) {
            return;
        }

        $allowedValues = array_flip($allowedValues);

        for (
            $rowNumber = 2;
            $rowNumber <= $sheet->getHighestDataRow();
            $rowNumber++
        ) {
            $value = trim(
                (string) $sheet
                    ->getCell(
                        $headerMap[$column] . $rowNumber
                    )
                    ->getFormattedValue()
            );

            if ($value === '') {
                continue;
            }

            if (!isset($allowedValues[$value])) {
                $errors[] = sprintf(
                    "Sheet '%s' row %d memiliki reference '%s' pada kolom '%s' yang tidak ditemukan.",
                    $sheetName,
                    $rowNumber,
                    $value,
                    $column
                );
            }
        }
    }
}
