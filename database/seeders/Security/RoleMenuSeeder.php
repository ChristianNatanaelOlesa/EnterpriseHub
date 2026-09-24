<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRoleId = DB::table('sc_role')
            ->where('RoleID', 1)
            ->value('RoleID');

        if (!$superAdminRoleId) {
            return;
        }

        $menus = DB::table('sc_menu')
            ->where('IsActive', 1)
            ->where('IsMenu', 1)
            ->whereNull('DeletedDate')
            ->get();

        foreach ($menus as $menu) {
            DB::table('sc_role_menu')->updateOrInsert(
                [
                    'RoleID' => $superAdminRoleId,
                    'MenuID' => $menu->MenuID,
                ],
                [
                    'CanOpen'   => 1,
                    'CanAdd'    => 1,
                    'CanEdit'   => 1,
                    'CanDelete' => 1,
                    'CanPrint'  => 1,
                    'CanExport' => 1,
                    'CanApprove' => 1,
                    'IsActive'  => 1,
                ]
            );
        }
    }
}
