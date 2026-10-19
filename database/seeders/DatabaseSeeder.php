<?php

namespace Database\Seeders;

use Database\Seeders\AssetMasterSeeder;
use Database\Seeders\Master\CocSeeder;
use Database\Seeders\Master\EmailGroupSeeder;
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
use Database\Seeders\Master\ReligionSeeder;
use Database\Seeders\Master\VillageSeeder;
use Database\Seeders\Security\MenuSeeder;
use Database\Seeders\Security\NormalizedSecuritySeeder;
use Database\Seeders\Security\MenuPermissionSeeder;
use Database\Seeders\Security\RolePermissionSeeder;
use Database\Seeders\Security\RoleSeeder;
use Database\Seeders\Security\UserSeeder;
use Database\Seeders\EForm\EmployeeFormSeeder;
use Database\Seeders\UniversalWorkflowSeeder;
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
            ReligionSeeder::class,

            // Master - IT / application
            AssetMasterSeeder::class,
            CocSeeder::class,
            EmailGroupSeeder::class,

            // Employee records must exist before their Sc_User accounts are synced.
            EmployeeFormSeeder::class,

            // Security
            RoleSeeder::class,
            MenuSeeder::class,
            NormalizedSecuritySeeder::class,
            MenuPermissionSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,

            // Universal workflow engine
            UniversalWorkflowSeeder::class,
        ]);
    }
}
