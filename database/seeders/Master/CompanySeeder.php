<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use App\Models\Master\MsCompany;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        MsCompany::create([
            'CompanyCode'    => 'HO',
            'CompanyName'    => 'Head Office',
            'Address' => 'Jakarta',
            'Phone'   => '021000000',
            'Email'   => 'admin@enterprisehub.local',
            'IsActive'       => true,
            'CreatedBy'      => 'SYSTEM',
            'CreatedDate'    => now(),
        ]);
    }
}
