<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sc_user')->updateOrInsert(
            [
                'Username' => 'admin',
            ],
            [
                'FullName' => 'Administrator',
                'Password' => Hash::make('admin123'),
                'Email' => 'administrator@enterprisehub.com',
                'PhoneNumber' => '123456789',
                'IsActive' => true,
                'UpdatedDate' => now(),
            ]
        );
    }
}
