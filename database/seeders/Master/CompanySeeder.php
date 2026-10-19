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
                'CompID' => 'HO',
            ],
            [
                'Company' => 'Head Office',
                'Description' => 'Head Office',
                'Address' => 'Jakarta',
                'Phone1' => '021000000',
                'Phone2' => '-',
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
