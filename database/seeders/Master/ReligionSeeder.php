<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $religions = [
            ['BDH', 'Buddha'],
            ['CAT', 'Katolik'],
            ['CHR', 'Kristen Protestan'],
            ['HIN', 'Hindu'],
            ['ISL', 'Islam'],
            ['UNK', 'Unknown'],
        ];

        foreach ($religions as [$id, $name]) {
            DB::table('ms_religion')->updateOrInsert(
                ['ReligionID' => $id],
                [
                    'Religion' => $name,
                    'IsActive' => true,
                    'InputDate' => $now,
                    'InputUser' => 'Admin',
                    'ModifDate' => $now,
                    'ModifUser' => 'Admin',
                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]
            );
        }
    }
}
