<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentFolderSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            ['PF001', 'Corporate Shared', '\\\\FILESERVER\\EnterpriseHub\\Corporate'],
            ['PF002', 'Human Resources', '\\\\FILESERVER\\EnterpriseHub\\HR'],
            ['PF003', 'Finance & Accounting', '\\\\FILESERVER\\EnterpriseHub\\Finance'],
            ['PF004', 'Information Technology', '\\\\FILESERVER\\EnterpriseHub\\IT'],
            ['PF005', 'General Shared', '\\\\FILESERVER\\EnterpriseHub\\General'],
        ];

        foreach ($rows as [$id, $name, $path]) {
            DB::table('Ms_ParentFolder')->updateOrInsert(
                ['ParentFolderID' => $id],
                [
                    'ParentFolderName' => $name,
                    'ParentFolderPath' => $path,
                    'IsActive' => true,
                    'InputUser' => 'Admin',
                    'InputDate' => $now,
                    'ModifUser' => 'Admin',
                    'ModifDate' => $now,
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]
            );
        }
    }
}
