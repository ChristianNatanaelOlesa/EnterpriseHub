<?php

namespace Database\Seeders\Master;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionSeeder extends Seeder
{
    public function run(): void
    {
        $religions = [
            [
                'ReligionID' => 'ISL',
                'Religion' => 'Islam',
            ],
            [
                'ReligionID' => 'KRI',
                'Religion' => 'Kristen Protestan',
            ],
            [
                'ReligionID' => 'KAT',
                'Religion' => 'Katolik',
            ],
            [
                'ReligionID' => 'HIN',
                'Religion' => 'Hindu',
            ],
            [
                'ReligionID' => 'BUD',
                'Religion' => 'Buddha',
            ],
            [
                'ReligionID' => 'KON',
                'Religion' => 'Konghucu',
            ],
        ];

        foreach ($religions as $religion) {
            DB::table('ms_religion')->updateOrInsert(
                [
                    'ReligionID' => $religion['ReligionID'],
                ],
                [
                    'Religion' => $religion['Religion'],
                    'IsActive' => true,

                    'InputDate' => now(),
                    'InputUser' => 'Admin',

                    'ModifDate' => now(),
                    'ModifUser' => 'Admin',

                    'DeletedBy' => null,
                    'DeletedDate' => null,
                ]
            );
        }

        $this->command?->info(
            'Religion master imported: ' . count($religions) . ' records.'
        );
    }
}
