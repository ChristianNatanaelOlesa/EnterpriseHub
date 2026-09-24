<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobLevelSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['JobLevel' => 'Sr. General Manager', 'IsActive' => true],
            ['JobLevel' => 'Supervisor', 'IsActive' => true],
            ['JobLevel' => 'Staff', 'IsActive' => true],
            ['JobLevel' => 'Asst. Manager', 'IsActive' => true],
            ['JobLevel' => 'Sr. Staff', 'IsActive' => true],
            ['JobLevel' => 'Temporary Employee', 'IsActive' => true],
            ['JobLevel' => 'Asst. Supervisor', 'IsActive' => true],
            ['JobLevel' => 'Manager', 'IsActive' => true],
            ['JobLevel' => 'Jr. Staff', 'IsActive' => true],
            ['JobLevel' => 'Asst. Director', 'IsActive' => true],
            ['JobLevel' => 'Sr. Manager', 'IsActive' => true],
            ['JobLevel' => 'General Manager', 'IsActive' => true],
            ['JobLevel' => 'Advisor', 'IsActive' => true],
            ['JobLevel' => 'Director', 'IsActive' => true],
            ['JobLevel' => 'Sr. Supervisor', 'IsActive' => true],
            ['JobLevel' => 'Asst. General Manager', 'IsActive' => true],
            ['JobLevel' => 'President Director', 'IsActive' => true],
        ];

        foreach ($rows as $row) {
            DB::table('ms_job_level')->updateOrInsert(
                ['JobLevel' => $row['JobLevel']],
                [
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
