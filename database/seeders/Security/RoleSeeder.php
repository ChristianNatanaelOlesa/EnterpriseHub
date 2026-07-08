<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('Sc_Role')->updateOrInsert(
            [
                'Code' => 'SUPERADMIN',
            ],
            [
                'Name' => 'Super Administrator',
                'Description' => 'Full Access',
                'IsActive' => true,
                'CreatedDate' => now(),
            ]
        );

        DB::table('Sc_Role')->updateOrInsert(
            [
                'Code' => 'ADMIN',
            ],
            [
                'Name' => 'Administrator',
                'Description' => 'Administrator',
                'IsActive' => true,
                'CreatedDate' => now(),
            ]
        );
    }
}
