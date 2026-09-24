<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DirectorateSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('ms_company')
            ->where('CompanyCode', 'HO')
            ->value('CompanyID');

        if ($companyId === null) {
            throw new RuntimeException('Company HO belum tersedia. Jalankan CompanySeeder terlebih dahulu.');
        }

        $rows = [
            ['DirectorateCode' => 'BOM', 'DirectorateName' => 'Board Of Management', 'IsActive' => true],
            ['DirectorateCode' => 'CSL', 'DirectorateName' => 'Claim Service & Loss Adjusting', 'IsActive' => true],
            ['DirectorateCode' => 'GRI', 'DirectorateName' => 'Technical (G)', 'IsActive' => true],
            ['DirectorateCode' => 'LRI', 'DirectorateName' => 'Technical (L)', 'IsActive' => true],
            ['DirectorateCode' => 'OTH', 'DirectorateName' => 'Other', 'IsActive' => true],
            ['DirectorateCode' => 'PRD', 'DirectorateName' => 'President Director', 'IsActive' => true],
            ['DirectorateCode' => 'SRU', 'DirectorateName' => 'Sharia Reinsurance Unit', 'IsActive' => true],
            ['DirectorateCode' => 'SUP', 'DirectorateName' => 'Finance', 'IsActive' => true],
            ['DirectorateCode' => 'UNK', 'DirectorateName' => 'Unknown', 'IsActive' => true],
            ['DirectorateCode' => 'SSB', 'DirectorateName' => 'Sharia Supervisory Board', 'IsActive' => false],
            ['DirectorateCode' => 'GAI', 'DirectorateName' => 'Governance, Risk, and Compliance', 'IsActive' => false],
            ['DirectorateCode' => 'CCO', 'DirectorateName' => 'Corporate Committee', 'IsActive' => false],
        ];

        foreach ($rows as $row) {
            DB::table('ms_directorate')->updateOrInsert(
                ['DirectorateCode' => $row['DirectorateCode']],
                [
                    'CompanyID' => $companyId,
                    'DirectorateName' => $row['DirectorateName'],
                    'IsActive' => $row['IsActive'],
                    'InputUser' => 'Admin',
                    'InputDate' => now(),
                    'ModifUser' => 'Admin',
                    'ModifDate' => now(),
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]
            );
        }
    }
}
