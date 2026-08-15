<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sc_role')->updateOrInsert(
            [
                'Code' => 'SUPERADMIN',
            ],
            [
                'Name' => 'Super Administrator',
                'Description' => 'Full access to all modules and features.',
                'IsActive' => true,
                'UpdatedDate' => now(),
            ]
        );
    }
}
