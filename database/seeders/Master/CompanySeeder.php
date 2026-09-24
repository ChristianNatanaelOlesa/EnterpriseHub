<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ms_company')->updateOrInsert(
            [
                'CompanyCode' => 'HO',
            ],
            [
                'CompanyName' => 'Head Office',
                'Address' => 'Jakarta',
                'Phone' => '021000000',
                'Email' => 'admin@enterprisehub.local',
                'IsActive' => true,
                'InputUser' => 'admin',
                'InputDate' => now(),
                'ModifUser' => 'admin',
                'ModifDate' => now(),
            ]
        );
    }
}
