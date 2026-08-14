<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Master\CompanySeeder;
use Database\Seeders\Security\RoleSeeder;
use Database\Seeders\Security\MenuSeeder;
use Database\Seeders\Security\RoleMenuSeeder;
use Database\Seeders\Security\UserSeeder;
use Database\Seeders\Security\UserCompanySeeder;
use Database\Seeders\Security\UserDirectorateSeeder;
use Database\Seeders\Security\UserDivisionSeeder;
use Database\Seeders\Security\UserDepartmentSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CompanySeeder::class,
            RoleSeeder::class,
            MenuSeeder::class,
            RoleMenuSeeder::class,
            UserSeeder::class,
            UserCompanySeeder::class,
            UserDirectorateSeeder::class,
            UserDivisionSeeder::class,
            UserDepartmentSeeder::class,
        ]);
    }
}
