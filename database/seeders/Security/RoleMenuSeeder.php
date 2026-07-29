<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuSeeder extends Seeder
{
    public function run(): void
    {
        $SuperAdminID = DB::table('Sc_Role')
            ->where('Code', 'SUPERADMIN')
            ->value('ID');

        $Menus = DB::table('Sc_Menu')->get();

        foreach ($Menus as $Menu) {
            DB::table('Sc_RoleMenu')->updateOrInsert(
                [
                    'RoleID' => $SuperAdminID,
                    'MenuID' => $Menu->ID,
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
                    'CreatedDate' => now(),
                ]
            );
        }
    }
}
