<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class UserSeeder extends Seeder
{
    /**
     * WARNING: This seeder intentionally deletes all current users and their
     * user-scope/role links before rebuilding the test accounts.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $now = now();
            $auditUser = 'Admin';
            $companyId = DB::table('ms_company')
                ->where('CompID', 'HO')
                ->whereNull('DeletedDate')
                ->value('CompID');

            if (! $companyId) {
                throw new RuntimeException('Company HO belum tersedia. Jalankan CompanySeeder terlebih dahulu.');
            }

            $adminEmail = 'administrator@enterprisehub.com';
            $adminEmployeeFormId = DB::table('tr_empform')
                ->where('Email', $adminEmail)
                ->value('EmpFormID');

            if (! $adminEmployeeFormId) {
                throw new RuntimeException('Employee Form administrator belum tersedia. Jalankan EmployeeFormSeeder terlebih dahulu.');
            }

            // Do not hard-delete users: workflow history (wf_instance) references sc_user.
            // Retire legacy accounts and rebuild the intended test accounts in place.
            DB::table('sc_user')->update([
                'IsActive' => false,
                'ModifUser' => $auditUser,
                'ModifDate' => $now,
            ]);

            // Keep the existing administrator ID so historical workflow references remain valid.
            $admin = DB::table('sc_user')->where('Username', 'admin')->first();
            if ($admin) {
                DB::table('sc_user')->where('UserID', $admin->UserID)->update([
                    'EmpFormID' => $adminEmployeeFormId,
                    'FullName' => 'Administrator',
                    'Password' => Hash::make((string) env('SEED_ADMIN_PASSWORD', '!23Abcde')),
                    'Email' => 'administrator@enterprisehub.com',
                    'PhoneNumber' => '123456789',
                    'IsActive' => true,
                    'ModifUser' => $auditUser,
                    'ModifDate' => $now,
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]);
                $adminId = (int) $admin->UserID;
            } else {
                $adminId = DB::table('sc_user')->insertGetId([
                    'EmpFormID' => $adminEmployeeFormId,
                    'Username' => 'admin',
                    'FullName' => 'Administrator',
                    'Password' => Hash::make((string) env('SEED_ADMIN_PASSWORD', '!23Abcde')),
                    'Email' => 'administrator@enterprisehub.com',
                    'PhoneNumber' => '123456789',
                    'IsActive' => true,
                    'InputUser' => $auditUser,
                    'InputDate' => $now,
                    'ModifUser' => $auditUser,
                    'ModifDate' => $now,
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]);
            }

            $superAdminRoleId = DB::table('sc_role')
                ->where('Role', 'Super Administrator')
                ->where('IsActive', true)
                ->whereNull('DeletedDate')
                ->value('RoleID');

            if (! $superAdminRoleId) {
                throw new RuntimeException('Role SUPERADMIN belum tersedia. Jalankan RoleSeeder terlebih dahulu.');
            }

            $adminRole = DB::table('sc_user_role')
                ->where('UserID', $adminId)
                ->where('RoleID', $superAdminRoleId)
                ->first();

            $roleAssignment = [
                'IsActive' => true,
                'ModifUser' => $auditUser,
                'ModifDate' => $now,
                'DeletedBy' => null,
                'DeletedDate' => null,
            ];

            if ($adminRole) {
                DB::table('sc_user_role')
                    ->where('UserRoleID', $adminRole->UserRoleID)
                    ->update($roleAssignment);
            } else {
                DB::table('sc_user_role')->insert($roleAssignment + [
                    'UserID' => $adminId,
                    'RoleID' => $superAdminRoleId,
                    'InputUser' => $auditUser,
                    'InputDate' => $now,
                ]);
            }

            $departments = DB::table('ms_department as d')
                ->join('ms_division as v', 'v.DivID', '=', 'd.DivID')
                ->join('ms_directorate as r', 'r.DirID', '=', 'v.DirID')
                ->where('d.IsActive', true)
                ->where('v.IsActive', true)
                ->where('r.IsActive', true)
                ->whereNull('d.DeletedDate')
                ->whereNull('v.DeletedDate')
                ->whereNull('r.DeletedDate')
                ->select([
                    'd.DeptID', 'd.DeptID', 'd.Department',
                    'v.DivID', 'v.DivID', 'v.Division',
                    'r.DirID', 'r.DirID', 'r.Directorate',
                ])
                ->orderBy('d.DeptID')
                ->get();

            $divisions = DB::table('ms_division as v')
                ->join('ms_directorate as r', 'r.DirID', '=', 'v.DirID')
                ->where('v.IsActive', true)
                ->where('r.IsActive', true)
                ->whereNull('v.DeletedDate')
                ->whereNull('r.DeletedDate')
                ->select([
                    'v.DivID', 'v.DivID', 'v.Division',
                    'r.DirID', 'r.DirID',
                ])
                ->orderBy('v.DivID')
                ->get();

            $directorates = DB::table('ms_directorate')
                ->where('IsActive', true)
                ->whereNull('DeletedDate')
                ->orderBy('DirID')
                ->get(['DirID', 'DirID', 'Directorate']);

            // Two staff accounts and one Kabag account for every active department.
            foreach ($departments as $department) {
                foreach ([1, 2] as $number) {
                    $this->createAccount(
                        username: "staff{$number}." . Str::lower($department->DeptID),
                        fullName: "Staff {$number} - {$department->Department}",
                        email: "staff{$number}." . Str::lower($department->DeptID) . '@enterprisehub.test',
                        companyId: (int) $companyId,
                        directorateId: (int) $department->DirID,
                        divisionId: (int) $department->DivID,
                        departmentId: (int) $department->DeptID,
                        now: $now,
                        auditUser: $auditUser,
                    );
                }

                $this->createAccount(
                    username: 'kabag.' . Str::lower($department->DeptID),
                    fullName: 'Kepala Bagian - ' . $department->Department,
                    email: 'kabag.' . Str::lower($department->DeptID) . '@enterprisehub.test',
                    companyId: (int) $companyId,
                    directorateId: (int) $department->DirID,
                    divisionId: (int) $department->DivID,
                    departmentId: (int) $department->DeptID,
                    now: $now,
                    auditUser: $auditUser,
                );
            }

            // One Kadiv account for every active division.
            foreach ($divisions as $division) {
                $this->createAccount(
                    username: 'kadiv.' . Str::lower($division->DivID),
                    fullName: 'Kepala Divisi - ' . $division->Division,
                    email: 'kadiv.' . Str::lower($division->DivID) . '@enterprisehub.test',
                    companyId: (int) $companyId,
                    directorateId: (int) $division->DirID,
                    divisionId: (int) $division->DivID,
                    departmentId: null,
                    now: $now,
                    auditUser: $auditUser,
                );
            }

            // One Direksi account for every active directorate.
            foreach ($directorates as $directorate) {
                $this->createAccount(
                    username: 'direksi.' . Str::lower($directorate->DirID),
                    fullName: 'Direksi - ' . $directorate->Directorate,
                    email: 'direksi.' . Str::lower($directorate->DirID) . '@enterprisehub.test',
                    companyId: (int) $companyId,
                    directorateId: (int) $directorate->DirID,
                    divisionId: null,
                    departmentId: null,
                    now: $now,
                    auditUser: $auditUser,
                );
            }
        });
    }

    private function createAccount(
        string $username,
        string $fullName,
        string $email,
        int $companyId,
        int $directorateId,
        ?int $divisionId,
        ?int $departmentId,
        $now,
        string $auditUser,
    ): void {
        $employeeFormId = DB::table('tr_empform')->where('Email', $email)->value('EmpFormID');
        if (! $employeeFormId) {
            throw new RuntimeException("Employee Form untuk akun {$username} tidak ditemukan (email: {$email}). Jalankan EmployeeFormSeeder terlebih dahulu.");
        }

        $existing = DB::table('sc_user')->where('Username', $username)->first();

        if ($existing) {
            $userId = (int) $existing->UserID;
            DB::table('sc_user')->where('UserID', $userId)->update([
                'EmpFormID' => $employeeFormId,
                'FullName' => mb_substr($fullName, 0, 100),
                'Email' => $email,
                'IsActive' => true,
                'ModifUser' => $auditUser,
                'ModifDate' => $now,
                'DeletedBy' => null,
                'DeletedDate' => null,
            ]);
        } else {
            $userId = DB::table('sc_user')->insertGetId([
                'EmpFormID' => $employeeFormId,
                'Username' => $username,
                'FullName' => mb_substr($fullName, 0, 100),
                'Password' => Hash::make((string) env('SEED_USER_PASSWORD', '!23Abcde')),
                'Email' => $email,
                'PhoneNumber' => null,
                'IsActive' => true,
                'InputUser' => $auditUser,
                'InputDate' => $now,
                'ModifUser' => $auditUser,
                'ModifDate' => $now,
                'DeletedBy' => null,
                'DeletedDate' => null,
            ]);
        }
    }

    private function insertScope(
        string $table,
        string $scopeColumn,
        int $userId,
        int $scopeId,
        $now,
        string $auditUser,
    ): void {
        $existing = DB::table($table)
            ->where('UserID', $userId)
            ->where($scopeColumn, $scopeId)
            ->first();

        $values = [
            'IsActive' => true,
            'ModifUser' => $auditUser,
            'ModifDate' => $now,
            'DeletedBy' => null,
            'DeletedDate' => null,
        ];

        DB::table($table)->insert($values + [
            'UserID' => $userId,
            $scopeColumn => $scopeId,
            'InputUser' => $auditUser,
            'InputDate' => $now,
        ]);
    }
}
