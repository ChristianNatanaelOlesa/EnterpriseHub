<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Security\ScUser;

class ScUserSeeder extends Seeder
{
    public function run(): void
    {
        ScUser::updateOrCreate(
            [
                'Username' => 'admin',
            ],
            [
                'FullName'     => 'System Administrator',
                'Email'        => 'admin@enterprisehub.local',
                'Password'     => Hash::make('admin123'),
                'IsActive'     => true,

                'CreatedBy'    => null,
                'CreatedDate'  => now(),

                'UpdatedBy'    => null,
                'UpdatedDate'  => null,

                'DeletedBy'    => null,
                'DeletedDate'  => null,
            ]
        );
    }
}
