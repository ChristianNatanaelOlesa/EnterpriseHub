<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpForm;
use App\Models\EForm\TrEmpFormHist;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeFormService
{
    public function create(
        array $data,
        string $inputUser
    ): TrEmpForm {
        return DB::transaction(function () use (
            $data,
            $inputUser
        ) {
            /*
            |--------------------------------------------------------------------------
            | Effective Date menjadi sumber periode Employee Form ID.
            |
            | Contoh:
            | Effective Date 2026-10-15
            | => EMP202610-001
            |--------------------------------------------------------------------------
            */

            $effectiveDate = Carbon::parse(
                $data['EffectiveDate']
            );

            $empFormId = $this->generateEmpFormId(
                $effectiveDate
            );

            /*
            |--------------------------------------------------------------------------
            | Join Date selalu sama dengan Effective Date.
            |--------------------------------------------------------------------------
            */

            $data['JoinDate'] = $effectiveDate->toDateString();

            /*
            |--------------------------------------------------------------------------
            | Request Date menggunakan tanggal saat transaction dibuat.
            |--------------------------------------------------------------------------
            */

            $requestDate = now();

            /*
            |--------------------------------------------------------------------------
            | Employee Form
            |--------------------------------------------------------------------------
            */

            $employeeForm = TrEmpForm::create([
                'EmpFormID' => $empFormId,

                'FirstName' => $data['FirstName'],

                'LastName' => $data['LastName'] ?? null,

                'MobileNo' => $data['MobileNo'],

                'BirthDate' => $data['BirthDate'],

                'NIP' => $data['NIP'],

                'MaritalStatus' => $data['MaritalStatus'],

                'ReligionID' => $data['ReligionID'],

                'JoinDate' => $data['JoinDate'],

                'VillageID' => $data['VillageID'],

                'Address' => $data['Address'],

                'Email' => $data['Email'],

                'InputUser' => $inputUser,

                'InputDate' => $requestDate,

                'ModifUser' => $inputUser,

                'ModifDate' => $requestDate,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Generate Employee Form History ID
            |--------------------------------------------------------------------------
            */

            $empFormHistId = $this->generateEmpFormHistId(
                $empFormId
            );

            /*
            |--------------------------------------------------------------------------
            | Employee Form History
            |--------------------------------------------------------------------------
            */

            TrEmpFormHist::create([
                'EmpFormHistID' => $empFormHistId,

                'EmpFormID' => $empFormId,

                'DirID' => $data['DirID'],

                'DivID' => $data['DivID'],

                'DeptID' => $data['DeptID'],

                'JobLvlID' => $data['JobLvlID'],

                'JobTitleID' => $data['JobTitleID'],

                'ReportTo' => $data['ReportTo'] ?? null,

                /*
                |--------------------------------------------------------------------------
                | Employee Status
                |--------------------------------------------------------------------------
                | NEW / MUTATION / RESIGN
                | Default: NEW
                |--------------------------------------------------------------------------
                */

                'EmpStatus' => $data['EmpStatus'] ?? 'NEW',

                'EffectiveDate' => $data['EffectiveDate'],

                'Remarks' => $data['Remarks'],

                /*
                |--------------------------------------------------------------------------
                | Request information
                |--------------------------------------------------------------------------
                */


                'ReqDate' => $requestDate,

                /*
                |--------------------------------------------------------------------------
                | Transaction status
                |--------------------------------------------------------------------------
                */

                'IsActive' => true,

                'Status' => 'DRAFT',

                /*
                |--------------------------------------------------------------------------
                | Audit
                |--------------------------------------------------------------------------
                */

                'InputUser' => $inputUser,

                'InputDate' => $requestDate,

                'ModifUser' => $inputUser,

                'ModifDate' => $requestDate,
            ]);

            return $employeeForm->fresh([
                'histories',
            ]);
        });
    }

    public function update(
        string $empFormId,
        array $data,
        string $modifUser
    ): TrEmpForm {
        return DB::transaction(function () use (
            $empFormId,
            $data,
            $modifUser
        ) {
            /*
            |--------------------------------------------------------------------------
            | Get Employee Form
            |--------------------------------------------------------------------------
            */

            $employeeForm = TrEmpForm::query()
                ->where(
                    'EmpFormID',
                    $empFormId
                )
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Get latest Employee Form History
            |--------------------------------------------------------------------------
            */

            $history = TrEmpFormHist::query()
                ->where(
                    'EmpFormID',
                    $empFormId
                )
                ->orderByDesc('EffectiveDate')
                ->orderByDesc('EmpFormHistID')
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Effective Date bersifat immutable setelah Employee Form dibuat.
            |
            | Join Date tetap mengikuti Effective Date awal.
            |--------------------------------------------------------------------------
            */

            $effectiveDate = Carbon::parse(
                $history->EffectiveDate
            );

            $data['JoinDate'] = $effectiveDate->toDateString();

            /*
            |--------------------------------------------------------------------------
            | Update Employee Form
            |--------------------------------------------------------------------------
            */

            $employeeForm->update([
                'FirstName' => $data['FirstName'],

                'LastName' => $data['LastName'] ?? null,

                'MobileNo' => $data['MobileNo'],

                'BirthDate' => $data['BirthDate'],

                'NIP' => $data['NIP'],

                'MaritalStatus' => $data['MaritalStatus'],

                'ReligionID' => $data['ReligionID'],

                'JoinDate' => $data['JoinDate'],

                'VillageID' => $data['VillageID'],

                'Address' => $data['Address'],

                'Email' => $data['Email'],

                'ModifUser' => $modifUser,

                'ModifDate' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update Employee Form History
            |--------------------------------------------------------------------------
            */

            $history->update([
                'DirID' => $data['DirID'],

                'DivID' => $data['DivID'],

                'DeptID' => $data['DeptID'],

                'JobLvlID' => $data['JobLvlID'],

                'JobTitleID' => $data['JobTitleID'],

                'ReportTo' => $data['ReportTo'] ?? null,

                /*
                |--------------------------------------------------------------------------
                | Jangan hardcode NEW.
                |
                | Bisa:
                | NEW
                | MUTATION
                | RESIGN
                |--------------------------------------------------------------------------
                */

                'EmpStatus' => $data['EmpStatus']
                    ?? $history->EmpStatus,

                'Remarks' => $data['Remarks'],

                /*
                |--------------------------------------------------------------------------
                | Request User tetap user pertama yang membuat request.
                |--------------------------------------------------------------------------
                */


                /*
                |--------------------------------------------------------------------------
                | Request Date tidak diubah ketika Update.
                |--------------------------------------------------------------------------
                */

                'ModifUser' => $modifUser,

                'ModifDate' => now(),
            ]);

            return $employeeForm->fresh([
                'histories',
            ]);
        });
    }

    public function delete(
        string $empFormId
    ): void {
        DB::transaction(function () use (
            $empFormId
        ) {
            $employeeForm = TrEmpForm::query()
                ->where(
                    'EmpFormID',
                    $empFormId
                )
                ->firstOrFail();

            TrEmpFormHist::query()
                ->where(
                    'EmpFormID',
                    $empFormId
                )
                ->delete();

            $employeeForm->delete();
        });
    }

    private function generateEmpFormId(
        Carbon $effectiveDate
    ): string {
        $prefix = 'EMP'
            . $effectiveDate->format('Ym')
            . '-';

        $existingIds = TrEmpForm::query()
            ->where(
                'EmpFormID',
                'like',
                $prefix . '%'
            )
            ->lockForUpdate()
            ->pluck('EmpFormID');

        $lastNumber = 0;

        foreach ($existingIds as $existingId) {
            if (
                preg_match(
                    '/^EMP\d{6}-(\d{3})$/',
                    trim($existingId),
                    $matches
                )
            ) {
                $number = (int) $matches[1];

                if ($number > $lastNumber) {
                    $lastNumber = $number;
                }
            }
        }

        return $prefix . str_pad(
            (string) ($lastNumber + 1),
            3,
            '0',
            STR_PAD_LEFT
        );
    }

    private function generateEmpFormHistId(
        string $empFormId
    ): string {
        $existingIds = TrEmpFormHist::query()
            ->where(
                'EmpFormID',
                $empFormId
            )
            ->lockForUpdate()
            ->pluck('EmpFormHistID');

        $lastNumber = 0;

        foreach ($existingIds as $existingId) {
            if (
                preg_match(
                    '/^'
                    . preg_quote($empFormId, '/')
                    . 'H(\d{2})$/',
                    trim($existingId),
                    $matches
                )
            ) {
                $number = (int) $matches[1];

                if ($number > $lastNumber) {
                    $lastNumber = $number;
                }
            }
        }

        return $empFormId
            . 'H'
            . str_pad(
                (string) ($lastNumber + 1),
                2,
                '0',
                STR_PAD_LEFT
            );
    }
}
