<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $roleId = DB::table('sc_role')
            ->where('RoleID', 1)
            ->value('RoleID');

        $menuId = DB::table('sc_menu')
            ->where('Code', 'EMPLOYEE_NETWORK_DRIVE')
            ->where('Route', 'employee-network-drive.index')
            ->value('MenuID');

        if (!$roleId || !$menuId) {
            return;
        }

        $now = now();

        DB::table('sc_role_menu')->updateOrInsert(
            [
                'RoleID' => $roleId,
                'MenuID' => $menuId,
            ],
            [
                'CanOpen' => true,
                'CanAdd' => true,
                'CanEdit' => true,
                'CanDelete' => true,
                'CanPrint' => true,
                'CanExport' => true,
                'CanApprove' => true,
                'IsActive' => true,
                'ModifUser' => 'Admin',
                'ModifDate' => $now,
            ]
        );
    }

    public function down(): void
    {
        $roleId = DB::table('sc_role')
            ->where('RoleID', 1)
            ->value('RoleID');

        $menuId = DB::table('sc_menu')
            ->where('Code', 'EMPLOYEE_NETWORK_DRIVE')
            ->where('Route', 'employee-network-drive.index')
            ->value('MenuID');

        if (!$roleId || !$menuId) {
            return;
        }

        DB::table('sc_role_menu')
            ->where('RoleID', $roleId)
            ->where('MenuID', $menuId)
            ->update([
                'CanOpen' => false,
                'CanAdd' => false,
                'CanEdit' => false,
                'CanDelete' => false,
                'CanPrint' => false,
                'CanExport' => false,
                'CanApprove' => false,
                'ModifUser' => 'Admin',
                'ModifDate' => now(),
            ]);
    }
};
