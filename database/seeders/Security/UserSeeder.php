<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Security\ScUser;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        ScUser::updateOrCreate(
            [
                'Username' => 'admin',
            ],
            [
                'FullName'    => 'Administrator',
                'Password'    => Hash::make('admin123'),
                'RoleID'      => 1,
                'Email'       => 'administrator@enterprisehub.com',
                'PhoneNumber' => '123456789',
                'IsActive'    => true,

                // Karena ini user pertama
                'CreatedBy'   => null,
                'CreatedDate' => now(),

                'UpdatedBy'   => null,
                'UpdatedDate' => null,

                'DeletedBy'   => null,
                'DeletedDate' => null,
            ]
        );
    }
}
