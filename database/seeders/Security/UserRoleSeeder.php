<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $userId = DB::table('sc_user')
            ->where('Username', 'admin')
            ->value('UserID');

        $roleId = DB::table('sc_role')
            ->where('Code', 'SUPERADMIN')
            ->value('RoleID');

        if (! $userId || ! $roleId) {
            return;
        }

        DB::table('sc_user_role')->updateOrInsert(
            [
                'UserID' => $userId,
                'RoleID' => $roleId,
            ],
            [
                'IsActive' => true,
                'UpdatedDate' => now(),
            ]
        );
    }
}
