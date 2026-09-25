<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('sc_menu')
            ->where('Code', 'EMPLOYEE_NETWORK_DRIVE')
            ->update([
                'Code' => 'EMPLOYEE_SHARING_FOLDER',
                'Name' => 'Employee Sharing Folder',
                'Route' => 'employee-sharing-folder.index',
                'Icon' => 'bi bi-folder2-open',
                'ModifDate' => $now,
                'ModifUser' => 'Admin',
            ]);

        $masterId = DB::table('sc_menu')
            ->where('Code', 'MASTER')
            ->value('MenuID');

        if ($masterId && !DB::table('sc_menu')->where('Code', 'MASTER_FOLDER_PATH')->exists()) {
            $menuId = DB::table('sc_menu')->insertGetId([
                'ParentID' => $masterId,
                'Code' => 'MASTER_FOLDER_PATH',
                'Name' => 'Folder Path',
                'MenuArea' => 'TOP',
                'Route' => 'master.folder-path.index',
                'URL' => null,
                'Icon' => 'bi bi-folder2',
                'SortOrder' => 99,
                'IsMenu' => 1,
                'IsActive' => 1,
                'InputDate' => $now,
                'InputUser' => 'Admin',
                'ModifDate' => $now,
                'ModifUser' => 'Admin',
                'DeletedBy' => null,
                'DeletedDate' => null,
            ]);

            DB::table('sc_role')
                ->where('IsActive', 1)
                ->where('Code', 'SUPERADMIN')
                ->get()
                ->each(function ($role) use ($menuId, $now) {
                    DB::table('sc_role_menu')->updateOrInsert(
                        [
                            'RoleID' => $role->RoleID,
                            'MenuID' => $menuId,
                        ],
                        [
                            'CanOpen' => 1,
                            'CanAdd' => 1,
                            'CanEdit' => 1,
                            'CanDelete' => 1,
                            'CanPrint' => 1,
                            'CanExport' => 1,
                            'CanApprove' => 1,
                            'IsActive' => 1,
                            'InputDate' => $now,
                            'InputUser' => 'Admin',
                            'ModifDate' => $now,
                            'ModifUser' => 'Admin',
                            'DeletedBy' => null,
                            'DeletedDate' => null,
                        ]
                    );
                });
        }

        $sharingMenuId = DB::table('sc_menu')
            ->where('Code', 'EMPLOYEE_SHARING_FOLDER')
            ->value('MenuID');

        if ($sharingMenuId) {
            DB::table('sc_role')
                ->where('IsActive', 1)
                ->where('Code', 'SUPERADMIN')
                ->get()
                ->each(function ($role) use ($sharingMenuId, $now) {
                    DB::table('sc_role_menu')->updateOrInsert(
                        [
                            'RoleID' => $role->RoleID,
                            'MenuID' => $sharingMenuId,
                        ],
                        [
                            'CanOpen' => 1,
                            'CanAdd' => 1,
                            'CanEdit' => 1,
                            'CanDelete' => 1,
                            'CanPrint' => 1,
                            'CanExport' => 1,
                            'CanApprove' => 1,
                            'IsActive' => 1,
                            'InputDate' => $now,
                            'InputUser' => 'Admin',
                            'ModifDate' => $now,
                            'ModifUser' => 'Admin',
                            'DeletedBy' => null,
                            'DeletedDate' => null,
                        ]
                    );
                });
        }
    }

    public function down(): void
    {
        DB::table('sc_role_menu')
            ->whereIn('MenuID', function ($query) {
                $query->select('MenuID')
                    ->from('sc_menu')
                    ->where('Code', 'MASTER_FOLDER_PATH');
            })
            ->delete();

        DB::table('sc_menu')
            ->where('Code', 'MASTER_FOLDER_PATH')
            ->delete();

        DB::table('sc_menu')
            ->where('Code', 'EMPLOYEE_SHARING_FOLDER')
            ->update([
                'Code' => 'EMPLOYEE_NETWORK_DRIVE',
                'Name' => 'Employee Network Drive',
                'Route' => 'employee-network-drive.index',
                'Icon' => 'bi bi-device-hdd',
            ]);
    }
};
