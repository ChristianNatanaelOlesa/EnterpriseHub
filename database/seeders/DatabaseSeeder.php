<?php

namespace Database\Seeders;

use Database\Seeders\Security\MenuSeeder;
use Database\Seeders\Security\RoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            MenuSeeder::class,
        ]);
    }
}
