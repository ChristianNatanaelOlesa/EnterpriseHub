<?php

namespace Database\Seeders;

use Database\Seeders\Master\CitySeeder;
use Database\Seeders\Master\CompanySeeder;
use Database\Seeders\Master\CountrySeeder;
use Database\Seeders\Master\DepartmentSeeder;
use Database\Seeders\Master\DistrictSeeder;
use Database\Seeders\Master\DivisionSeeder;
use Database\Seeders\Master\DirectorateSeeder;
use Database\Seeders\Master\JobLevelSeeder;
use Database\Seeders\Master\JobTitleSeeder;
use Database\Seeders\Master\ProvinceSeeder;
use Database\Seeders\Master\VillageSeeder;
use Database\Seeders\Security\MenuSeeder;
use Database\Seeders\Security\RoleMenuSeeder;
use Database\Seeders\Security\RoleSeeder;
use Database\Seeders\Security\UserCompanySeeder;
use Database\Seeders\Security\UserDepartmentSeeder;
use Database\Seeders\Security\UserDirectorateSeeder;
use Database\Seeders\Security\UserDivisionSeeder;
use Database\Seeders\Security\UserRoleSeeder;
use Database\Seeders\Security\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Master - geographic
            CountrySeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            VillageSeeder::class,

            // Master - organization
            CompanySeeder::class,
            DirectorateSeeder::class,
            DivisionSeeder::class,
            DepartmentSeeder::class,

            // Master - job
            JobLevelSeeder::class,
            JobTitleSeeder::class,

            // Security
            RoleSeeder::class,
            MenuSeeder::class,
            RoleMenuSeeder::class,
            UserSeeder::class,
            UserRoleSeeder::class,
            UserCompanySeeder::class,
            UserDirectorateSeeder::class,
            UserDivisionSeeder::class,
            UserDepartmentSeeder::class,
        ]);
    }
}
