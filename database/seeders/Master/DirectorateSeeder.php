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
            ->where('CompID', 'HO')
            ->value('CompID');

        if ($companyId === null) {
            throw new RuntimeException('Company HO belum tersedia. Jalankan CompanySeeder terlebih dahulu.');
        }

        $rows = [
            ['DirID' => 'BOM', 'Directorate' => 'Board Of Management', 'IsActive' => true],
            ['DirID' => 'CSL', 'Directorate' => 'Claim Service & Loss Adjusting', 'IsActive' => true],
            ['DirID' => 'GRI', 'Directorate' => 'Technical (G)', 'IsActive' => true],
            ['DirID' => 'LRI', 'Directorate' => 'Technical (L)', 'IsActive' => true],
            ['DirID' => 'OTH', 'Directorate' => 'Other', 'IsActive' => true],
            ['DirID' => 'PRD', 'Directorate' => 'President Director', 'IsActive' => true],
            ['DirID' => 'SRU', 'Directorate' => 'Sharia Reinsurance Unit', 'IsActive' => true],
            ['DirID' => 'SUP', 'Directorate' => 'Finance', 'IsActive' => true],
            ['DirID' => 'UNK', 'Directorate' => 'Unknown', 'IsActive' => true],
            ['DirID' => 'SSB', 'Directorate' => 'Sharia Supervisory Board', 'IsActive' => false],
            ['DirID' => 'GAI', 'Directorate' => 'Governance, Risk, and Compliance', 'IsActive' => false],
            ['DirID' => 'CCO', 'Directorate' => 'Corporate Committee', 'IsActive' => false],
        ];

        foreach ($rows as $row) {
            DB::table('ms_directorate')->updateOrInsert(
                ['DirID' => $row['DirID']],
                [
                    'CompID' => $companyId,
                    'Directorate' => $row['Directorate'],
                    'Description' => $row['Directorate'],
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
