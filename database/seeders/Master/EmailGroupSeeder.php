<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailGroupSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $divisionId = DB::table('ms_division')
            ->where('DivID', 20)
            ->value('DivID');

        if (!$divisionId) {
            $divisionId = DB::table('ms_division')
                ->orderBy('DivID')
                ->value('DivID');
        }

        if (!$divisionId) {
            $this->command?->warn('EmailGroupSeeder skipped: no Division found.');
            return;
        }

        $rows = [
            ['EG001', 'it@enterprisehub.com', 'Email Group IT'],
            ['EG002', 'mlink@enterprisehub.com', 'Email MLINK'],
        ];

        foreach ($rows as [$id, $email, $description]) {
            DB::table('ms_email_group')->updateOrInsert(
                ['EmailGroupID' => $id],
                [
                    'DivID' => $divisionId,
                    'Email' => $email,
                    'Description' => $description,
                    'IsGroup' => true,
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
