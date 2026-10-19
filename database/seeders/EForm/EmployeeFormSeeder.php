<?php

namespace Database\Seeders\EForm;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class EmployeeFormSeeder extends Seeder
{
    /** @var array<string, bool> */
    private array $usedFullNames = [];

    /**
     * Creates test Employee Form records and their matching operational accounts.
     * Employee Form and Sc_User are linked through EmpFormID and matching email.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $now = now();
            $religionId = $this->religionId();
            $villageId = $this->villageId();

            $directorLevelId = $this->levelId([
                'Sr. General Manager', 'General Manager', 'Director', 'Manager',
            ]);
            $divisionLevelId = $this->levelId([
                'Sr. General Manager', 'General Manager', 'Manager', 'Asst. Manager',
            ]);
            $departmentLevelId = $this->levelId([
                'Supervisor', 'Manager', 'Asst. Manager',
            ]);
            $staffLevelId = $this->levelId([
                'Staff', 'Sr. Staff', 'Jr. Staff',
            ]);

            $this->ensureAdministratorEmployeeForm($religionId, $villageId, $now);

            $sequence = $this->nextSequence($now->format('Ym'));
            $directorates = DB::table('ms_directorate')
                ->where('IsActive', 1)
                ->whereNull('DeletedDate')
                ->orderBy('DirID')
                ->get();

            foreach ($directorates as $directorate) {
                $effectiveDate = $this->effectiveDate($now, $sequence);
                $director = $this->employee(
                    role: 'DIRECTOR',
                    username: 'direksi.' . strtolower($directorate->DirID),
                    fullName: 'Direksi - ' . $directorate->Directorate,
                    directorateId: (string) $directorate->DirID,
                    divisionId: null,
                    departmentId: null,
                    jobLevelId: $directorLevelId,
                    jobTitleId: $this->titleId('Director of ' . $directorate->Directorate),
                    reportTo: null,
                    religionId: $religionId,
                    villageId: $villageId,
                    sequence: $sequence,
                    effectiveDate: $effectiveDate,
                    now: $now,
                );
                $sequence++;

                $divisions = DB::table('ms_division')
                    ->where('DirID', $directorate->DirID)
                    ->where('IsActive', 1)
                    ->whereNull('DeletedDate')
                    ->orderBy('DivID')
                    ->get();

                foreach ($divisions as $division) {
                    $effectiveDate = $this->effectiveDate($now, $sequence);
                    $headDivision = $this->employee(
                        role: 'HEAD_DIVISION',
                        username: 'kadiv.' . strtolower($division->DivID),
                        fullName: 'Kepala Divisi - ' . $division->Division,
                        directorateId: (string) $directorate->DirID,
                        divisionId: (string) $division->DivID,
                        departmentId: null,
                        jobLevelId: $divisionLevelId,
                        jobTitleId: $this->titleId('Head of ' . $division->Division . ' Division'),
                        reportTo: $director['user_id'],
                        religionId: $religionId,
                        villageId: $villageId,
                        sequence: $sequence,
                        effectiveDate: $effectiveDate,
                        now: $now,
                    );
                    $sequence++;

                    $departments = DB::table('ms_department')
                        ->where('DivID', $division->DivID)
                        ->where('IsActive', 1)
                        ->whereNull('DeletedDate')
                        ->orderBy('DeptID')
                        ->get();

                    foreach ($departments as $department) {
                        $effectiveDate = $this->effectiveDate($now, $sequence);
                        $headDepartment = $this->employee(
                            role: 'HEAD_DEPARTMENT',
                            username: 'kabag.' . strtolower($department->DeptID),
                            fullName: 'Kepala Bagian - ' . $department->Department,
                            directorateId: (string) $directorate->DirID,
                            divisionId: (string) $division->DivID,
                            departmentId: (string) $department->DeptID,
                            jobLevelId: $departmentLevelId,
                            jobTitleId: $this->titleId('Head of ' . $department->Department . ' Department'),
                            reportTo: $headDivision['user_id'],
                            religionId: $religionId,
                            villageId: $villageId,
                            sequence: $sequence,
                            effectiveDate: $effectiveDate,
                            now: $now,
                        );
                        $sequence++;

                        foreach ([1, 2] as $staffNumber) {
                            $effectiveDate = $this->effectiveDate($now, $sequence);
                            $this->employee(
                                role: 'STAFF',
                                username: 'staff' . $staffNumber . '.' . strtolower($department->DeptID),
                                fullName: 'Staff ' . $staffNumber . ' - ' . $department->Department,
                                directorateId: (string) $directorate->DirID,
                                divisionId: (string) $division->DivID,
                                departmentId: (string) $department->DeptID,
                                jobLevelId: $staffLevelId,
                                jobTitleId: $this->titleId($department->Department . ' Staff'),
                                reportTo: $headDepartment['user_id'],
                                religionId: $religionId,
                                villageId: $villageId,
                                sequence: $sequence,
                                effectiveDate: $effectiveDate,
                                now: $now,
                            );
                            $sequence++;
                        }
                    }
                }
            }

            $this->command?->info('Employee Form dummy hierarchy dan relasi Sc_User berhasil disinkronkan.');
        });
    }

    private function employee(
        string $role,
        string $username,
        string $fullName,
        string $directorateId,
        ?string $divisionId,
        ?string $departmentId,
        int $jobLevelId,
        int $jobTitleId,
        ?int $reportTo,
        string $religionId,
        ?int $villageId,
        int $sequence,
        Carbon $effectiveDate,
        Carbon $now,
    ): array {
        [$firstName, $lastName] = $this->nameFor($fullName);
        $email = $username . '@enterprisehub.test';
        $phone = '+628' . str_pad((string) random_int(100000000, 999999999), 9, '0', STR_PAD_LEFT);
        $existingUser = DB::table('sc_user')->where('Username', $username)->first();
        $empFormId = $existingUser?->EmpFormID
            ?? DB::table('tr_empform')->where('Email', $email)->value('EmpFormID');
        $empFormId ??= 'EMP' . $effectiveDate->format('Ym') . '-' . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT);

        while (! $existingUser && DB::table('tr_empform')->where('EmpFormID', $empFormId)->where('Email', '!=', $email)->exists()) {
            $sequence++;
            $empFormId = 'EMP' . $effectiveDate->format('Ym') . '-' . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT);
        }

        $histId = $empFormId . 'H01';
        DB::table('tr_empform')->updateOrInsert(['EmpFormID' => $empFormId], [
            'EmpFormID' => $empFormId,
            'FirstName' => $firstName,
            'LastName' => $lastName,
            'MobileNo' => $phone,
            'BirthDate' => $effectiveDate->copy()->subYears(random_int(24, 50))->subDays(random_int(1, 365))->toDateString(),
            'NIP' => '9' . $effectiveDate->format('Y') . str_pad((string) $sequence, 8, '0', STR_PAD_LEFT),
            'MaritalStatus' => 'S',
            'ReligionID' => $religionId,
            'JoinDate' => $effectiveDate->toDateString(),
            'VillageID' => $villageId,
            'Address' => 'Jl. Dummy Enterprise No. ' . $sequence . ', Jakarta',
            'Email' => $email,
            'InputDate' => $now,
            'InputUser' => 'Admin',
            'ModifDate' => $now,
            'ModifUser' => 'Admin',
        ]);

        DB::table('tr_empformhist')->updateOrInsert(['EmpFormHistID' => $histId], [
            'EmpFormID' => $empFormId,
            'CompID' => 'HO',
            'DirID' => $directorateId,
            'DivID' => $divisionId,
            'DeptID' => $departmentId,
            'JobLvlID' => $jobLevelId,
            'JobTitleID' => $jobTitleId,
            'ReportTo' => $reportTo === null ? null : (string) $reportTo,
            'EmpStatus' => 'NEW',
            'EffectiveDate' => $effectiveDate->toDateString(),
            'Remarks' => 'Dummy Employee Form Request - ' . $role,
            'ReqDate' => $effectiveDate->toDateString(),
            'IsActive' => 1,
            'QRApp' => null,
            'Status' => 'DRAFT',
            'InputDate' => $now,
            'InputUser' => 'Admin',
            'ModifDate' => $now,
            'ModifUser' => 'Admin',
        ]);

        // Reuse existing account IDs to preserve workflow references and roles.
        if ($existingUser) {
            $userId = (int) $existingUser->UserID;
            DB::table('sc_user')->where('UserID', $userId)->update([
                'EmpFormID' => $empFormId,
                'FullName' => mb_substr($fullName, 0, 100),
                'Email' => $email,
                'PhoneNumber' => $phone,
                'IsActive' => true,
                'ModifUser' => 'Admin',
                'ModifDate' => $now,
                'DeletedBy' => null,
                'DeletedDate' => null,
            ]);
        } else {
            $userId = (int) DB::table('sc_user')->insertGetId([
                'EmpFormID' => $empFormId,
                'Username' => $username,
                'FullName' => mb_substr($fullName, 0, 100),
                'Password' => Hash::make((string) env('SEED_USER_PASSWORD', '!23Abcde')),
                'Email' => $email,
                'PhoneNumber' => $phone,
                'Photo' => null,
                'LastLogin' => null,
                'IsActive' => true,
                'InputDate' => $now,
                'InputUser' => 'Admin',
                'ModifDate' => $now,
                'ModifUser' => 'Admin',
                'DeletedBy' => null,
                'DeletedDate' => null,
                'remember_token' => null,
            ]);
        }

        return ['user_id' => $userId, 'emp_form_id' => $empFormId];
    }

    private function ensureAdministratorEmployeeForm(string $religionId, ?int $villageId, Carbon $now): void
    {
        if ($villageId === null) {
            throw new RuntimeException('Master village aktif tidak ditemukan. Jalankan VillageSeeder terlebih dahulu.');
        }

        $email = 'administrator@enterprisehub.com';
        $existing = DB::table('tr_empform')->where('Email', $email)->first()
            ?? DB::table('tr_empform')->where('EmpFormID', 'EMPADMIN00001')->first();
        $employeeFormId = $existing->EmpFormID ?? 'EMPADMIN00001';

        DB::table('tr_empform')->updateOrInsert(
            ['EmpFormID' => $employeeFormId],
            [
                'FirstName' => 'Administrator',
                'LastName' => 'EnterpriseHub',
                'MobileNo' => '123456789',
                'BirthDate' => '1985-01-01',
                'NIP' => 'ADMIN00001',
                'MaritalStatus' => 'S',
                'ReligionID' => $religionId,
                'JoinDate' => '2020-01-01',
                'VillageID' => $villageId,
                'Address' => 'Head Office, Jakarta',
                'Email' => $email,
                'InputDate' => $existing->InputDate ?? $now,
                'InputUser' => $existing->InputUser ?? 'Admin',
                'ModifDate' => $now,
                'ModifUser' => 'Admin',
            ]
        );
    }

    private function religionId(): string
    {
        $id = DB::table('ms_religion')->where('ReligionID', 'ISL')->where('IsActive', 1)->value('ReligionID')
            ?? DB::table('ms_religion')->where('IsActive', 1)->orderBy('ReligionID')->value('ReligionID');
        if ($id === null) {
            throw new RuntimeException('Master agama aktif tidak ditemukan. Jalankan ReligionSeeder terlebih dahulu.');
        }
        return (string) $id;
    }

    private function villageId(): ?int
    {
        $id = DB::table('ms_village')->where('IsActive', 1)->orderBy('VillageID')->value('VillageID');
        return $id === null ? null : (int) $id;
    }

    private function levelId(array $names): int
    {
        foreach ($names as $name) {
            $id = DB::table('ms_job_level')->where('JobLevel', $name)->where('IsActive', 1)->value('JobLevelID');
            if ($id !== null) {
                return (int) $id;
            }
        }
        throw new RuntimeException('Job Level tidak ditemukan: ' . implode(', ', $names));
    }

    private function titleId(string $name): int
    {
        $existing = DB::table('ms_job_title')->where('JobTitle', $name)->first();
        if ($existing) {
            return (int) $existing->JobTitleID;
        }
        return (int) DB::table('ms_job_title')->insertGetId([
            'JobTitle' => $name,
            'IsActive' => 1,
            'InputDate' => now(),
            'InputUser' => 'Admin',
            'ModifDate' => now(),
            'ModifUser' => 'Admin',
            'DeletedBy' => null,
            'DeletedDate' => null,
        ]);
    }

    private function nextSequence(string $ym): int
    {
        $max = 0;
        foreach (DB::table('tr_empform')->where('EmpFormID', 'like', 'EMP' . $ym . '-%')->pluck('EmpFormID') as $id) {
            $max = max($max, (int) substr((string) $id, -3));
        }
        return $max + 1;
    }

    private function effectiveDate(Carbon $now, int $sequence): Carbon
    {
        $start = $now->copy()->startOfMonth();
        $offset = (($sequence - 1) * 7) % $start->daysInMonth;
        return $start->copy()->addDays($offset);
    }

    /** @return array{0:string,1:string} */
    private function nameFor(string $fullName): array
    {
        // Operational account display names are intentionally reflected in Employee Form.
        $parts = preg_split('/\s+/', trim($fullName), 2) ?: [];
        $firstName = $parts[0] ?? 'Employee';
        $lastName = $parts[1] ?? 'EnterpriseHub';
        $candidate = $firstName . ' ' . $lastName;
        if (isset($this->usedFullNames[$candidate])) {
            [$firstName, $lastName] = $this->uniqueName();
            return [$firstName, $lastName];
        }
        $this->usedFullNames[$candidate] = true;
        return [$firstName, $lastName];
    }

    /** @return array{0:string,1:string} */
    private function uniqueName(): array
    {
        $firstNames = ['Andi', 'Budi', 'Citra', 'Dimas', 'Eka', 'Fajar', 'Gita', 'Hendra', 'Indra', 'Joko', 'Kevin', 'Lina', 'Maya', 'Nadia', 'Oscar', 'Putri', 'Raka', 'Salsa', 'Tania', 'Vino', 'Aditya', 'Aldi', 'Arif', 'Bagas', 'Bella', 'Cahyo', 'Daffa', 'Dewi', 'Farhan', 'Febri', 'Galih', 'Intan', 'Irfan', 'Laras', 'Miko', 'Nanda', 'Naufal', 'Rani', 'Rizky'];
        $lastNames = ['Pratama', 'Saputra', 'Wijaya', 'Santoso', 'Kurniawan', 'Permana', 'Nugraha', 'Setiawan', 'Haryanto', 'Ramadhan', 'Firmansyah', 'Gunawan', 'Wibowo', 'Susanto', 'Maulana', 'Siregar', 'Pangestu', 'Hermawan', 'Hakim', 'Kusuma', 'Mahendra', 'Anggara', 'Purnama', 'Utama', 'Suryanto', 'Pranoto', 'Irawan', 'Fauzan', 'Adinata', 'Permadi', 'Kusnadi', 'Kurnia', 'Hidayat', 'Syahputra', 'Ramli', 'Lesmana', 'Nugroho', 'Yulianto'];
        do {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
        } while (isset($this->usedFullNames[$fullName]));
        $this->usedFullNames[$fullName] = true;
        return [$firstName, $lastName];
    }
}
