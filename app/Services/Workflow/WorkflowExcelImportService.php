<?php

namespace App\Services\Workflow;

use App\Imports\Workflow\WorkflowMasterImport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RuntimeException;

class WorkflowExcelImportService
{
    public function __construct(
        protected WorkflowExcelValidator $validator
    ) {
    }

    public function import(
        string $file,
        ?int $importUserId = null
    ): array {
        /*
         * 1. Validate Excel terlebih dahulu.
         */
        $validation = $this->validator->validate($file);

        if (!empty($validation['errors'])) {
            throw new RuntimeException(
                implode("\n", $validation['errors'])
            );
        }

        /*
         * 2. Read seluruh sheet.
         */
        $import = new WorkflowMasterImport();

        Excel::import($import, $file);

        $rows = [];

        foreach ($import->getImports() as $sheetName => $sheetImport) {
            $rows[$sheetName] = $sheetImport->getRows();
        }

        /*
         * 3. Import menggunakan transaction database.
         */
        DB::beginTransaction();

        try {
            /*
             * ---------------------------------------------------------
             * 3A. Wf_Process
             * ---------------------------------------------------------
             */
            $processRows = $this->prepareRows(
                $rows['Wf_Process'],
                $importUserId
            );

            DB::table('wf_process')->delete();

            foreach ($processRows as $row) {
                DB::table('wf_process')->insert($row);
            }

            /*
             * ---------------------------------------------------------
             * 3B. Wf_ProcessDept
             * ---------------------------------------------------------
             */
            $processDeptRows = $this->prepareRows(
                $rows['Wf_ProcessDept'],
                $importUserId
            );

            DB::table('wf_process_dept')->delete();

            foreach ($processDeptRows as $row) {
                DB::table('wf_process_dept')->insert($row);
            }

            /*
             * ---------------------------------------------------------
             * 3C. Wf_Group
             * ---------------------------------------------------------
             */
            $groupRows = $this->prepareRows(
                $rows['Wf_Group'],
                $importUserId
            );

            DB::table('wf_group')->delete();

            foreach ($groupRows as $row) {
                DB::table('wf_group')->insert($row);
            }

            /*
             * ---------------------------------------------------------
             * 3D. Wf_GroupMember
             * ---------------------------------------------------------
             */
            $groupMemberRows = $this->prepareRows(
                $rows['Wf_GroupMember'],
                $importUserId
            );

            DB::table('wf_group_member')->delete();

            foreach ($groupMemberRows as $row) {
                DB::table('wf_group_member')->insert($row);
            }

            /*
             * ---------------------------------------------------------
             * 3E. Wf_Action
             * ---------------------------------------------------------
             */
            $actionRows = $this->prepareRows(
                $rows['Wf_Action'],
                $importUserId
            );

            DB::table('wf_action')->delete();

            foreach ($actionRows as $row) {
                DB::table('wf_action')->insert($row);
            }

            /*
             * ---------------------------------------------------------
             * 3F. Wf_ActionTarget
             * ---------------------------------------------------------
             */
            $actionTargetRows = $this->prepareRows(
                $rows['Wf_ActionTarget'],
                $importUserId
            );

            DB::table('wf_action_target')->delete();

            foreach ($actionTargetRows as $row) {
                DB::table('wf_action_target')->insert($row);
            }

            /*
             * ---------------------------------------------------------
             * 3G. Wf_State
             * ---------------------------------------------------------
             */
            $stateRows = $this->prepareRows(
                $rows['Wf_State'],
                $importUserId
            );

            DB::table('wf_state')->delete();

            foreach ($stateRows as $row) {
                DB::table('wf_state')->insert($row);
            }

            /*
             * ---------------------------------------------------------
             * 3H. Wf_Transition
             * ---------------------------------------------------------
             */
            $transitionRows = $this->prepareRows(
                $rows['Wf_Transition'],
                $importUserId
            );

            DB::table('wf_transition')->delete();

            foreach ($transitionRows as $row) {
                DB::table('wf_transition')->insert($row);
            }

            /*
             * ---------------------------------------------------------
             * 3I. Wf_TransAction
             * ---------------------------------------------------------
             *
             * TransitionID di Excel merupakan:
             *
             * CurrentStateID + NextStateID
             */
            $transActionRows = $this->prepareTransActionRows(
                $rows['Wf_TransAction'],
                $importUserId
            );

            DB::table('wf_trans_action')->delete();

            foreach ($transActionRows as $row) {
                DB::table('wf_trans_action')->insert($row);
            }

            DB::commit();

            return [
                'summary' => [
                    'Wf_Process'      => $processRows->count(),
                    'Wf_ProcessDept'  => $processDeptRows->count(),
                    'Wf_Group'        => $groupRows->count(),
                    'Wf_GroupMember'  => $groupMemberRows->count(),
                    'Wf_Action'       => $actionRows->count(),
                    'Wf_ActionTarget' => $actionTargetRows->count(),
                    'Wf_State'        => $stateRows->count(),
                    'Wf_Transition'   => $transitionRows->count(),
                    'Wf_TransAction'  => $transActionRows->count(),
                ],
            ];
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Prepare standard workflow rows.
     */
    protected function prepareRows(
        Collection $rows,
        ?int $importUserId = null
    ): Collection {
        return $rows->map(function ($row) use ($importUserId) {

            $row = collect($row)->toArray();

            /*
             * ---------------------------------------------------------
             * InputDate
             * ---------------------------------------------------------
             *
             * Jika Excel kosong:
             * gunakan waktu saat import.
             */
            $inputDate = $this->normalizeDate(
                $row['inputdate'] ?? null
            );

            $row['inputdate'] = $inputDate ?? now();

            /*
             * ---------------------------------------------------------
             * ModifDate
             * ---------------------------------------------------------
             *
             * Jika Excel kosong:
             * gunakan waktu saat import.
             */
            $modifDate = $this->normalizeDate(
                $row['modifdate'] ?? null
            );

            $row['modifdate'] = $modifDate ?? now();

            /*
             * ---------------------------------------------------------
             * InputUser
             * ---------------------------------------------------------
             */
            if (array_key_exists('inputuser', $row)) {
                $row['inputuser'] = $this->resolveUserId(
                    $row['inputuser'] ?? null,
                    $importUserId
                );
            }

            /*
             * ---------------------------------------------------------
             * ModifUser
             * ---------------------------------------------------------
             */
            if (array_key_exists('modifuser', $row)) {
                $row['modifuser'] = $this->resolveUserId(
                    $row['modifuser'] ?? null,
                    $importUserId
                );
            }

            /*
             * ---------------------------------------------------------
             * Boolean fields
             * ---------------------------------------------------------
             */
            foreach ([
                'isactive',
                'isdefault',
            ] as $field) {

                if (array_key_exists($field, $row)) {
                    $row[$field] = $this->normalizeBoolean(
                        $row[$field]
                    );
                }
            }

            /*
             * ---------------------------------------------------------
             * Decimal fields
             * ---------------------------------------------------------
             */
            foreach ([
                'limitmin',
                'limitmax',
            ] as $field) {

                if (array_key_exists($field, $row)) {
                    $row[$field] = $this->normalizeDecimal(
                        $row[$field]
                    );
                }
            }

            /*
             * ---------------------------------------------------------
             * Integer fields
             * ---------------------------------------------------------
             */
            foreach ([
                'sladays',
                'actiontypeid',
                'statetypeid',
            ] as $field) {

                if (
                    array_key_exists($field, $row)
                    && $row[$field] !== null
                    && $row[$field] !== ''
                ) {
                    $row[$field] = (int) $row[$field];
                }
            }

            return $row;
        });
    }

    /**
     * Prepare Wf_TransAction.
     */
    protected function prepareTransActionRows(
        Collection $rows,
        ?int $importUserId = null
    ): Collection {
        return $rows->map(function ($row) use ($importUserId) {

            $row = collect($row)->toArray();

            /*
             * TransitionID tetap menggunakan nilai dari Excel.
             *
             * Contoh:
             *
             * HCR032301.1HCR032301.2
             */
            $row['transitionid'] = trim(
                (string) ($row['transitionid'] ?? '')
            );

            /*
             * InputDate
             */
            $inputDate = $this->normalizeDate(
                $row['inputdate'] ?? null
            );

            $row['inputdate'] = $inputDate ?? now();

            /*
             * ModifDate
             */
            $modifDate = $this->normalizeDate(
                $row['modifdate'] ?? null
            );

            $row['modifdate'] = $modifDate ?? now();

            /*
             * InputUser
             */
            if (array_key_exists('inputuser', $row)) {
                $row['inputuser'] = $this->resolveUserId(
                    $row['inputuser'] ?? null,
                    $importUserId
                );
            }

            /*
             * ModifUser
             */
            if (array_key_exists('modifuser', $row)) {
                $row['modifuser'] = $this->resolveUserId(
                    $row['modifuser'] ?? null,
                    $importUserId
                );
            }

            return $row;
        });
    }

    /**
     * Resolve Excel user value menjadi UserID.
     */
    protected function resolveUserId(
        mixed $value,
        ?int $importUserId = null
    ): mixed {
        /*
         * Kalau Excel kosong, gunakan user yang melakukan import
         * jika tersedia.
         */
        if ($value === null || trim((string) $value) === '') {
            return $importUserId;
        }

        $value = trim((string) $value);

        /*
         * Kalau sudah berupa UserID numerik.
         */
        if (ctype_digit($value)) {
            $user = DB::table('sc_user')
                ->where('UserID', (int) $value)
                ->first();

            if ($user) {
                return $user->UserID;
            }
        }

        /*
         * Cari berdasarkan Username.
         */
        $user = DB::table('sc_user')
            ->where('Username', $value)
            ->first();

        if ($user) {
            return $user->UserID;
        }

        /*
         * Cari berdasarkan FullName.
         */
        $user = DB::table('sc_user')
            ->where('FullName', $value)
            ->first();

        if ($user) {
            return $user->UserID;
        }

        /*
         * Fallback case-insensitive Username.
         */
        $user = DB::table('sc_user')
            ->whereRaw(
                'LOWER(Username) = ?',
                [strtolower($value)]
            )
            ->first();

        if ($user) {
            return $user->UserID;
        }

        throw new RuntimeException(
            "User '{$value}' dari Excel tidak ditemukan di sc_user."
        );
    }

    /**
     * Normalize Excel boolean value.
     */
    protected function normalizeBoolean(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if ($value === null || $value === '') {
            return false;
        }

        if (is_numeric($value)) {
            return (bool) ((int) $value);
        }

        return in_array(
            strtolower(trim((string) $value)),
            [
                'true',
                'yes',
                'y',
                '1',
                'aktif',
                'active',
            ],
            true
        );
    }

    /**
     * Normalize decimal value.
     */
    protected function normalizeDecimal(mixed $value): ?float
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $value = str_replace(',', '.', (string) $value);

        return is_numeric($value)
            ? (float) $value
            : null;
    }

    /**
     * Normalize Excel date value.
     */
    protected function normalizeDate(mixed $value): mixed
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        /*
         * Kalau sudah berupa Carbon/DateTime.
         */
        if ($value instanceof \DateTimeInterface) {
            return $value;
        }

        /*
         * Excel serial date.
         */
        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                    (float) $value
                );
            } catch (\Throwable) {
                return null;
            }
        }

        /*
         * Date string.
         */
        try {
            return \Carbon\Carbon::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }
}
