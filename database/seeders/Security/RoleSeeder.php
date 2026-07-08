<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('Sc_Role')->insert([
            [
                'Code' => 'SUPERADMIN',
                'Name' => 'Super Administrator',
                'Description' => 'Full Access',
                'IsActive' => true,
                'CreatedDate' => now(),
            ],
            [
                'Code' => 'ADMIN',
                'Name' => 'Administrator',
                'Description' => 'Administrator',
                'IsActive' => true,
                'CreatedDate' => now(),
            ],
        ]);
    }
}
