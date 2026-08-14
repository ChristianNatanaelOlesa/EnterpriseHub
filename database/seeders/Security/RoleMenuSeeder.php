<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuSeeder extends Seeder
{
    public function run(): void
    {
        $SuperAdminID = DB::table('sc_role')
            ->where('Code', 'SUPERADMIN')
            ->value('RoleID');

        if (!$SuperAdminID) {
            return;
        }

        $Menus = DB::table('sc_menu')
            ->where('IsActive', true)
            ->get();

        foreach ($Menus as $Menu) {

            DB::table('sc_role_menu')->updateOrInsert(
                [
                    'RoleID' => $SuperAdminID,
                    'MenuID' => $Menu->MenuID,
                ],
                [
                    'CanOpen'    => true,
                    'CanAdd'     => true,
                    'CanEdit'    => true,
                    'CanDelete'  => true,
                    'CanPrint'   => true,
                    'CanExport'  => true,
                    'CanApprove' => true,
                    'IsActive'   => true,
                    'UpdatedDate' => now(),
                ]
            );
        }
    }
}
