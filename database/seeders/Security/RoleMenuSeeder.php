<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminId = DB::table('sc_role')
            ->where('Code', 'SUPERADMIN')
            ->value('RoleID');

        if (! $superAdminId) {
            return;
        }

        $menus = DB::table('sc_menu')
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->get();

        foreach ($menus as $menu) {

            DB::table('sc_role_menu')->updateOrInsert(
                [
                    'RoleID' => $superAdminId,
                    'MenuID' => $menu->MenuID,
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
                    'UpdatedDate' => now(),
                ]
            );
        }
    }
}
