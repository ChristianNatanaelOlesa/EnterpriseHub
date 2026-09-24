<?php

namespace App\Services\EForm;

use App\Models\EForm\TrEmpForm;
use App\Models\EForm\TrEmpFormHist;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeFormService
{
    public function create(array $data, string $inputUser): TrEmpForm
    {
        return DB::transaction(function () use ($data, $inputUser) {
            /*
            |------------------------------------------------------------------
            | Effective Date menjadi sumber periode Employee Form ID.
            | Contoh: Effective Date 2026-10-15
            |         => EMP202610-001
            |------------------------------------------------------------------
            */
            $effectiveDate = Carbon::parse($data['EffectiveDate']);

            $empFormId = $this->generateEmpFormId($effectiveDate);

            /*
            |------------------------------------------------------------------
            | Join Date selalu sama dengan Effective Date.
            | Tidak lagi bergantung pada input terpisah dari user.
            |------------------------------------------------------------------
            */
            $data['JoinDate'] = $effectiveDate->toDateString();

            $now = now();

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
                'InputDate' => $now,
                'ModifUser' => $inputUser,
                'ModifDate' => $now,
            ]);

            $empFormHistId = $this->generateEmpFormHistId(
                $empFormId
            );

            TrEmpFormHist::create([
                'EmpFormHistID' => $empFormHistId,
                'EmpFormID' => $empFormId,
                'DirID' => $data['DirID'],
                'DivID' => $data['DivID'],
                'DeptID' => $data['DeptID'],
                'JobLvlID' => $data['JobLvlID'],
                'JobTitleID' => $data['JobTitleID'],
                'ReportTo' => $data['ReportTo'] ?? null,
                'EmpStatus' => 'NEW',
                'EffectiveDate' => $data['EffectiveDate'],
                'Remarks' => $data['Remarks'],
                'ReqUser' => $inputUser,
                'ReqDate' => $data['EffectiveDate'],
                'IsActive' => true,
                'InputUser' => $inputUser,
                'InputDate' => $now,
                'ModifUser' => $inputUser,
                'ModifDate' => $now,
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
            $employeeForm = TrEmpForm::query()
                ->where('EmpFormID', $empFormId)
                ->firstOrFail();

            $history = TrEmpFormHist::query()
                ->where('EmpFormID', $empFormId)
                ->orderByDesc('EffectiveDate')
                ->orderByDesc('EmpFormHistID')
                ->firstOrFail();

            /*
            |------------------------------------------------------------------
            | Effective Date bersifat immutable setelah Employee Form dibuat.
            | Join Date juga tetap mengikuti Effective Date awal.
            |------------------------------------------------------------------
            */
            $effectiveDate = Carbon::parse($history->EffectiveDate);
            $data['JoinDate'] = $effectiveDate->toDateString();

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

            $history->update([
                'DirID' => $data['DirID'],
                'DivID' => $data['DivID'],
                'DeptID' => $data['DeptID'],
                'JobLvlID' => $data['JobLvlID'],
                'JobTitleID' => $data['JobTitleID'],
                'ReportTo' => $data['ReportTo'] ?? null,
                'EmpStatus' => 'NEW',
                'Remarks' => $data['Remarks'],
                'ReqUser' => $history->ReqUser ?: $modifUser,
                'ModifUser' => $modifUser,
                'ModifDate' => now(),
            ]);

            return $employeeForm->fresh([
                'histories',
            ]);
        });
    }

    public function delete(string $empFormId): void
    {
        DB::transaction(function () use ($empFormId) {
            $employeeForm = TrEmpForm::query()
                ->where('EmpFormID', $empFormId)
                ->firstOrFail();

            TrEmpFormHist::query()
                ->where('EmpFormID', $empFormId)
                ->delete();

            $employeeForm->delete();
        });
    }

    private function generateEmpFormId(Carbon $effectiveDate): string
    {
        $prefix = 'EMP' . $effectiveDate->format('Ym') . '-';

        $existingIds = TrEmpForm::query()
            ->where('EmpFormID', 'like', $prefix . '%')
            ->lockForUpdate()
            ->pluck('EmpFormID');

        $lastNumber = 0;

        foreach ($existingIds as $existingId) {
            if (preg_match(
                '/^EMP\d{6}-(\d{3})$/',
                trim($existingId),
                $matches
            )) {
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
            ->where('EmpFormID', $empFormId)
            ->lockForUpdate()
            ->pluck('EmpFormHistID');

        $lastNumber = 0;

        foreach ($existingIds as $existingId) {
            if (preg_match(
                '/^' . preg_quote($empFormId, '/') . 'H(\d{2})$/',
                trim($existingId),
                $matches
            )) {
                $number = (int) $matches[1];

                if ($number > $lastNumber) {
                    $lastNumber = $number;
                }
            }
        }

        return $empFormId . 'H' . str_pad(
            (string) ($lastNumber + 1),
            2,
            '0',
            STR_PAD_LEFT
        );
    }
}
