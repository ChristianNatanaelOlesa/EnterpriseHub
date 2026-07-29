<?php

namespace Database\Seeders;

use Database\Seeders\Security\MenuSeeder;
use Database\Seeders\Security\RoleSeeder;
use Database\Seeders\Security\RoleMenuSeeder;
use Database\Seeders\Security\ScUserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ScUserSeeder::class,
        ]);
    }
}
